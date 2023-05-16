<?php

namespace App\Http\Livewire;

use App\Models\Site;
use Livewire\Component;
use Livewire\WithPagination;

class LivSite extends Component
{
    use WithPagination;
    public $site_id, $site, $adresse, $actif;
    public $createSite = false, $updateSite = false;

    public $afficherListe = true;
    public $recordToDelete = null;
    public $confirmeDelete;
    public $confirmUpdate;
    protected $paginationTheme = 'bootstrap';
    public $isLoading;
    public $notification = false;
    public $createBtn = true;

    public $nom = "mecene";
    
    public function render()
    {
        $sites = Site::paginate(6);

        return view('livewire.liv-site',[
            'sites' => $sites,
        ]);
    }

    /*
    * creation site
    */
    public function formCreation()
    {
        $this->createSite = true;
        $this->afficherListe = false;

        $this->resetValidation();
    }

    /*
    * annuler creation site
    */
    public function annuler()
    {
        $this->createSite = false;
        $this->afficherListe = true;
        $this->resetValidation();
    }

    /*
    * reset inputs
    */
    public function resetInput()
    {
        $this->site = '';
        $this->adresse = '';
        $this->actif = '';
        $this->resetValidation();
    }

    /*
    * enregistrer site
    */
    public function save()
    {
       $this->isLoading = true;
       $data = $this->validate([
            'site' => 'required|unique:sites,site',
            'adresse' => 'required',
            'actif' => 'required|integer'
        ]);

        Site::create($data);
        session()->flash('message', 'Site enregistré!');
        $this->resetInput();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
    }

    /*
    * editer site
    */
    public function edit($id)
    {
        $this->isLoading = true;
        $objetSite = Site::findOrFail($id);
        $this->site_id = $id;
        $this->site = $objetSite->site;
        $this->adresse = $objetSite->adresse;
        $this->actif = $objetSite->actif;
        $this->createSite = false;
        $this->updateSite = true;
        $this->isLoading = false;
        $this->createBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function cancelModal()
    {
        $this->confirmUpdate = false;
    }

    public function removeNotification()
    {
        $this->dispatchBrowserEvent('removeNotification');
    }

    public function hideNotification()
    {
        $this->notification = false;
    }

    /*
    * modification site
    */
    public function update()
    {
        $this->isLoading = true;
        $this->validate([
            'site' => 'required|unique:sites,site,' .$this->site_id,
            'adresse' => 'nullable',
            'actif' => 'required|integer'
        ]);
  
        $site = Site::find($this->site_id);

        $site->update([
            'site' => $this->site,
            'adresse' => $this->adresse,
            'actif' => $this->actif
        ]);
  
        $this->updateSite = false;
        
        $this->notification = true;
        session()->flash('message', 'Modification avec sucée');
        $this->resetInput();
        $this->resetValidation();
        $this->confirmUpdate = false;
        $this->isLoading = false;
        $this->createBtn = true;
        $this->afficherListe = true;

    }

    public function cancelUpdate()
    {
        $this->updateSite = false;
        $this->resetInput();
        $this->resetValidation();
        $this->createBtn = true;
        $this->afficherListe = true;
    }

    public function comfirmerDelete($id)
    {
        $this->isLoading = true;
        $this->recordToDelete = Site::findOrFail($id);
        $this->isLoading = false;
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
        session()->flash('message', 'Suppression avec sucée');
        }catch(\Exception $e){
            session()->flash('error', 'Impossible de supprimer le site. Il est déja utilisé !');
        }
    }
}
