<?php

namespace App\Http\Livewire;

use App\Models\CategorieDepense;
use App\Models\LibelleDepense;
use App\Models\TypeDepense;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivLibelleDepense extends Component
{
    use WithPagination;
    public $isLoading, $libelle_id, $libelle, $actif;
    public $afficherListe=true;
    public $createLibelle=false;
    public $editLibelle=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    public $categoriDepenseActifs;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->actif = 1;
    }

    public function render()
    {
        $libelles = LibelleDepense::where('actif', 1)->paginate(10);
        return view('livewire.liv-libelle-depense', [
            'libelles' => $libelles
        ]);
    }

    public function formLibelle()
    {
        $this->isLoading = true;
        $this->createLibelle =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->libelle = '';
        $this->actif = 1;
        $this->resetValidation();
    }

    public function saveLibelle()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'libelle' => 'required|unique:libelle_depenses,libelle',
            'actif' => 'required|integer'
        ]);

        try{

        LibelleDepense::create($data);
        $this->notification = true;
        session()->flash('message', 'Libelle depense enregistré!');
        $this->resetValidation();
        $this->resetInput();
        $this->isLoading = false;
        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createLibelle = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editLibelle($id)
    {
        $this->isLoading = true;

        $libelleDepense = LibelleDepense::findOrFail($id);
        $this->libelle = $libelleDepense->libelle;
        $this->actif = $libelleDepense->actif;
        $this->libelle_id = $id;
        $this->editLibelle = true;
        $this->createLibelle = false;
        $this->btnCreate = false;
        $this->afficherListe = false;
        $this->isLoading = false;
    }

    public function removeNotification()
    {
        $this->dispatchBrowserEvent('removeNotification');
    }

    public function hideNotification()
    {
        $this->notification = false;
    }


    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateLibelle()
    {
        $this->isLoading = true;

        $this->validate([
            'libelle' => 'required|unique:libelle_depenses,libelle,' . $this->libelle_id,
            'actif' => 'required'
        ]);

        try{

            $libelleDepense = LibelleDepense::findOrFail($this->libelle_id);
            $libelleDepense->update([
                'libelle' => $this->libelle,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editLibelle = false;
            $this->notification = true;
            $this->resetInput();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->btnCreate = true;
            $this->afficherListe = true;

            $this->isLoading = false;
        }catch(\Exception $e){

        }

    }

    public function cancelModal()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editLibelle = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editLibelle = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = LibelleDepense::findOrFail($id);
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
            session()->flash('error', 'Le libelle depense est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }

    }

    public function desactiverLibelle()
    {
        $this->recordToDelete->update([
            'actif' => 2,
        ]);
        $this->notification = true;
        session()->flash('message', 'Desactivation avec succée !');
        $this->recordToDelete = null;
    }
}
