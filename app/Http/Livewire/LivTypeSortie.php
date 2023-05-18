<?php

namespace App\Http\Livewire;

use App\Models\TypeOeuf;
use App\Models\TypeSortie;
use Livewire\Component;
use Livewire\WithPagination;

class LivTypeSortie extends Component
{
    use WithPagination;
    public $isLoading, $type_id, $libelle, $actif;
    public $afficherListe=true;
    public $createType=false;
    public $editType=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->actif = 1;
    }

    public function render()
    {
        $types = TypeSortie::paginate(7);
        return view('livewire.liv-type-sortie', [
            'types' => $types
        ]);
    }

    public function formType()
    {
        $this->isLoading = true;
        $this->createType =true;
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

    public function saveType()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'libelle' => 'required|unique:type_sorties,libelle',
            'actif' => 'required|integer'
        ]);

        try{

        TypeSortie::create($data);
        //$this->showToast = true;
        $this->notification = true;
        session()->flash('message', 'Type sortie enregistré!');
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
        $this->createType = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editType($id)
    {
        $this->isLoading = true;

        $typeSortie = TypeSortie::findOrFail($id);
        $this->libelle = $typeSortie->libelle;
        $this->actif = $typeSortie->actif;
        $this->type_id = $id;
        $this->editType = true;
        $this->createType = false;
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

    public function updateType()
    {
        $this->isLoading = true;

        $this->validate([
            'libelle' => 'required|unique:type_sorties,libelle,' . $this->type_id,
            'actif' => 'required'
        ]);

        try{

            $typeSortie = TypeSortie::findOrFail($this->type_id);
            $typeSortie->update([
                'libelle' => $this->libelle,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editType = false;
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
        $this->editType = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editType = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->isLoading = true;
        $this->recordToDelete = TypeSortie::findOrFail($id);
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
            //$this->notification = true;
            session()->flash('error', 'Le type sortie est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }
    }

    public function desactiverType()
    {
        $this->recordToDelete->update([
            'actif' => 2,
        ]);
        $this->notification = true;
        session()->flash('message', 'Desactivation avec succée !');
        $this->recordToDelete = null;
    }

}
