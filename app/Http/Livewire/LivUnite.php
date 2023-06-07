<?php

namespace App\Http\Livewire;

use App\Models\Unite;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivUnite extends Component
{
    use WithPagination;
    public $isLoading, $unite_id, $unite, $label, $actif;
    public $afficherListe=true;
    public $createUnite=false;
    public $editUnite=false;
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
        $unites = Unite::where('actif', 1)->paginate(10);
        return view('livewire.liv-unite', [
            'unites' => $unites
        ]);
    }

    public function formLibelle()
    {
        $this->isLoading = true;
        $this->createUnite =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->unite = '';
        $this->label = '';
        $this->actif = 1;
        $this->resetValidation();
    }

    public function saveUnite()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'unite' => 'required|unique:unites,unite',
            'label' => 'required',
            'actif' => 'required|integer'
        ]);

        try{

        Unite::create($data);
        $this->notification = true;
        session()->flash('message', 'Unite depense enregistré!');
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
        $this->createUnite = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editUnite($id)
    {
        $this->isLoading = true;

        $unite = Unite::findOrFail($id);
        $this->unite = $unite->unite;
        $this->label = $unite->label;
        $this->actif = $unite->actif;
        $this->unite_id = $id;
        $this->editUnite = true;
        $this->createUnite = false;
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

    public function updateUnite()
    {
        $this->isLoading = true;

        $this->validate([
            'unite' => 'required|unique:unites,unite,' . $this->unite_id,
            'label' => 'required',
            'actif' => 'required'
        ]);

        try{

            $unite = Unite::findOrFail($this->unite_id);
            $unite->update([
                'unite' => $this->unite,
                'label' => $this->label,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editUnite = false;
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
        $this->editUnite = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editUnite = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = Unite::findOrFail($id);
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
            session()->flash('error', 'L\'unite depense est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }

    }

    public function desactiverUnite()
    {
        $this->recordToDelete->update([
            'actif' => 2,
        ]);
        $this->notification = true;
        session()->flash('message', 'Desactivation avec succée !');
        $this->recordToDelete = null;
    }
}
