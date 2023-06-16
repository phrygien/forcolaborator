<?php

namespace App\Http\Livewire;

use App\Models\Cycle;
use App\Models\DepenseCycle;
use App\Models\DepenseDetail;
use App\Models\EngagementCharge;
use App\Models\Listedepense;
use App\Models\PrixPoulet;
use App\Models\Site;
use App\Models\TypePoulet;
use App\Models\UtilisactionCharge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LivUtilisationCharge extends Component
{
    use WithPagination;
    public $isLoading, $utilisation_id, $id_depense, $id_cycle, $id_site, $qte, $date_utilisation, $id_utilisateur, $avec_retour, $affectation;
    public $afficherListe=true;
    public $createUtilisation=false;
    public $editUtilisation=false;
    public $notification =false; 
    public $depenses = [];
    public $cycles = [];
    public $sites = [];
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        //$this->depenses = Listedepense::where('actif', 1)->where('type', 1)->get();
        $this->sites = Site::where('actif', 1)->get();
        $this->cycles = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
    }

    public function render()
    {
        $utilisations = DB::table('utilisaction_charges')
        ->join('listedepenses', 'listedepenses.id', '=', 'utilisaction_charges.id_depense')
        ->leftJoin('sites', 'sites.id', '=', 'utilisaction_charges.id_site')
        ->leftJoin('cycles', 'cycles.id', '=', 'utilisaction_charges.id_cycle')
        ->select('utilisaction_charges.*','listedepenses.nom_depense', 'sites.site', 'cycles.description')
        ->paginate(20);

        $listedepenses = Listedepense::where('affectation', $this->affectation)->where('actif', 1)->get();

        return view('livewire.liv-utilisation-charge', [
            'utilisations' => $utilisations,
            'listedepenses' => $listedepenses,
        ]);
    }

    public function formUtilisation()
    {
        $this->isLoading = true;
        $this->createUtilisation =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->id_depense = '';
        $this->id_site = '';
        $this->qte = '';
        $this->date_utilisation = '';
        $this->affectation = '';
        $this->resetValidation();
    }

    public function saveUtilisation()
    {
        $this->isLoading = true;

        if($this->affectation ==2){
            $this->validate([
                'id_depense' => 'required',
                'id_site' => 'required|integer',
                'id_cycle' => 'nullable',
                'qte' => 'required|numeric',
                'date_utilisation' => 'required|date',
                'id_utilisateur' => 'nullable',
                'affectation' => 'required',
            ]);
        }
        elseif($this->affectation ==3){
            $this->validate([
                'id_depense' => 'required',
                'id_site' => 'nullable|integer',
                'id_cycle' => 'required|integer',
                'qte' => 'required|numeric',
                'date_utilisation' => 'required|date',
                'id_utilisateur' => 'nullable',
                'affectation' => 'required',
            ]);
        }else{
            $this->validate([
                'id_depense' => 'required',
                'id_site' => 'nullable|integer',
                'id_cycle' => 'nullable|integer',
                'qte' => 'required|numeric',
                'date_utilisation' => 'required|date',
                'id_utilisateur' => 'nullable',
                'affectation' => 'required',
            ]);
        }

        try{
        DB::beginTransaction();
        //recuperer tous le engagement charge de qte disponible
        $engagements = EngagementCharge::where('id_depense', $this->id_depense)->get();
        $total_qte_disponible = 0;
        if($engagements)
        {
            foreach($engagements as $engagement){
                $total_qte_disponible +=$engagement->qte_disponible;
            }
        }
        // echo '<pre>';
        // var_dump($total_qte_disponible);die();
        // echo '</pre>';
        //verifier si qte > somme qte_disponible
        if($this->qte <= $total_qte_disponible)
        {
            //UtilisactionCharge::create($data);
            $utilisationCharge = new UtilisactionCharge();
            $utilisationCharge->id_depense = $this->id_depense;
            if($this->affectation ==2){
            $utilisationCharge->id_site = $this->id_site;
            }
            if($this->affectation ==3){
            $utilisationCharge->id_cycle = $this->id_cycle;
            }
            $utilisationCharge->qte = $this->qte;
            $utilisationCharge->date_utilisation = $this->date_utilisation;
            $utilisationCharge->id_utilisateur = $this->id_utilisateur;
            $utilisationCharge->save();
            
            $engagementCharges = EngagementCharge::where('qte_disponible', '>', 0)
                            ->where('id_depense', $this->id_depense)
                            ->orderBy('date_engagement', 'DESC')
                            ->get();
        
            $totalQte = $this->qte;
            $selectedEngagement = collect();
        
            $utilisationQte = $totalQte;

            foreach($engagementCharges as $engagementCharge)
            {
                //$depenseliste = Listedepense::where('id', $this->id_depense)->get();
                $qte = $engagementCharge->qte_disponible;
                if($utilisationQte > 0){
                    if($utilisationQte >= $qte){
                        $selectedEngagement->push($engagementCharge);
                        $utilisationQte -= $qte;
                        $engagementCharge->update(['qte_disponible' => $qte - $qte]);
                        $qteUtilisee = $qte;
                    }else{
                        $selectedEngagement->push($engagementCharge->replicate(['qte_disponible']));
                        $engagementCharge->update(['qte_disponible' => $qte - $utilisationQte]);
                        $qteUtilisee = $utilisationQte;
                        $utilisationQte = 0;
                    }
                }else{
                    break;
                }
                // pour avoir type depense de depensesliste
                //creation depense cycle
                $depensecycle = new DepenseCycle();
                $depensecycle->id_cycle = $this->id_cycle;
                $depensecycle->id_depense = $engagementCharge->id_depense;
                $depensecycle->id_utilisation = $utilisationCharge->id;
                $depensecycle->type_depense = 1;
                $depensecycle->qte = $qteUtilisee;
                $depensecycle->valeur = $qteUtilisee * $engagementCharge->pu;
                $depensecycle->save();

                //enregistrement details depenses
                $depensedetail =  new DepenseDetail();
                $depensedetail->id_cycle = $this->id_cycle;
                $depensedetail->id_utilisation = $utilisationCharge->id;
                $depensedetail->type_depense = 1;
                $depensedetail->qte = $qteUtilisee;
                $depensedetail->valeur = $qteUtilisee * $engagementCharge->pu;
                $depensedetail->save();
                
                DB::commit();
                $this->notification = true;
                session()->flash('message', 'Utilisation charge bien enregistré!');
                $this->resetValidation();
                $this->resetInput();
            }

        }else{
            session()->flash('qte_error', 'La quantité disponible est insuffisante, quantité disponible actuele :'.$total_qte_disponible);
            DB::rollBack();
        }
        $this->isLoading = false;
        }catch(\Exception $e){
            session()->flash('qte_error', $e->getMessage());
            DB::rollBack();
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createUtilisation = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
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

    public function updatedAffectation($value)
{
    $this->emit('affectationUpdated', $value);
}
}
