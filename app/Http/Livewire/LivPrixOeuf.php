<?php

namespace App\Http\Livewire;

use App\Models\PrixOeuf;
use App\Models\PrixPoulet;
use App\Models\TypeOeuf;
use App\Models\TypePoulet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LivPrixOeuf extends Component
{
    use WithPagination;
    public $isLoading, $prix_id, $id_type_oeuf, $date_application, $pu, $actif, $id_utilisateur;
    public $afficherListe=true;
    public $createPrix=false;
    public $editPrix=false;
    public $notification =false; 
    public $typeOeufActif;
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->typeOeufActif = TypeOeuf::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
    }

    public function render()
    {
        $prixs = DB::table('prix_oeufs')
        ->leftJoin('type_oeufs', 'type_oeufs.id', '=', 'prix_oeufs.id_type_oeuf')
        ->select('prix_oeufs.*','type_oeufs.type')
        ->paginate(5);

        return view('livewire.liv-prix-oeuf', [
            'prixs' => $prixs
        ]);
    }

    public function formPrix()
    {
        $this->isLoading = true;
        $this->createPrix =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->id_type_oeuf = '';
        $this->actif = '';
        $this->date_application = '';
        $this->pu = '';
        $this->resetValidation();
    }

    public function savePrix()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required',
            'actif' => 'required|integer',
            'pu' => 'required',
            'id_utilisateur' => 'nullable',
            'date_application' => 'required'
        ]);

        try{

        PrixOeuf::create($data);
        $this->notification = true;
        session()->flash('message', 'Prix oeuf enregistré!');
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
        $this->createPrix = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editType($id)
    {
        $this->isLoading = true;

        $prixOeuf = PrixOeuf::findOrFail($id);
        $this->id_type_oeuf = $prixOeuf->id_type_oeuf;
        $this->actif = $prixOeuf->actif;
        $this->prix_id = $id;
        $this->pu = $prixOeuf->pu;
        $this->date_application = $prixOeuf->date_application;
        $this->editPrix = true;
        $this->createPrix = false;
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

    public function updatePrix()
    {
        $this->isLoading = true;

        $this->validate([
            'id_type_oeuf' => 'required',
            'actif' => 'required|integer',
            'pu' => 'required',
            'id_utilisateur' => 'nullable',
            'date_application' => 'required',
        ]);

        try{

            $prixOeuf = PrixOeuf::findOrFail($this->prix_id);
            $prixOeuf->update([
                'id_type_oeuf' => $this->id_type_oeuf,
                'pu' => $this->pu,
                'date_application' => $this->date_application,
                'id_utilisateur' => $this->id_utilisateur,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editPrix = false;
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
        $this->editPrix = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editPrix = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = PrixOeuf::findOrFail($id);
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
            session()->flash('error', 'Impossible de supprimer le prix. Il est déja utilisé !');
        }

    }

}
