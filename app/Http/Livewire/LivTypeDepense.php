<?php

namespace App\Http\Livewire;

use App\Models\CategorieDepense;
use App\Models\TypeDepense;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivTypeDepense extends Component
{
    use WithPagination;
    public $isLoading, $type_id, $type, $actif, $id_categorie;
    public $afficherListe=true;
    public $createType=false;
    public $editType=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    public $categoriDepenseActifs;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->categoriDepenseActifs = CategorieDepense::where('actif', 1)->get();
        $this->actif = 1;
    }

    public function render()
    {
        $types = DB::table('type_depenses')
        ->leftJoin('categorie_depenses', 'categorie_depenses.id', '=', 'type_depenses.id_categorie')
        ->select('type_depenses.*','categorie_depenses.categorie as categorie_name')
        ->paginate(5);

        return view('livewire.liv-type-depense', [
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
        $this->actif = 1;
        $this->id_categorie = '';
        $this->resetValidation();
    }

    public function saveType()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'type' => 'required|unique:type_depenses,type',
            'id_categorie' => 'required',
            'actif' => 'required|integer'
        ]);

        try{

        TypeDepense::create($data);
        $this->notification = true;
        session()->flash('message', 'Type depense enregistré!');
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

        $typeDepense = TypeDepense::findOrFail($id);
        $this->type = $typeDepense->type;
        $this->id_categorie = $typeDepense->id_categorie;
        $this->actif = $typeDepense->actif;
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
            'type' => 'required|unique:type_depenses,type,' . $this->type_id,
            'id_categorie' => 'required',
            'actif' => 'required'
        ]);

        try{

            $typeDepense = TypeDepense::findOrFail($this->type_id);
            $typeDepense->update([
                'type' => $this->type,
                'id_categorie' => $this->id_categorie,
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
        $this->recordToDelete = TypeDepense::findOrFail($id);
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
            session()->flash('error', 'Le type depense est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }

    }

    public function desactiverTypeDepense()
    {
        $this->recordToDelete->update([
            'actif' => 2,
        ]);
        $this->notification = true;
        session()->flash('message', 'Desactivation avec succée !');
        $this->recordToDelete = null;
    }
}
