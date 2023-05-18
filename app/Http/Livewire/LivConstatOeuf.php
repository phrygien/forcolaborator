<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\ConstatOeuf;
use App\Models\Cycle;
use App\Models\TypeOeuf;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivConstatOeuf extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createConstat = false, $editConstat= false;

    public $constat_id, $nb, $id_type_oeuf, $id_cycle, $date_entree, $date_action, $id_utilisateur;

    public $selectedSite;
    public $selectedBatiment;

    public $confirmUpdate;
    public $cycleActifs;
    public $typeOeufActifs;

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;
    //public $;
    // public $data = [];
    // public $labels = [];

    public $data = [];
    public $labels = [];
    public $selectedDate;


    public function mount()
    {
        $this->date_entree = date('Y-m-d');
        $this->date_action = date('Y-m-d');
        $this->typeOeufActifs = TypeOeuf::where('actif', 1)->get();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
        //$this->chargerDonneesChart();
        $this->selectedDate = Date::today()->format('Y-m-d');
        $this->chargerDonneesChart();
    }

    public function afficherTotalDonneesJournalieres()
    {
        $totalDonneesJournalieres = ConstatOeuf::whereDate('date_entree', today())
            ->groupBy('id_type_oeuf')
            ->selectRaw('id_type_oeuf, SUM(nb) as total')
            ->get();
    }

    public function render()
    {
        $constats = DB::table('constat_oeufs')
            ->join('type_oeufs', 'type_oeufs.id', 'constat_oeufs.id_type_oeuf')
            ->join('cycles', 'cycles.id', 'constat_oeufs.id_cycle')
            ->join('users', 'users.id', 'constat_oeufs.id_utilisateur')
            ->select('constat_oeufs.*', 'type_oeufs.type', 'cycles.description', 'users.name')
            ->paginate(10);

            $totalDonneesJournalieres = ConstatOeuf::join('type_oeufs', 'constat_oeufs.id_type_oeuf', '=', 'type_oeufs.id')
            ->whereDate('date_entree', today())
            ->groupBy('id_type_oeuf', 'type_oeufs.type')
            ->selectRaw('id_type_oeuf, type_oeufs.type as nom_type_oeuf, SUM(nb) as total')
            ->get();

        return view('livewire.liv-constat-oeuf', [
            'constats' => $constats,
            'totalDonneesJournalieres' => $totalDonneesJournalieres,
        ]);
    }

    public function formConstat()
    {
        $this->isLoading = true;
        $this->createConstat = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function resetFormConstat()
    {
        $this->id_type_oeuf = '';
        $this->nb = '';
        $this->id_cycle = '';
        $this->date_entree = date('Y-m-d');
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_entree' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable'
        ]);

        DB::beginTransaction();
        $cycleSelected = Cycle::find($this->id_cycle);
        $stockActuale = $cycleSelected->nb_poulet;

        try{
        ConstatOeuf::create($data);
        //update stock cyle selected
        $cycleSelected = Cycle::find($this->id_cycle);
        $stockActuale = $cycleSelected->nb_poulet;
        $cycleSelected->update([
            'nb_poulet' => ($stockActuale + $this->nb),
        ]);
        $cycleSelected->save();

        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Constat oeuf bien enregistré!');
        DB::commit();
        }catch(\Exception $e){
            //return $e->getMessage();
            session()->flash('message', $e->getMessage());
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createConstat = false;
        $this->afficherListe = true;
        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editConstat($id)
    {
        $constat = ConstatOeuf::findOrFail($id);
        $this->constat_id = $id;
        $this->id_type_oeuf = $constat->id_type_oeuf;
        $this->nb = $constat->nb;
        $this->id_cycle = $constat->id_cycle;
        $this->date_entree = $constat->date_entree;
        $this->id_utilisateur = $constat->id_utilisateur;

        $this->editConstat = true;
        $this->createConstat = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateConstat()
    {
        $this->validate([
            'id_type_oeuf' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_entree' => 'required|date',
            'date_action' => 'nullable',
            'id_utilisateur' => 'nullable'
        ]);

        try{
            
            $constat = ConstatOeuf::findOrFail($this->constat_id);
            $constat->update([
                'id_type_oeuf' => $this->id_type_oeuf,
                'nb' => $this->nb,
                'id_cycle' => $this->id_cycle,
                'date_entree' => $this->date_entree,
                'date_action' => $this->date_action,
                'id_utilisateur' => $this->id_utilisateur,
            ]);

            $this->editConstat = false;
            $this->resetFormConstat();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->creatBtn = true;
            $this->notification = true;
            session()->flash('message', 'Modification bien enregistré!');
            $this->afficherListe = true;

        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }

    public function cancelModal()
    {
        $this->confirmUpdate = false;
        $this->editConstat = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editConstat = false;
        $this->resetFormConstat();
        $this->resetValidation();
        $this->creatBtn = true;
        $this->afficherListe = true;
    }

    public function removeNotification()
    {
        $this->dispatchBrowserEvent('removeNotification');
    }

    public function hideNotification()
    {
        $this->notification = false;
    }

    public function comfirmerDelete($id)
    {
        $this->recordToDelete = ConstatOeuf::findOrFail($id);
    }

    public function cancelDelete()
    {
        $this->recordToDelete = null;
    }

    public function delete()
    {
        $this->recordToDelete->delete();
        $this->recordToDelete = null;
        $this->notification = true;
        session()->flash('message', 'Suppression avec succée');
    }


    public function chargerDonneesChart()
    {
        $totalDonneesJournalieres = ConstatOeuf::join('type_oeufs', 'constat_oeufs.id_type_oeuf', '=', 'type_oeufs.id')
            ->whereDate('date_entree', $this->selectedDate)
            ->groupBy('id_type_oeuf', 'type_oeufs.type')
            ->selectRaw('id_type_oeuf, type_oeufs.type as nom_type_oeuf, SUM(nb) as total')
            ->get();

        $this->data = $totalDonneesJournalieres->pluck('total')->toArray();
        $this->labels = $totalDonneesJournalieres->pluck('nom_type_oeuf')->toArray();

        $this->emit('chartUpdated');
    }
}
