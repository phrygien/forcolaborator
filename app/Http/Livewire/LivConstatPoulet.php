<?php

namespace App\Http\Livewire;

use App\Models\ConstatOeuf;
use App\Models\ConstatPoulet;
use App\Models\Cycle;
use App\Models\TypeOeuf;
use App\Models\TypePoulet;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivConstatPoulet extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createConstat = false, $editConstat= false;

    public $constat_id, $nb, $id_type_poulet, $id_cycle, $date_constat, $date_action, $id_utilisateur;

    public $confirmUpdate;
    public $typePouletActifs;
    public $cycleActifs;

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $data = [];
    public $labels = [];
    public $selectedDate;


    public function mount()
    {
        $this->date_action = date('Y-m-d');
        $this->date_constat = date('Y-m-d');
        $this->typePouletActifs = TypePoulet::where('actif', 1)->get();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
    }

    public function render()
    {
        $constats = DB::table('constat_poulets')
            ->join('type_poulets', 'type_poulets.id', 'constat_poulets.id_type_poulet')
            ->join('cycles', 'cycles.id', 'constat_poulets.id_cycle')
            ->join('users', 'users.id', 'constat_poulets.id_utilisateur')
            ->select('constat_poulets.*', 'type_poulets.type', 'cycles.description', 'users.name')
            ->paginate(2);

        return view('livewire.liv-constat-poulet', [
            'constats' => $constats
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
        $this->id_type_poulet = '';
        $this->nb = '';
        $this->id_cycle = '';
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_poulet' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable'
        ]);

        try{
        ConstatPoulet::create($data);
        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Constat poulet bien enregistré!');

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
        $constat = ConstatPoulet::findOrFail($id);
        $this->constat_id = $id;
        $this->id_type_poulet = $constat->id_type_poulet;
        $this->nb = $constat->nb;
        $this->id_cycle = $constat->id_cycle;
        $this->date_constat = $constat->date_constat;
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
            'id_type_poulet' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'date_action' => 'nullable',
            'id_utilisateur' => 'nullable'
        ]);

        try{
            
            $constat = ConstatPoulet::findOrFail($this->constat_id);
            $constat->update([
                'id_type_poulet' => $this->id_type_poulet,
                'nb' => $this->nb,
                'id_cycle' => $this->id_cycle,
                'date_constat' => $this->date_constat,
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
        $this->recordToDelete = ConstatPoulet::findOrFail($id);
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

}
