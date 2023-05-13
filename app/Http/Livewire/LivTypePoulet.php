<?php

namespace App\Http\Livewire;
use App\Models\TypePoulet;
use Livewire\Component;
use Livewire\WithPagination;

class LivTypePoulet extends Component
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
        $types = TypePoulet::paginate(5);
        return view('livewire.liv-type-poulet', [
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
            'type' => 'required|unique:type_poulets,type',
            'actif' => 'required|integer'
        ]);

        try{

        TypePoulet::create($data);
        $this->notification = true;
        session()->flash('message', 'Type poulet enregistré!');
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

        $typePoulet = TypePoulet::findOrFail($id);
        $this->type = $typePoulet->type;
        $this->actif = $typePoulet->actif;
        $this->type_id = $id;
        $this->editType = true;
        $this->createType = false;
        $this->btnCreate = false;
        $this->isLoading = false;
        $this->afficherListe = false;
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
            'type' => 'required|unique:type_poulets,type,' . $this->type_id,
            'actif' => 'required'
        ]);

        try{

            $typePoulet = TypePoulet::findOrFail($this->type_id);
            $typePoulet->update([
                'type' => $this->type,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editType = false;
            $this->notification = true;
            $this->resetInput();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->afficherListe = true;
            $this->btnCreate = true;

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
        $this->recordToDelete = TypePoulet::findOrFail($id);
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
            session()->flash('error', 'Impossible de supprimer le type. Il est déja utilisé !');
        }

    }

}
