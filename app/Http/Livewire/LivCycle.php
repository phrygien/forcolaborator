<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Cycle;
use App\Models\Site;
use App\Models\TypePoulet;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivCycle extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createCycle = false, $editCycle= false;

    public $cycle_id, $description, $id_type_poulet, $actif,
    $nb_poulet, $id_batiment, $date_entre, $id_utilisateur, $date_fermeture;
    
    public $batimentsActif;
    public $typePouletActif;

    public $selectedSite;
    public $selectedBatiment;

    public $confirmUpdate;

    public $recordToDelete;
    public $recordToClose;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;
    //public $;
    

    public function mount()
    {
        $this->date_entre = date('Y-m-d');
        $this->date_fermeture = date('Y-m-d');
        $this->typePouletActif = TypePoulet::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
    }

    public function render()
    {
        $cycles = DB::table('cycles')
            ->join('batiments', 'batiments.id', 'cycles.id_batiment')
            ->join('type_poulets', 'type_poulets.id', 'cycles.id_type_poulet')
            ->join('sites', 'sites.id', 'batiments.id_site')
            ->select('cycles.*', 'batiments.nom', 'sites.site', 'type_poulets.type')
            ->where('cycles.actif', 1)
            ->paginate(2);

        $sites = $this->getSites();
        $batiments = $this->getBatiments();
        $typePouletActif = TypePoulet::where('actif', 1)->get();

        return view('livewire.liv-cycle', [
            'cycles' => $cycles,
            'sites' => $sites,
            'batiments' => $batiments,
        ]);
    }

    public function getSites()
    {
        return Site::where('actif', 1)->get();
    }
    
    public function getBatiments()
    {
        $batiments = [];
    
        if ($this->selectedSite) {
            $batiments = Batiment::where('id_site', $this->selectedSite)
                        ->where('actif', 1)
                        ->get();
        }
    
        return $batiments;
    }

    public function updatedSelectedSite($value)
    {
        $this->id_batiment = null;
    }

    public function formCycle()
    {
        $this->isLoading = true;
        $this->createCycle = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function resetFormBatiment()
    {
        $this->description = '';
        $this->id_type_poulet = '';
        $this->nb_poulet = '';
        $this->id_batiment = '';
        $this->date_entre = '';
        $this->actif = '';
        $this->creatBtn = false;
        $this->selectedSite = '';
        $this->resetValidation();
    }

    public function saveCycle()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'description' => 'required|unique:cycles,description',
            'id_type_poulet' => 'required|integer',
            'nb_poulet' => 'required|integer',
            'id_batiment' => 'required|integer',
            'date_entre' => 'required|date',
            'actif' => 'required|integer',
            'id_utilisateur' => 'nullable'
        ]);

        try{
        Cycle::create($data);
        $this->resetFormBatiment();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Cycle bien enregistré!');

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createCycle = false;
        $this->afficherListe = true;
        $this->resetFormBatiment();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editCycle($id)
    {
        $cycle = Cycle::findOrFail($id);
        $this->cycle_id = $id;
        $this->description = $cycle->description;
        $this->id_type_poulet = $cycle->id_type_poulet;
        $this->nb_poulet = $cycle->nb_poulet;
        $this->id_batiment = $cycle->id_batiment;
        $this->date_entre = $cycle->date_entre;
        $this->actif = $cycle->actif;
        $this->id_utilisateur = $cycle->id_utilisateur;

        $this->editCycle = true;
        $this->createCycle = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateCycle()
    {
        $this->validate([
            'description' => 'required|unique:cycles,description,'.$this->cycle_id,
            'id_type_poulet' => 'required|integer',
            'nb_poulet' => 'required|integer',
            'id_batiment' => 'required|integer',
            'date_entre' => 'required|date',
            'actif' => 'required|integer',
            'id_utilisateur' => 'nullable'
        ]);

        try{
            
            $cycle = Cycle::findOrFail($this->cycle_id);
            $cycle->update([
                'description' => $this->description,
                'id_type_poulet' => $this->id_type_poulet,
                'nb_poulet' => $this->nb_poulet,
                'id_batiment' => $this->id_batiment,
                'date_entre' => $this->date_entre,
                'actif' => $this->actif,
                'id_utilisateur' => $this->id_utilisateur,
            ]);

            $this->editCycle = false;
            $this->resetFormBatiment();
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
        $this->editCycle = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editCycle = false;
        $this->resetFormBatiment();
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
        $this->recordToDelete = Cycle::findOrFail($id);
    }

    public function cancelDelete()
    {
        $this->recordToDelete = null;
    }

    public function delete()
    {
        try{

        $this->recordToDelete->delete();
        $this->recordToDelete = null;
        $this->notification = true;
        session()->flash('message', 'Suppression avec succée');

        }catch(\Exception $e){
            //$this->notification = true;
            session()->flash('error', 'Impossible de supprimer le cycle. Il est déja utilisé !');
        }
    }

    public function comfirmerFermeture($id)
    {
        $this->recordToClose = Cycle::findOrFail($id);
    }

    public function setCycleInactif()
    {
        try{
            $this->recordToClose->update([
                'id_utilisateur' => $this->id_utilisateur,
                'date_fermeture' => $this->date_fermeture,
            ]);
            $this->notification = true;
            session()->flash('message', 'Cycle bien fermé !');
            $this->recordToClose = null;
        }catch(\Exception $e){
            //$this->notification = true;
            session()->flash('message', 'Fermeture du cycle echoue !');
        }
    }

    public function cancelClose()
    {
        $this->recordToClose = null;
    }

}
