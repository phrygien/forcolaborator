<?php

namespace App\Http\Livewire;

use App\Models\Cycle;
use App\Models\DepenseGlobal;
use App\Models\Site;
use App\Models\TypeDepense;
use App\Models\UtilisationDepenese;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LivCreateDetail extends Component
{
    public $utilisation_id, $date_utilisation, $qte_brut, $qte, $montant, $utilisation_cible, $id_depense_brut, $montant_brut;
    public $selectedType = '';
    public $depenseglobals;
    public $typeDepenseActif;
    public $isLoading;
    protected $paginationTheme = 'bootstrap';
    public $notification;
    public $btn_disabled = '';

    public $choix_cycle = false;
    public $choix_site = false;
    public $cycles, $sites;
    public $afficherListe = true;
    public $createDetail = true;

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
            ->orderByDesc('date_entree')
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
        $this->montant = $this->qte * ($this->montant_brut / $this->qte_brut);
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
        $depenses = $this->getDepense();
        return view('livewire.liv-create-detail', [
            'depenses' => $depenses
        ]);
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
        $this->resetValidation();
    }

    public function saveUtilisation()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'selectedType' => 'required',
            'date_utilisation' => 'required|date',
            'qte' => 'required|numeric',
            'montant' => 'required|numeric',
            'utilisation_cible' => 'required',
            'id_depense_brut' => 'required|integer'
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
        $this->createDetail = false;
        $this->afficherListe = true;
        $this->resetFormUtilisation();
        $this->resetValidation();
        $this->isLoading = false;
        //$this->creatBtn = true;
    }

    public function removeNotification()
    {
        $this->dispatchBrowserEvent('removeNotification');
    }

    public function hideNotification()
    {
        $this->notification = false;
    }
}
