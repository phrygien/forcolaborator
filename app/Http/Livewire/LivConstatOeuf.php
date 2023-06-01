<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Client;
use App\Models\ConstatOeuf;
use App\Models\Cycle;
use App\Models\DetailSortie;
use App\Models\ProduitCycle;
use App\Models\SortieOeuf;
use App\Models\TypeOeuf;
use App\Models\TypeSortie;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivConstatOeuf extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createConstat = false, $editConstat= false;

    public $constat_id, $nb, $id_type_oeuf, $id_cycle, $date_entree, $date_action, $id_utilisateur, $nb_disponible;
    public $id_dernier_constat, $id_cycle_sortie, $date_constat_sortie, $nb_disponible_constat;
    public $selectedSite;
    public $selectedBatiment;

    public $confirmUpdate;
    public $cycleActifs;
    public $typeOeufActifs;

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $createSortieConstant;
    
    public $data = [];
    public $labels = [];
    public $selectedDate;

    public $dernierConstatOeuf;

    /*
    * debut proprieté sortie oeuf en meme temps que constat oeuf
    */
    public $clients;
    public $typesorties;
    public $selectedOption;

    public $sortie_id, $id_type_oeuf_sortie, $id_type_sortie_sortie, $qte_sortie, $pu_sortie,$montant_sortie,
    $date_sortie, $id_client, $nom, $raison_sociale, $adresse, $id_produit;

    public $date_constat_detail, $prix_unitaire_detail, $valeur, $qte_sortie_detail;
    public $btn_disabled;
    /*
    * fin proprieté sortie oeuf
    */

    public function mount()
    {
        $this->date_entree = date('Y-m-d');
        $this->date_sortie = date('Y-m-d');
        $this->date_action = date('Y-m-d');
        $this->typeOeufActifs = TypeOeuf::where('actif', 1)->get();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
        $this->clients = Client::all();
        $this->typesorties = TypeSortie::where('actif', 1)->get();
        //$this->chargerDonneesChart();
        $this->selectedDate = Date::today()->format('Y-m-d');
        $this->chargerDonneesChart();

        $this->dernierConstatOeuf = ConstatOeuf::latest()->first();
        if ($this->dernierConstatOeuf) {
            $this->id_dernier_constat = $this->dernierConstatOeuf->id;
            $this->id_cycle_sortie = $this->dernierConstatOeuf->id_cycle;
            $this->date_constat_detail = $this->dernierConstatOeuf->date_entree;
            $this->nb_disponible_constat = $this->dernierConstatOeuf->nb_disponible;
        }
    }

    public function afficherTotalDonneesJournalieres()
    {
        $totalDonneesJournalieres = ConstatOeuf::whereDate('date_entree', today())
            ->groupBy('id_type_oeuf')
            ->selectRaw('id_type_oeuf, SUM(nb) as total')
            ->get();
    }

    public function render()
    {
        $constats = DB::table('constat_oeufs')
            ->join('type_oeufs', 'type_oeufs.id', 'constat_oeufs.id_type_oeuf')
            ->join('cycles', 'cycles.id', 'constat_oeufs.id_cycle')
            ->join('users', 'users.id', 'constat_oeufs.id_utilisateur')
            ->select('constat_oeufs.*', 'type_oeufs.type', 'cycles.description', 'users.name')
            ->orderBy('date_entree', 'DESC')
            ->paginate(10);

            $totalDonneesJournalieres = ConstatOeuf::join('type_oeufs', 'constat_oeufs.id_type_oeuf', '=', 'type_oeufs.id')
            ->whereDate('date_entree', today())
            ->groupBy('id_type_oeuf', 'type_oeufs.type')
            ->selectRaw('id_type_oeuf, type_oeufs.type as nom_type_oeuf, SUM(nb) as total')
            ->get();

        return view('livewire.liv-constat-oeuf', [
            'constats' => $constats,
            'totalDonneesJournalieres' => $totalDonneesJournalieres,
        ]);
    }

    public function formConstat()
    {
        $this->isLoading = true;
        $this->createConstat = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function createSortieConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_entree' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
        ]);

        try{
            $data['nb_disponible'] = $this->nb;
            ConstatOeuf::create($data);
            $this->resetFormConstat();
            $this->resetValidation();
            $this->isLoading = false;
            $this->notification = true;
            session()->flash('message', 'Constat oeuf bien enregistré!');
            $this->createSortieConstant = true;
            $this->createConstat = false;

            //recuper dernier constat oeuf
            $this->dernierConstatOeuf = ConstatOeuf::latest()->first();
            if($this->dernierConstatOeuf)
            {
                $this->id_dernier_constat = $this->dernierConstatOeuf->id;
                $this->id_cycle_sortie = $this->dernierConstatOeuf->id_cycle;
                $this->date_constat_sortie = $this->dernierConstatOeuf->date_entree;
                $this->nb_disponible_constat = $this->dernierConstatOeuf->nb_disponible;
            }
        }catch(\Exception $e)
        {
            session()->flash('message', $e->getMessage());
        }
        $this->isLoading = false;
    }

    public function resetFormConstat()
    {
        $this->id_type_oeuf = '';
        $this->nb = '';
        $this->id_cycle = '';
        $this->date_entree = date('Y-m-d');
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_entree' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
        ]);

        DB::beginTransaction();
        $cycleSelected = Cycle::find($this->id_cycle);
        $stockActuale = $cycleSelected->nb_poulet;

        try{
        $data['nb_disponible'] = $this->nb;
        ConstatOeuf::create($data);
        //update stock cyle selected
        // $cycleSelected = Cycle::find($this->id_cycle);
        // $stockActuale = $cycleSelected->nb_poulet;
        // $cycleSelected->update([
        //     'nb_poulet' => ($stockActuale + $this->nb),
        // ]);
        // $cycleSelected->save();

        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Constat oeuf bien enregistré!');
        DB::commit();
        }catch(\Exception $e){
            //return $e->getMessage();
            session()->flash('message', $e->getMessage());
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createConstat = false;
        $this->afficherListe = true;
        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editConstat($id)
    {
        $constat = ConstatOeuf::findOrFail($id);
        $this->constat_id = $id;
        $this->id_type_oeuf = $constat->id_type_oeuf;
        $this->nb = $constat->nb;
        $this->id_cycle = $constat->id_cycle;
        $this->date_entree = $constat->date_entree;
        $this->id_utilisateur = $constat->id_utilisateur;

        $this->editConstat = true;
        $this->createConstat = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateConstat()
    {
        $this->validate([
            'id_type_oeuf' => 'required|integer',
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_entree' => 'required|date',
            'date_action' => 'nullable',
            'id_utilisateur' => 'nullable'
        ]);

        try{
            
            $constat = ConstatOeuf::findOrFail($this->constat_id);
            $constat->update([
                'id_type_oeuf' => $this->id_type_oeuf,
                'nb' => $this->nb,
                'id_cycle' => $this->id_cycle,
                'date_entree' => $this->date_entree,
                'date_action' => $this->date_action,
                'id_utilisateur' => $this->id_utilisateur,
            ]);

            $this->editConstat = false;
            $this->resetFormConstat();
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
        $this->editConstat = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editConstat = false;
        $this->resetFormConstat();
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
        $this->recordToDelete = ConstatOeuf::findOrFail($id);
    }

    public function cancelDelete()
    {
        $this->recordToDelete = null;
    }

    public function delete()
    {
        $this->recordToDelete->delete();
        $this->recordToDelete = null;
        $this->notification = true;
        session()->flash('message', 'Suppression avec succée');
    }


    public function chargerDonneesChart()
    {
        $totalDonneesJournalieres = ConstatOeuf::join('type_oeufs', 'constat_oeufs.id_type_oeuf', '=', 'type_oeufs.id')
            ->whereDate('date_entree', $this->selectedDate)
            ->groupBy('id_type_oeuf', 'type_oeufs.type')
            ->selectRaw('id_type_oeuf, type_oeufs.type as nom_type_oeuf, SUM(nb) as total')
            ->get();

        $this->data = $totalDonneesJournalieres->pluck('total')->toArray();
        $this->labels = $totalDonneesJournalieres->pluck('nom_type_oeuf')->toArray();

        $this->emit('chartUpdated');
    }

    /*
    * debut sortie oeuf
    */
        public function updatedMontantSortie($value)
        {
            if (is_numeric($value) && is_numeric($this->qte_sortie) && $this->qte_sortie != 0) {
                $this->qte_sortie = $value / $this->qte_sortie;
            }
        }

        public function updatedPuSortie($value)
        {
            if (is_numeric($value) && is_numeric($this->qte_sortie) && $this->qte_sortie != 0) {
                $this->montant_sortie = $value * $this->qte_sortie;
            }
        }

        public function updatedQteSortie($value)
        {
            if (is_numeric($value) && is_numeric($this->pu_sortie) && $value != 0) {
                $this->montant_sortie = $this->pu_sortie * $value;
            }
        }

        public function updatedPrixUnitaireDetail()
        {
            if(is_numeric($this->prix_unitaire_detail) && is_numeric($this->qte_sortie_detail))
            {
                $this->valeur = $this->prix_unitaire_detail * $this->qte_sortie_detail;
            }else{
                $this->valeur = 0;
            }
        }

        public function updatedQteSortieDetail()
        {
            if(is_numeric($this->prix_unitaire_detail) && is_numeric($this->qte_sortie_detail))
            {
                $this->valeur = $this->prix_unitaire_detail * $this->qte_sortie_detail;
            }else{
                $this->valeur = '';
            }
            
            $this->verifierDisponibilite();
        }

        public function verifierDisponibilite()
        {
            if($this->qte_sortie_detail > $this->nb_disponible_constat)
            {
                session()->flash('error', 'La Qte à sortir ne doit pas >  aux nombre disponible'.' / '. 'Qte disponible du constat est : '.$this->nb_disponible_constat);
                $this->btn_disabled = 'disabled';
            }else{
                $this->btn_disabled = '';
            }
        }

        public function resetFormConstatSortie()
        {
            $this->id_type_oeuf = '';
            $this->id_type_oeuf_sortie = '';
            $this->id_client = '';
            $this->nom = '';
            $this->raison_sociale = '';
            $this->adresse = '';
            $this->qte_sortie = '';
            $this->pu_sortie = '';
            $this->date_sortie = date('Y-m-d');
            $this->date_action = '';
            $this->montant_sortie = '';
            $this->qte_sortie_detail = '';
            $this->valeur = '';
            $this->prix_unitaire_detail = '';
            $this->creatBtn = false;
            $this->resetValidation();
        }

        public function saveNewSortie()
        {
            $this->isLoading = true;
            $this->validate([
                'id_type_oeuf' => 'required|integer',
                'id_type_sortie_sortie' => 'required|integer',
                'nom' => 'required',
                'qte_sortie' => 'required|integer',
                'pu_sortie' => 'required|numeric',
                'montant_sortie' => 'required|numeric',
                'date_sortie' => 'required|date',
                'id_client' => 'nullable|integer',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'prix_unitaire_detail' => 'required|numeric',
                'valeur' => 'required|numeric',
                'qte_sortie_detail' => 'required',
                'id_produit' => 'required'
            ]);
    
            DB::beginTransaction();
                try{
                    $constat = ConstatOeuf::where('id', $this->id_dernier_constat)->first();

                    //creation de nouvele client
                    $client = new Client();
                    $client->nom = $this->nom;
                    $client->raison_sociale = $this->raison_sociale;
                    $client->adresse = $this->adresse;
                    $client->save();

                    //création sortie oeuf
                    $sortieOeuf = new SortieOeuf();
                    $sortieOeuf->id_type_oeuf = $this->id_type_oeuf;
                    $sortieOeuf->id_type_sortie = $this->id_type_sortie_sortie;
                    $sortieOeuf->qte = $this->qte_sortie;
                    $sortieOeuf->pu = $this->pu_sortie;
                    $sortieOeuf->date_sortie = $this->date_sortie;
                    $sortieOeuf->date_action = now();
                    $sortieOeuf->id_client = $client->id;
                    $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                    $sortieOeuf->montant = ($this->pu_sortie * $this->qte_sortie);
            
                    $sortieOeuf->save();
            
                    // enregistrer detail sortie
                    $detailSortie = new DetailSortie();
                    $detailSortie->id_sortie = $sortieOeuf->id;
                    $detailSortie->id_constat = $this->id_dernier_constat;
                    $detailSortie->id_produit = $this->id_produit;
                    $detailSortie->qte = $this->qte_sortie_detail;
                    $detailSortie->valeur = $this->valeur;
                    $detailSortie->pu = $this->prix_unitaire_detail;
                    $detailSortie->save();

                    // mmettre à jour nombre disponible constat utilisé
                    $constat->update([
                        'nb_disponible' => $constat->nb_disponible - $this->qte_sortie_detail,
                    ]); 

                    // enregistrement produit cycle
                    $produitCycle = new ProduitCycle();
                    $produitCycle->id_cycle = $constat->id_cycle;
                    $produitCycle->id_produit = $this->id_produit;
                    $produitCycle->id_sortie = $sortieOeuf->id;
                    $produitCycle->qte = $this->qte_sortie_detail;
                    $produitCycle->pu = $this->prix_unitaire_detail;
                    $produitCycle->valeur = $this->valeur;
                    $produitCycle->save();

                    $this->resetFormConstatSortie();
                    $this->resetValidation();
                    $this->isLoading = false;
                    $this->notification = true;
                    session()->flash('message', 'Sortie oeuf bien enregistré!');
                    DB::commit();
                    $this->resetPage();
                    }catch(\Exception $e){
                        DB::rollback();
                        //return $e->getMessage();
                        session()->flash('message', $e->getMessage());
                        
                    }
        }

        public function saveExistSortie()
        {
            $this->isLoading = true;
            $this->validate([
                'id_type_oeuf' => 'required|integer',
                'id_type_sortie_sortie' => 'required|integer',
                'qte_sortie' => 'required|integer',
                'pu_sortie' => 'required|numeric',
                'montant_sortie' => 'required|numeric',
                'date_sortie' => 'required|date',
                'id_client' => 'required|integer',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'prix_unitaire_detail' => 'required|numeric',
                'valeur' => 'required|numeric',
                'qte_sortie_detail' => 'required',
                'id_produit' => 'required'
            ]);
    
            DB::beginTransaction();
                try{
                    $constat = ConstatOeuf::where('id', $this->id_dernier_constat)->first();
                    //création sortie oeuf
                    $sortieOeuf = new SortieOeuf();
                    $sortieOeuf->id_type_oeuf = $this->id_type_oeuf;
                    $sortieOeuf->id_type_sortie = $this->id_type_sortie_sortie;
                    $sortieOeuf->qte = $this->qte_sortie;
                    $sortieOeuf->pu = $this->pu_sortie;
                    $sortieOeuf->date_sortie = $this->date_sortie;
                    $sortieOeuf->date_action = now();
                    $sortieOeuf->id_client = $this->id_client;
                    $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                    $sortieOeuf->montant = ($this->pu_sortie * $this->qte_sortie);
            
                    $sortieOeuf->save();
            
                    // enregistrer detail sortie
                    $detailSortie = new DetailSortie();
                    $detailSortie->id_sortie = $sortieOeuf->id;
                    $detailSortie->id_constat = $this->id_dernier_constat;
                    $detailSortie->id_produit = $this->id_produit;
                    $detailSortie->qte = $this->qte_sortie_detail;
                    $detailSortie->valeur = $this->valeur;
                    $detailSortie->pu = $this->prix_unitaire_detail;
                    $detailSortie->save();

                    // mmettre à jour nombre disponible constat utilisé
                    $constat->update([
                        'nb_disponible' => $constat->nb_disponible - $this->qte_sortie_detail,
                    ]); 

                    // enregistrement produit cycle
                    $produitCycle = new ProduitCycle();
                    $produitCycle->id_cycle = $constat->id_cycle;
                    $produitCycle->id_produit = $this->id_produit;
                    $produitCycle->id_sortie = $sortieOeuf->id;
                    $produitCycle->qte = $this->qte_sortie_detail;
                    $produitCycle->pu = $this->prix_unitaire_detail;
                    $produitCycle->valeur = $this->valeur;
                    $produitCycle->save();

                    $this->resetFormConstatSortie();
                    $this->resetValidation();
                    $this->isLoading = false;
                    $this->notification = true;
                    session()->flash('message', 'Sortie oeuf bien enregistré!');
                    DB::commit();
                    $this->resetPage();
                    }catch(\Exception $e){
                        DB::rollback();
                        //return $e->getMessage();
                        session()->flash('message', $e->getMessage());
                        
                    }
        }

        public function cancelCreationSortie()
        {
            $this->isLoading = true;
            $this->createSortieConstant = false;
            $this->createConstat = false;
            $this->afficherListe = true;
            $this->resetFormConstat();
            $this->resetValidation();
            $this->isLoading = false;
            $this->creatBtn = true;
        }
    /*
    * fin sortie oeuf
    */

}
