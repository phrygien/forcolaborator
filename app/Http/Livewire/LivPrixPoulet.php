<?php

namespace App\Http\Livewire;

use App\Models\PrixPoulet;
use App\Models\TypePoulet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LivPrixPoulet extends Component
{
    use WithPagination;
    public $isLoading, $prix_id, $id_type_poulet, $date_application, $pu_kg, $actif, $id_utilisateur;
    public $afficherListe=true;
    public $createPrix=false;
    public $editPrix=false;
    public $notification =false; 
    public $typePouletActif;
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->typePouletActif = TypePoulet::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
        $this->actif = 1;
    }

    public function render()
    {
        $prixs = DB::table('prix_poulets')
        ->leftJoin('type_poulets', 'type_poulets.id', '=', 'prix_poulets.id_type_poulet')
        ->select('prix_poulets.*','type_poulets.type')
        ->paginate(5);

        return view('livewire.liv-prix-poulet', [
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
        $this->id_type_poulet = '';
        $this->actif = 1;
        $this->date_application = '';
        $this->pu_kg = '';
        $this->resetValidation();
    }

    public function savePrix()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_poulet' => 'required',
            'actif' => 'required|integer',
            'pu_kg' => 'required',
            'id_utilisateur' => 'nullable',
            'date_application' => 'required|unique:prix_poulets,date_application'
        ]);

        try{

        PrixPoulet::create($data);
        $this->notification = true;
        session()->flash('message', 'Prix poulet enregistré!');
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

        $prixPoulet = PrixPoulet::findOrFail($id);
        $this->id_type_poulet = $prixPoulet->id_type_poulet;
        $this->actif = $prixPoulet->actif;
        $this->prix_id = $id;
        $this->pu_kg = $prixPoulet->pu_kg;
        $this->date_application = $prixPoulet->date_application;
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
            'id_type_poulet' => 'required',
            'actif' => 'required|integer',
            'pu_kg' => 'required',
            'id_utilisateur' => 'nullable',
            'date_application' => 'required|unique:prix_poulets,date_application, '.$this->prix_id,
        ]);

        try{

            $prixPoulet = PrixPoulet::findOrFail($this->prix_id);
            $prixPoulet->update([
                'id_type_poulet' => $this->id_type_poulet,
                'pu_kg' => $this->pu_kg,
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
        $this->recordToDelete = PrixPoulet::findOrFail($id);
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
            session()->flash('error', 'Le prix poulet est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }

    }

    public function desactiverPrix()
    {
        $this->recordToDelete->update([
            'actif' => 2,
        ]);
        $this->notification = true;
        session()->flash('message', 'Desactivation avec succée !');
        $this->recordToDelete = null;
    }

}
