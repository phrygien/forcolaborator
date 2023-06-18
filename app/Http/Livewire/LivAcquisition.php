<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Immobilisation;
use App\Models\Listedepense;
use App\Models\Site;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LivAcquisition extends Component
{
    use WithPagination;
    public $isLoading, $acquisition_id, $nom, $id_depense, $id_site, $id_batiment, $pu, $qte, $valeur_disponible, $montant_total, $date_acquisition, $affectation;
    public $afficherListe=true;
    public $createAcquisition=false;
    public $editAcquisition=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $btnCreate = true;
    public $listedepenses = [];
    public $sites = [];
    public $batiments = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->listedepenses = Listedepense::where('type', 2)->where('actif', 1)->get();
        $this->sites = Site::where('actif', 1)->get();
        $this->batiments = Batiment::where('actif', 1)->get();
        $this->date_acquisition = date('Y-m-d');
    }

    public function render()
    {
        $acquisitions = DB::table('immobilisations')
                    ->join('listedepenses', 'listedepenses.id', '=', 'immobilisations.id_depense')
                    ->leftJoin('sites', 'sites.id', '=', 'immobilisations.id_site')
                    ->leftJoin('batiments', 'batiments.id', '=', 'immobilisations.id_batiment')
                    ->paginate(20);

        return view('livewire.liv-acquisition', [
            'acquisitions' => $acquisitions
        ]);
    }

    public function formAcquisition()
    {
        $this->isLoading = true;
        $this->createAcquisition =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->nom = '';
        $this->id_depense = '';
        $this->id_site = '';
        $this->id_batiment = '';
        $this->pu = '';
        $this->qte = '';
        $this->valeur_disponible = '';
        $this->montant_total = '';
        $this->date_acquisition = date('Y-m-d');
        $this->resetValidation();
    }

    public function saveAcquisition()
    {
        $this->isLoading = true;
        if($this->affectation == 2){
            $data = $this->validate([
                'nom' => 'required',
                'id_depense' => 'required|integer',
                'id_site' => 'required|integer',
                'id_batiment' => 'nullable',
                'pu' => 'required|numeric',
                'qte' => 'required|numeric',
                'valeur_disponible' => 'required|numeric',
                'montant_total' => 'required|numeric',
                'date_acquisition' => 'nullable|date',
            ]);
    
        }elseif($this->affectation == 3){
            $data = $this->validate([
                'nom' => 'required',
                'id_depense' => 'required|integer',
                'id_site' => 'nullable|integer',
                'id_batiment' => 'required|integer',
                'pu' => 'required|numeric',
                'qte' => 'required|numeric',
                'valeur_disponible' => 'required|numeric',
                'montant_total' => 'required|numeric',
                'date_acquisition' => 'nullable|date',
            ]);
    
        }else{
            $data = $this->validate([
                'nom' => 'required',
                'id_depense' => 'required|integer',
                'id_site' => 'nullable|integer',
                'id_batiment' => 'nullable|integer',
                'pu' => 'required|numeric',
                'qte' => 'required|numeric',
                'valeur_disponible' => 'required|numeric',
                'montant_total' => 'required|numeric',
                'date_acquisition' => 'nullable|date',
            ]);
       
        }

        $data['date_acquisition'] = now();
        try{

        Immobilisation::create($data);
        $this->notification = true;
        session()->flash('message', 'Acquisition immobilisation enregistré!');
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
        $this->createAcquisition = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editAcquisition($id)
    {
        $this->isLoading = true;

        $acquisition = Immobilisation::findOrFail($id);
        $this->nom = $acquisition->nom;
        $this->id_depense = $acquisition->id_depense;
        $this->acquisition_id = $id;
        $this->id_site = $acquisition->id_site;
        $this->id_batiment = $acquisition->id_batiment;
        $this->pu = $acquisition->pu;
        $this->qte = $acquisition->qte;
        $this->valeur_disponible = $acquisition->valeur_disponible;
        $this->montant_total = $acquisition->montant_total;
        $this->date_acquisition = $acquisition->date_acquisition;
        $this->editAcquisition = true;
        $this->createAcquisition = false;
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
            'nom' => 'required',
            'id_depense' => 'required|integer',
            'id_site' => 'nullable|integer',
            'id_batiment' => 'nullable|integer',
            'pu' => 'required|numeric',
            'qte' => 'required|numeric',
            'valeur_disponible' => 'required|numeric',
            'montant_total' => 'required|numeric',
            'date_acquisition' => 'nullable|date',
        ]);

        try{

            $acquisition = Immobilisation::findOrFail($this->acquisition_id);
            $acquisition->update([
                'nom' => $this->nom,
                'id_depense' => $this->id_depense,
                'id_site' => $this->id_site,
                'id_batiment' => $this->id_batiment,
                'pu' => $this->pu,
                'qte' => $this->qte,
                'valeur_disponible' => $this->valeur_disponible,
                'montant_total' => $this->montant_total,
                'date_acquisition' => $this->date_acquisition
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editAcquisition = false;
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
        $this->editAcquisition = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editAcquisition = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

}
