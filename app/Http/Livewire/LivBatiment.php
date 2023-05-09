<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Site;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivBatiment extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createBatiment = false, $editBatiment= false;

    public $batiment_id, $nom, $id_site, $actif;
    
    public $sitesActif;
    public $confirmUpdate;

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
   protected $paginationTheme = 'bootstrap';
   public $notification;

    public function mount()
    {
        $this->sitesActif = Site::where('actif', 1)->get();
    }

    public function render()
    {
        $batiments = DB::table('batiments')
        ->leftJoin('sites', 'sites.id', '=', 'batiments.id_site')
        ->select('batiments.*','sites.site')
        ->paginate(5);

        return view('livewire.liv-batiment', compact('batiments'));
    }

    public function formBatiment()
    {
        $this->isLoading = true;
        $this->createBatiment = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function resetFormBatiment()
    {
        $this->nom = '';
        $this->id_site = '';
        $this->actif = '';
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveBatiment()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nom' => 'required',
            'id_site' => 'required|integer',
            'actif' => 'required|integer'
        ]);

        try{
        Batiment::create($data);
        $this->resetFormBatiment();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Batiment bien enregistré!');

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createBatiment = false;
        $this->afficherListe = true;
        $this->resetFormBatiment();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editBatiment($id)
    {
        $batiment = Batiment::findOrFail($id);
        $this->batiment_id = $id;
        $this->nom = $batiment->nom;
        $this->id_site = $batiment->id_site;
        $this->actif = $batiment->actif;

        $this->editBatiment = true;
        $this->createBatiment = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateBatiment()
    {
        $this->validate([
            'nom' => 'required',
            'id_site' => 'required',
            'actif' => 'required'
        ]);

        try{
            
            $batiment = Batiment::findOrFail($this->batiment_id);
            $batiment->update([
                'nom' => $this->nom,
                'id_site' => $this->id_site,
                'actif' => $this->actif
            ]);

            $this->editBatiment = false;
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
        $this->editBatiment = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editBatiment = false;
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
        $this->recordToDelete = Batiment::findOrFail($id);
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
