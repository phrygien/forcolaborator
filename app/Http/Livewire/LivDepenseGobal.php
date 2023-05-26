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
    $date_entree, $qte, $id_utilisateur, $montant_total, $montant_brut, $montant, $qte_value, $qte_brut, $btn_disabled, $id_depense_brut,
    $date_utilisation, $utilisation_cible;
    
    public $libelleDepenseActifs;
    public $typeDepenseActifs;
    public $typeDepenseActif;
    
    public $confirmUpdate;

    public $recordToDelete;
    public $recordToClose;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $createDetail = false;
    // public $selectedType = '';
    // public $choix_cycle = false;
    // public $choix_site = false;
    // public $cycles, $sites;

    public function mount()
    {
        $this->date_entree = date('Y-m-d');
        $this->libelleDepenseActifs = LibelleDepense::where('actif', 1)->get();
        $this->typeDepenseActifs = TypeDepense::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;

        // $this->typeDepenseActif = TypeDepense::where('actif', 1)->get();
        // $this->cycles = Cycle::where('actif', 1)->get();
        // $this->sites = Site::where('actif', 1)->get();
    }

    // public function updateSelectedType($value)
    // {
    //     $this->resetPage();
    //     $this->resetFormUtilisation();
        
    //     $cibles = [];

    //     if($value ==6){
    //     $cibles = DB::table('cycles')
    //                 ->select('cycles.description as cible, cycles.id as id')
    //                 ->get();
    //     }

    //     if($value ==7){
    //         $cibles = DB::table('sites')
    //         ->select('sites.name as cible, sites.id as id')
    //         ->get();
    //     }

    //     return $cibles;
    // }

    // public function getDepense()
    // {
    //     $depenses = [];
    //     if ($this->selectedType) {
    //         $depenses = DepenseGlobal::where('id_type_depense', $this->selectedType)
    //         ->get();
    //     }

    //     return $depenses;
    // }

    // public function updatedIdDepenseBrut($value)
    // {
    //     if($this->id_depense_brut){
    //         $depense = DepenseGlobal::findOrFail($value);

    //         $this->montant_brut = $depense->montant_total;
    //         $this->qte_brut = $depense->qte;

    //         $this->calculateMontant();

    //         if($depense->id_type_depense == 6){
    //             $this->choix_cycle = true;
    //             $this->choix_site = false;
    //         }

    //         if($depense->id_type_depense == 7){
    //             $this->choix_site = true;
    //             $this->choix_cycle = false;
    //         }
    //     }
    // }

    // public function updatedQteValue()
    // {
    //     $this->calculateMontant();
    //     $this->disponibilite();
    // }

    // public function calculateMontant()
    // {
    //     if (is_numeric($this->qte_value)) {
    //     $this->montant = $this->qte_value * ($this->montant_brut / $this->qte_brut);
    //     }else{
    //         $this->montant = 0;
    //     }
    // }

    // public function disponibilite()
    // {
    //     if($this->qte > $this->qte_brut)
    //     {
    //         session()->flash('error', 'La Qte d\'utilisation ne doit pas >  aux Qte brute'.' / '. 'Qte brute du depense est : '.$this->qte_brut);
    //         $this->btn_disabled = 'disabled';
    //     }else{
    //         $this->btn_disabled = '';
    //     }
    // }

    public function render()
    {
        $depenses = DB::table('depense_globals')
            ->join('libelle_depenses', 'libelle_depenses.id', 'depense_globals.id_libelle_depense')
            ->join('type_depenses', 'type_depenses.id', 'depense_globals.id_type_depense')
            ->join('users', 'users.id', 'depense_globals.id_utilisateur')
            ->select('depense_globals.*', 'libelle_depenses.libelle', 'type_depenses.type', 'users.name')
            ->orderBy('depense_globals.date_entree', 'desc')
            ->paginate(10);

        // $depenses_globals = $this->getDepense();
        return view('livewire.liv-depense-gobal', [
            'depenses' => $depenses,
            // 'depense_globals' => $depenses_globals,
        ]);
    }

    // public function resetFormUtilisation()
    // {
    //     $this->date_utilisation = '';
    //     $this->qte = '';
    //     $this->qte_brut = '';
    //     $this->montant_brut = '';
    //     $this->id_depense_brut = '';
    //     $this->montant = '';
    //     $this->utilisation_cible = '';
    //     $this->creatBtn = false;
    //     $this->resetValidation();
    // }

    public function formDepense()
    {
        $this->isLoading = true;
        $this->createDepense = true;
        $this->createDetail = false;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function formUtilisationDepense()
{
    $this->isLoading = true;
    //$this->createDepense = false;
    $data = $this->validate([
        'id_libelle_depense' => 'required|integer',
        'id_type_depense' => 'required|integer',
        'qte' => 'required|numeric',
        'montant_total' => 'required|numeric',
        'date_entree' => 'required|date',
        'id_utilisateur' => 'nullable',
    ]);

    try {
            DepenseGlobal::create($data);
            $this->createDetail = true;
            $this->createDepense = false;
            $this->resetFormDepense();
            $this->resetValidation();
            $this->isLoading = false;
            $this->notification = true;
            session()->flash('message', 'Dépense globale bien enregistrée!');
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}


    // public function formUtilisationDepense()
    // {
    //     $this->isLoading =true;
    //     $this->createDepense = false;
    //     $data = $this->validate([
    //         'id_libelle_depense' => 'required|integer',
    //         'id_type_depense' => 'required|integer',
    //         'qte' => 'required|numeric',
    //         'montant_total' => 'required|numeric',
    //         'date_entree' => 'required|date',
    //         'id_utilisateur' => 'nullable',
    //     ]);

    //     try{
    //     DepenseGlobal::create($data);
    //     $this->resetFormDepense();
    //     $this->resetValidation();
    //     $this->isLoading = false;
    //     $this->notification = true;
    //     session()->flash('message', 'Depense globale bien enregistré!');
    //     $this->createDetail = true;
        
    //     }catch(\Exception $e){
    //         return $e->getMessage();
    //     }
    // }

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
