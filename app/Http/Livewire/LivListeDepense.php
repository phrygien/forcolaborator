<?php

namespace App\Http\Livewire;
use App\Models\Listedepense;
use App\Models\Unite;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivListeDepense extends Component
{
    use WithPagination;
    public $isLoading;
    public $liste_id, $nom_depense, $id_unite, $cycle_concerne, $affectation, $type, $nb_annee_amortissement, $actif;
    public $afficherListe=true;
    public $createListe=false;
    public $editListe=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    public $unites;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->actif = 2;
        $this->unites = Unite::where('actif', 1)->get();
    }

    public function render()
    {
        $listes = DB::table('listedepenses')
                ->join('unites', 'unites.id', 'listedepenses.id_unite')
                ->select('listedepenses.*', 'unites.unite', 'unites.label')
                //->where('listedepenses.actif', '<>',2)
                ->paginate(15);
        return view('livewire.liv-liste-depense', [
            'listes' => $listes
        ]);
    }

    public function formListe()
    {
        $this->isLoading = true;
        $this->createListe =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->nom_depense = '';
        $this->id_unite = '';
        $this->cycle_concerne = '';
        $this->affectation = '';
        $this->type = '';
        $this->nb_annee_amortissement = '';
        $this->actif = 2;
        $this->resetValidation();
    }

    public function saveListe()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nom_depense' => 'required',
            'id_unite' => 'required',
            'cycle_concerne' => 'required',
            'affectation' => 'required',
            'type' => 'required',
            'nb_annee_amortissement' => 'required',
            'actif' => 'required|integer'
        ]);

        try{

        Listedepense::create($data);
        $this->notification = true;
        session()->flash('message', 'Liste depense enregistré!');
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
        $this->createListe = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editListe($id)
    {
        $this->isLoading = true;

        $liste = Listedepense::findOrFail($id);
        $this->nom_depense = $liste->nom_depense;
        $this->id_unite = $liste->id_unite;
        $this->cycle_concerne = $liste->cycle_concerne;
        $this->affectation = $liste->affectation;
        $this->type = $liste->type;
        $this->nb_annee_amortissement = $liste->nb_annee_amortissement;
        $this->actif = $liste->actif;
        $this->liste_id = $id;
        $this->editListe = true;
        $this->createListe = false;
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

    public function updateListe()
    {
        $this->isLoading = true;

        $this->validate([
            'nom_depense' => 'required',
            'id_unite' => 'required',
            'cycle_concerne' => 'required',
            'affectation' => 'required',
            'type' => 'required',
            'nb_annee_amortissement',
            'actif' => 'required|integer'
        ]);

        try{

            $liste = Listedepense::findOrFail($this->liste_id);
            $liste->update([
                'nom_depense' => $this->nom_depense,
                'id_unite' => $this->id_unite,
                'cycle_concerne' => $this->cycle_concerne,
                'affectation' => $this->affectation,
                'type' => $this->type,
                'nb_annee_ammortissement' => $this->nb_annee_amortissement,
                'actif' => $this->actif
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editListe = false;
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
        $this->editListe = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editListe = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = Listedepense::findOrFail($id);
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
            session()->flash('error', 'Liste depense est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
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
