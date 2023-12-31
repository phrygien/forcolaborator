<?php

namespace App\Http\Livewire;

use App\Models\Cycle;
use App\Models\DepenseGlobal;
use App\Models\Site;
use App\Models\TypeDepense;
use App\Models\UtilisationDepenese;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\VarDumper\VarDumper;

class LivUtilisationDepense extends Component
{
    use WithPagination;
    public $afficherListe = true;
    
    public $createUtilisation = false, $editUtilisation = false;

    public $utilisation_id, $date_utilisation, $qte_brut, $qte, $montant, $utilisation_cible, $id_depense_brut, $montant_brut;
    public $edit_montant_brut, $edit_qte_brut;
    public $selectedType = '';
    public $depenseglobals;
    public $typeDepenseActif;
    public $idLibelleDepense;

    public $confirmUpdate;
    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;
    public $btn_disabled = '';

    public $choix_cycle = false;
    public $choix_site = false;
    public $cycles, $sites;

    public function mount()
    {
        $this->typeDepenseActif = TypeDepense::where('actif', 1)->get();
        $this->cycles = Cycle::where('actif', 1)->get();
        $this->sites = Site::where('actif', 1)->get();
    }

    public function updateSelectedType($value)
    {
        $this->resetPage();
        $this->resetFormUtilisation();
        
        $cibles = [];

        if($value ==6){
        $cibles = DB::table('cycles')
                    ->select('cycles.description as cible, cycles.id as id')
                    ->get();
        }

        if($value ==7){
            $cibles = DB::table('sites')
            ->select('sites.name as cible, sites.id as id')
            ->get();
        }

        return $cibles;
    }

    public function getDepense()
    {
        $depenses = [];
        if ($this->selectedType) {
            $depenses = DepenseGlobal::where('id_type_depense', $this->selectedType)
            ->get();
        }

        return $depenses;
    }

    public function updatedIdDepenseBrut($value)
    {
        if($this->id_depense_brut){
            $depense = DepenseGlobal::findOrFail($value);

            $this->montant_brut = $depense->montant_total;
            $this->qte_brut = $depense->qte;

            $this->calculateMontant();

            if($depense->id_type_depense == 6){
                $this->choix_cycle = true;
                $this->choix_site = false;
            }

            if($depense->id_type_depense == 7){
                $this->choix_site = true;
                $this->choix_cycle = false;
            }
        }
    }

    public function updatedQte()
    {
        $this->calculateMontant();
        $this->disponibilite();
    }

    public function calculateMontant()
    {
        if (is_numeric($this->qte)) {
            $this->montant = $this->qte * round( ($this->montant_brut / $this->qte_brut), 2);
        }else{
            $this->montant = 0;
        }
    }

    public function disponibilite()
    {
        if($this->qte > $this->qte_brut)
        {
            session()->flash('error', 'La Qte d\'utilisation ne doit pas >  aux Qte brute'.' / '. 'Qte brute du depense est : '.$this->qte_brut);
            $this->btn_disabled = 'disabled';
        }else{
            $this->btn_disabled = '';
        }
    }

    public function render()
    {
        $utilisations = DB::table('utilisation_depenses')
                        ->join('depense_globals', 'depense_globals.id', 'utilisation_depenses.id_depense_brut')
                        ->join('libelle_depenses', 'libelle_depenses.id', 'depense_globals.id_libelle_depense')
                        ->join('type_depenses', 'type_depenses.id', 'depense_globals.id_type_depense')
                        ->select('utilisation_depenses.*','libelle_depenses.libelle','type_depenses.type')
                        ->orderByDesc('utilisation_depenses.date_utilisation', 'desc')
                        ->paginate(10);

        $depenses = $this->getDepense();

        return view('livewire.liv-utilisation-depense', [
            'utilisations' => $utilisations,
            'depenses' => $depenses,
        ]);
    }

    public function formUtilisation()
    {
        $this->isLoading = true;
        $this->createUtilisation = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function resetFormUtilisation()
    {
        $this->date_utilisation = '';
        $this->qte = '';
        $this->qte_brut = '';
        $this->montant_brut = '';
        $this->id_depense_brut = '';
        $this->montant = '';
        $this->utilisation_cible = '';
        $this->selectedType = '';
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveUtilisation()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'date_utilisation' => 'required|date',
            'qte' => 'required|numeric',
            'montant' => 'required|numeric',
            'utilisation_cible' => 'required',
            'id_depense_brut' => 'required|integer',
            'selectedType' => 'required',
            'montant_brut' => 'required|numeric',
            'qte_brut' => 'required|numeric'
        ]);

        try{
            UtilisationDepenese::create($data);
            $this->resetFormUtilisation();
            $this->resetValidation();
            $this->notification = true;
            session()->flash('message', 'Utilisation depense bien enregistré');
            $this->isLoading = false;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createUtilisation = false;
        $this->afficherListe = true;
        $this->resetFormUtilisation();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editUtilisation($id)
    {
        $utilisation = UtilisationDepenese::findOrFail($id);
        $this->utilisation_id = $id;
        $this->date_utilisation = $utilisation->date_utilisation;
        $this->qte = $utilisation->qte;
        $this->montant = $utilisation->montant;
        $this->utilisation_cible = $utilisation->utilisation_cible;
        $this->id_depense_brut = $utilisation->id_depense_brut;
        
        //avoir depense brute lié
        $depenseBrutUtilise = DepenseGlobal::where('id', $utilisation->id_depense_brut)->first();
        $this->montant_brut = $depenseBrutUtilise->montant_total;
        $this->qte_brut = $depenseBrutUtilise->qte;

        // avoir type de depense du depense brut utilisé
        $typeDepenseBrut = TypeDepense::where('id', $depenseBrutUtilise->id_type_depense)->first();
        $this->selectedType = $typeDepenseBrut->id; 
        //if($this->utilisation_cible == '')
        $this->editUtilisation = true;
        $this->createUtilisation = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateUtilisation()
    {
        $this->validate([
            'date_utilisation' => 'required|date',
            'qte' => 'required|numeric',
            'montant' => 'required|numeric',
            'utilisation_cible' => 'required',
            'id_depense_brut' => 'required',
        ]);

        try{
            
            $utilisation = UtilisationDepenese::findOrFail($this->utilisation_id);
            $utilisation->update([
                'date_utilisation' => $this->date_utilisation,
                'qte' => $this->qte,
                'montant' => $this->montant,
                'utilisation_cible' => $this->utilisation_cible,
                //'date_entree' => $this->date_entree,
                'id_depense_brut' => $this->id_depense_brut,
            ]);

            $this->editUtilisation = false;
            $this->resetFormUtilisation();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->creatBtn = true;
            $this->notification = true;
            session()->flash('message', 'Modification bien enregistré!');
            $this->afficherListe = true;

        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }

    public function cancelModal()
    {
        $this->confirmUpdate = false;
        $this->editUtilisation = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editUtilisation = false;
        $this->resetFormUtilisation();
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
        $this->recordToDelete = UtilisationDepenese::findOrFail($id);
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
            session()->flash('error', 'Impossible de supprimer utilisation depense. Il est déja utilisé !');
        }
    }
}
