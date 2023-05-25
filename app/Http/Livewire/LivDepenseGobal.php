<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Cycle;
use App\Models\DepenseGlobal;
use App\Models\LibelleDepense;
use App\Models\Site;
use App\Models\TypeDepense;
use App\Models\TypePoulet;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivDepenseGobal extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createDepense = false, $editDepense= false;

    public $depense_id, $id_libelle_depense, $id_type_depense,
    $date_entree, $qte, $id_utilisateur, $montant_total;
    
    public $libelleDepenseActifs;
    public $typeDepenseActifs;

    public $confirmUpdate;

    public $recordToDelete;
    public $recordToClose;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $createDetail = false;

    public function mount()
    {
        $this->date_entree = date('Y-m-d');
        $this->libelleDepenseActifs = LibelleDepense::where('actif', 1)->get();
        $this->typeDepenseActifs = TypeDepense::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
    }

    public function render()
    {
        $depenses = DB::table('depense_globals')
            ->join('libelle_depenses', 'libelle_depenses.id', 'depense_globals.id_libelle_depense')
            ->join('type_depenses', 'type_depenses.id', 'depense_globals.id_type_depense')
            ->join('users', 'users.id', 'depense_globals.id_utilisateur')
            ->select('depense_globals.*', 'libelle_depenses.libelle', 'type_depenses.type', 'users.name')
            ->orderBy('depense_globals.date_entree', 'desc')
            ->paginate(10);

        return view('livewire.liv-depense-gobal', [
            'depenses' => $depenses,
        ]);
    }


    public function formDepense()
    {
        $this->isLoading = true;
        $this->createDepense = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function formUtilisationDepense()
    {
        $this->isLoading =true;
        $this->createDetail = true;
        $this->isLoading = false;
    }

    public function resetFormDepense()
    {
        $this->id_libelle_depense = '';
        $this->qte = '';
        $this->id_type_depense = '';
        $this->date_entree = date('Y-m-d');;
        $this->creatBtn = false;
        $this->montant_total = '';
        $this->resetValidation();
    }

    public function saveDepense()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_libelle_depense' => 'required|integer',
            'id_type_depense' => 'required|integer',
            'qte' => 'required|numeric',
            'montant_total' => 'required|numeric',
            'date_entree' => 'required|date',
            'id_utilisateur' => 'nullable',
        ]);

        try{
        DepenseGlobal::create($data);
        $this->resetFormDepense();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Depense globale bien enregistré!');

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createDepense = false;
        $this->afficherListe = true;
        $this->resetFormDepense();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editDepense($id)
    {
        $depense = DepenseGlobal::findOrFail($id);
        $this->depense_id = $id;
        $this->id_libelle_depense = $depense->id_libelle_depense;
        $this->id_type_depense = $depense->id_type_depense;
        $this->qte = $depense->qte;
        $this->montant_total = $depense->montant_total;
        $this->date_entree = $depense->date_entree;
        $this->id_utilisateur = $depense->id_utilisateur;

        $this->editDepense = true;
        $this->createDepense = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateDepense()
    {
        $this->validate([
            'id_libelle_depense' => 'required|integer',
            'id_type_depense' => 'required|integer',
            'qte' => 'required|numeric',
            'montant_total' => 'required|numeric',
            'date_entree' => 'required|date',
            'id_utilisateur' => 'nullable',
        ]);

        try{
            
            $depense = DepenseGlobal::findOrFail($this->depense_id);
            $depense->update([
                'id_libelle_depense' => $this->id_libelle_depense,
                'id_type_depense' => $this->id_type_depense,
                'qte' => $this->qte,
                'montant_total' => $this->montant_total,
                'date_entree' => $this->date_entree,
                'id_utilisateur' => $this->id_utilisateur,
            ]);

            $this->editDepense = false;
            $this->resetFormDepense();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->creatBtn = true;
            $this->notification = true;
            session()->flash('message', 'Modification depense global bien enregistré!');
            $this->afficherListe = true;

        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }

    public function cancelModal()
    {
        $this->confirmUpdate = false;
        $this->editDepense = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editDepense = false;
        $this->resetFormDepense();
        $this->resetValidation();
        $this->creatBtn = true;
        $this->afficherListe = true;
    }

    public function removeNotification()
    {
        $this->dispatchBrowserEvent('removeNotification');
    }

    public function hideNotification()
    {
        $this->notification = false;
    }

    public function comfirmerDelete($id)
    {
        $this->recordToDelete = DepenseGlobal::findOrFail($id);
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
        session()->flash('message', 'Suppression avec succée');

        }catch(\Exception $e){
            //$this->notification = true;
            session()->flash('error', 'Impossible de supprimer le depense global. Il est déja utilisé !');
        }
    }
}
