<?php

namespace App\Http\Livewire;

use App\Models\EngagementCharge;
use App\Models\Listedepense;
use App\Models\TypeDepense;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivEngagementCharge extends Component
{
    use WithPagination;
    public $isLoading, $engagement_id, $id_depense, $pu, $qte, $prix_total, $qte_disponible, $date_engagement, $retour;
    public $afficherListe=true;
    public $createEngagement=false;
    public $editEngagement=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    public $depense_charges = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->date_engagement = now();
        $this->depense_charges = Listedepense::where('type', 2)
                                ->where('actif', 1)
                                ->get();
    }

    public function render()
    {
        $engagements = DB::table('engagement_charges')
                        ->join('listedepenses', 'listedepenses.id', 'engagement_charges.id_depense')
                        ->select('engagement_charges.*', 'listedepenses.nom_depense')
                        ->paginate(15);

        return view('livewire.liv-engagement-charge', [
            'engagements' => $engagements
        ]);
    }

    public function formEngagement()
    {
        $this->isLoading = true;
        $this->createEngagement =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->id_depense = '';
        $this->pu = '';
        $this->qte = '';
        $this->prix_total = '';
        $this->qte_disponible = '';
        $this->date_engagement = date('Y-m-d');;
        $this->resetValidation();
    }

    public function saveEngagement()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_depense' => 'required|integer',
            'pu' => 'required|numeric',
            'qte' => 'required|numeric',
            'prix_total' => 'required|numeric',
            'qte_disponible' => 'required|numeric',
            'date_engagement' => 'required|date'
        ]);

        try{
        
        $data['prix_total'] = $this->pu * $this->qte;
        $data['qte_disponible'] = $this->qte;
        EngagementCharge::create($data);
        $this->notification = true;
        session()->flash('message', 'Engagement charge enregistré!');
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
        $this->createEngagement = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editEngagement($id)
    {
        $this->isLoading = true;

        $engagement = EngagementCharge::findOrFail($id);
        $this->id_depense = $engagement->id_depense;
        $this->pu = $engagement->pu;
        $this->qte = $engagement->qte;
        $this->prix_total = $engagement->prix_total;
        $this->qte_disponible = $engagement->qte_disponible;
        $this->date_engagement = $engagement->date_engagement;
        $this->engagement_id = $id;
        $this->editEngagement = true;
        $this->createEngagement = false;
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

    public function updateLibelle()
    {
        $this->isLoading = true;

        $this->validate([
            'id_depense' => 'required|integer',
            'pu' => 'required|numeric',
            'qte' => 'required|numeric',
            'prix_total' => 'required|numeric',
            'qte_disponible' => 'required|numeric',
            'date_engagement' => 'required|date'
        ]);

        try{

            $engagement = EngagementCharge::findOrFail($this->engagement_id);
            $engagement->update([
                'id_depense' => $this->id_depense,
                'pu' => $this->pu,
                'qte' => $this->qte,
                'prix-total' => $this->qte * $this->pu,
                'qte_disponible' => $this->qte_disponible,
                'date_engagement' => now(),
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editEngagement = false;
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
        $this->editEngagement = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editEngagement = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = EngagementCharge::findOrFail($id);
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
            session()->flash('error', 'Engagement depense est déja utilisé ! voulez-vous vraiment le rendre inactif ?');
        }

    }
}
