<?php

namespace App\Http\Livewire;

use App\Models\ConstatOeuf;
use App\Models\TypeOeuf;
use Livewire\Component;
use Livewire\WithPagination;

class LivTypeOeuf extends Component
{
    use WithPagination;
    public $isLoading, $type_id, $type, $actif;
    public $afficherListe=true;
    public $createType=false;
    public $editType=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $types = TypeOeuf::paginate(7);
        return view('livewire.liv-type-oeuf', [
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
        $this->type = '';
        $this->actif = '';
        $this->resetValidation();
    }

    public function saveType()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'type' => 'required|unique:type_oeufs,type',
            'actif' => 'required|integer'
        ]);

        try{

        TypeOeuf::create($data);
        $this->notification = true;
        session()->flash('message', 'Type oeuf enregistré!');
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

        $typeOeuf = TypeOeuf::findOrFail($id);
        $this->type = $typeOeuf->type;
        $this->actif = $typeOeuf->actif;
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
            'type' => 'required|unique:type_oeufs,type,' . $this->type_id,
            'actif' => 'required'
        ]);

        try{

            $typeOeuf = TypeOeuf::findOrFail($this->type_id);
            $typeOeuf->update([
                'type' => $this->type,
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
        $this->recordToDelete = TypeOeuf::findOrFail($id);
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
            session()->flash('error', 'Impossible de supprimer le categorie. Il est déja utilisé !');
        }
    }

}
