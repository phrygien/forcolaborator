<?php

namespace App\Http\Livewire;

use App\Models\Batiment;
use App\Models\Client;
use App\Models\ConstatOeuf;
use App\Models\ConstatPoulet;
use App\Models\Cycle;
use App\Models\DetailSortie;
use App\Models\ProduitCycle;
use App\Models\Site;
use App\Models\SortiePoulet;
use App\Models\TypeOeuf;
use App\Models\TypePoulet;
use App\Models\TypeSortie;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivConstatPoulet extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createConstat = false, $editConstat= false;

    public $constat_id, $nb, $new_nb, $nb_disponible, $new_nb_disponible, $id_cycle, $date_constat, $date_action, $id_utilisateur;

    //pour le sortie du constat
    public $qte_sortie, $id_dernier_constat, $id_cycle_sortie, $date_constat_sortie, $nb_disponible_constat, $prix_unitaire_sortie, $valeur;
    public $montant, $poids_total, $prix_unite, $pu_poulet, $nombre, $id_type_sortie, $id_client, $raison_sociale, $adresse, $nom, $id_produit;

    public $selectedSite;
    public $selectedBatiment;

    public $confirmUpdate;
    public $typePouletActifs = [];
    public $cycleActifs = [];

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $data = [];
    public $labels = [];
    public $selectedDate;
    public $selectedOption;
    public $clients;
    public $typesorties;
    public $date_sortie;

    public $btn_disabled = '';

    public $createSortieConstant = false;

    public $dernierConstatPoulet;

    public function mount()
    {
        $this->updatedMontant();
        $this->date_action = date('Y-m-d');
        $this->date_constat = date('Y-m-d');
        $this->date_sortie = date('Y-m-d');
        $this->typePouletActifs = TypePoulet::where('actif', 1)->get();
        $this->cycleActifs = Cycle::where('actif', 1)->whereIn('id_type_poulet', [6, 8])->get();
        $this->id_utilisateur = Auth::user()->id;

        $this->clients = Client::all();
        $this->typesorties = TypeSortie::where('actif', 1)->get();
        $this->dernierConstatPoulet = ConstatPoulet::latest()->first();
        if ($this->dernierConstatPoulet) {
            // Assign the retrieved information to the class property
            $this->id_dernier_constat = $this->dernierConstatPoulet->id;
            $this->id_cycle_sortie = $this->dernierConstatPoulet->id_cycle;
            $this->date_constat_sortie = $this->dernierConstatPoulet->date_constat;
            //$this->date_action = $this->dernierConstatPoulet->date_action;
            $this->nb_disponible_constat = $this->dernierConstatPoulet->nb_disponible;
        }
    }

    public function getSites()
    {
        return Site::where('actif', 1)->get();
    }

    public function getBatiments()
    {
        $batiments = [];
    
        if ($this->selectedSite) {
            $batiments = Batiment::where('id_site', $this->selectedSite)
                        ->where('actif', 1)
                        ->get();
        }
    
        return $batiments;
    }

    public function getCycles()
    {
        $cyclebatiments = [];
    
        if ($this->selectedSite) {
            $cyclebatiments = Cycle::where('id_batiment', $this->selectedBatiment)
                        ->where('actif', 1)
                        ->whereIn('id_type_poulet', [6, 8])
                        ->get();
        }
    
        return $cyclebatiments;
    }

    // public function updatedNombre()
    // {
    //     if($this->nombre > $this->nb_disponible_constat)
    //     {
    //         session()->flash('error_nb', 'La Qte à sortir ne doit pas >  aux nombre disponible'.' / '. 'Qte disponible du constat est : '.$this->nb_disponible_constat);
    //         $this->btn_disabled = 'disabled';
    //     }else{
    //         $this->btn_disabled = '';
    //     }
    // }

    public function updatedNewNb()
    {
        $this->calculeNewDisponible();
    }

    public function calculeNewDisponible()
    {
        if(is_numeric($this->new_nb)){
            if($this->nb < $this->new_nb)
            {
                if (is_numeric($this->new_nb)) {
                    $this->new_nb_disponible = $this->nb_disponible +($this->new_nb - $this->nb);
                }else{
                    $this->new_nb_disponible= '';
                }
            }elseif($this->nb >= $this->new_nb)
            {   
                if($this->nb - $this->new_nb > $this->nb_disponible){
                    session()->flash('error', 'operation impossible');
                }elseif($this->nb - $this->new_nb <= $this->nb_disponible){
                    $this->new_nb_disponible = $this->nb_disponible - ($this->nb - $this->new_nb);
                }
            }
        }else{
            $this->new_nb_disponible = '';
        }

    }

    public function render()
    {
        $constats = DB::table('constat_poulets')
            ->join('cycles', 'cycles.id', 'constat_poulets.id_cycle')
            ->join('batiments', 'batiments.id', 'cycles.id_batiment')
            ->join('sites', 'sites.id', 'batiments.id_site')
            ->join('type_poulets', 'type_poulets.id', 'cycles.id_type_poulet')
            ->join('users', 'users.id', 'constat_poulets.id_utilisateur')
            ->select('constat_poulets.*', 'type_poulets.type', 'cycles.description', 'users.name', 'batiments.nom', 'sites.site', 'sites.adresse')
            ->paginate(20);

        $sites = $this->getSites();
        $batiments = $this->getBatiments();
        $cyclebatiments = $this->getCycles();

        return view('livewire.liv-constat-poulet', [
            'constats' => $constats,
            'sites' => $sites,
            'batiments' => $batiments,
            'cyclebatiments' => $cyclebatiments,
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

    /*
    * enregistrer sortie du current constat
    */
    public function createSortieConstant()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable'
        ]);

        try{
            $data['nb_disponible'] = $this->nb;
            ConstatPoulet::create($data);
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
            session()->flash('message', 'Constat poulet bien enregistré!');
            $this->createSortieConstant = true;
            $this->createConstat = false;
            $this->dernierConstatPoulet = ConstatPoulet::latest()->first();
            if ($this->dernierConstatPoulet) {
                // Assign the retrieved information to the class property
                $this->id_dernier_constat = $this->dernierConstatPoulet->id;
                $this->id_cycle_sortie = $this->dernierConstatPoulet->id_cycle;
                $this->date_constat_sortie = $this->dernierConstatPoulet->date_constat;
                //$this->date_action = $this->dernierConstatPoulet->date_action;
                $this->nb_disponible_constat = $this->dernierConstatPoulet->nb_disponible;
            }
            //return redirect()->to('gestion_entree/constat_poulet');
            //DB::commit();
    
            }catch(\Exception $e){
                //return $e->getMessage();
                session()->flash('message', $e->getMessage());
            }
    }
    /*
    * fin enregistrement sortie current constat
    */
    public function resetFormConstat()
    {
        $this->nb = '';
        $this->nb_disponible = '';
        $this->id_cycle = '';
        $this->new_nb = '';
        $this->new_nb_disponible = '';
        $this->date_constat = date('Y-m-d');
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'selectedSite' => 'required',
            "selectedBatiment" => 'required'
        ]);

        //DB::beginTransaction();
        // $cycleSelected = Cycle::find($this->id_cycle);
        // $stockActuale = $cycleSelected->nb_poulet;

        try{
        $data['nb_disponible'] = $this->nb;
        ConstatPoulet::create($data);
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
        session()->flash('message', 'Constat poulet bien enregistré!');
        //return redirect()->to('gestion_entree/constat_poulet');
        //DB::commit();

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

    public function cancelCreateSortie()
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

    public function editConstat($id)
    {
        $constat = ConstatPoulet::findOrFail($id);
        $this->constat_id = $id;
        $this->nb = $constat->nb;
        $this->new_nb = '';
        $this->nb_disponible = $constat->nb_disponible;
        $this->id_cycle = $constat->id_cycle;
        $this->date_constat = $constat->date_constat;
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
            'nb' => 'required',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'date_action' => 'nullable',
            'id_utilisateur' => 'nullable',
            'new_nb' => 'nullable',
        ]);

        try{
            
            $constat = ConstatPoulet::findOrFail($this->constat_id);
            //verifier si le nombre de poulet sont modifier
            if($this->new_nb !=null || $this->new_nb_disponible !=null){
                $constat->update([
                    'nb' => $this->new_nb,
                    'id_cycle' => $this->id_cycle,
                    'date_constat' => $this->date_constat,
                    'date_action' => $this->date_action,
                    'nb_disponible' => $this->new_nb_disponible,
                    'id_utilisateur' => $this->id_utilisateur,
                ]);
            }else{
                $constat->update([
                    'nb' => $this->nb,
                    'id_cycle' => $this->id_cycle,
                    'date_constat' => $this->date_constat,
                    'date_action' => $this->date_action,
                    'nb_disponible' => $this->nb_disponible,
                    'id_utilisateur' => $this->id_utilisateur,
                ]); 
            }
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
        $this->recordToDelete = ConstatPoulet::findOrFail($id);
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

    /*
    * debut sortie constat
    */

    public function updatedQteSortie()
    {
        $this->verifierDisponibilite();
        $this->calculateMontant();
    }

    public function updatedPrixUnitaireSortie()
    {
        $this->calculateMontant();
    }

    public function verifierDisponibilite()
    {
        if($this->qte_sortie > $this->nb_disponible_constat)
        {
            session()->flash('error', 'La Qte à sortir ne doit pas >  aux nombre disponible'.' / '. 'Qte disponible du constat est : '.$this->nb_disponible_constat);
            $this->btn_disabled = 'disabled';
        }else{
            $this->btn_disabled = '';
        }
    }

    public function calculateMontant()
    {
        if (is_numeric($this->qte_sortie) && is_numeric($this->prix_unitaire_sortie)) {
            $this->valeur = $this->qte_sortie * $this->prix_unitaire_sortie;
        }else{
            $this->valeur = 0;
        }
    }

    public function updatedPrixUnite($value)
    {
        if(is_numeric($this->poids_total) && is_numeric($this->prix_unite))
        {
            $this->montant = $this->poids_total * $this->prix_unite;
        }else
        {
            $this->montant = '';
        }

        if(is_numeric($this->montant) && is_numeric($this->nombre))
        {
            $this->pu_poulet = round($this->montant * $this->nombre, 2);
        }else
        {
            $this->pu_poulet = '';
        }
    }

    public function updatedPoidsTotal($value)
    {
        if (is_numeric($value) && is_numeric($this->prix_unite) && $value != 0) {
            $this->montant = $this->prix_unite * $value;
        }
    }

    public function updatedMontant()
    {
        if(is_numeric($this->montant) && is_numeric($this->nombre))
        {
            $this->pu_poulet = round($this->montant * $this->nombre, 2);
        }else
        {
            $this->pu_poulet = '';
        }
    }

    public function resetFormSortieConstat()
    {
        $this->isLoading = true;
        $this->id_type_sortie = '';
        $this->poids_total = '';
        $this->nombre = '';
        $this->prix_unite = '';
        $this->date_sortie = date('Y-m-d');
        $this->id_client = '';
        $this->montant = '';
        $this->nom = '';
        $this->raison_sociale = '';
        $this->adresse = '';
        $this->qte_sortie = '';
        $this->prix_unitaire_sortie = '';
        $this->nb_disponible_constat = '';
        $this->valeur = '';
        $this->id_produit = '';
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function saveSortieAndDetailForNewClient()
    {
        $this->isLoading = true;
        if($this->selectedOption == "existe"){
            $this->validate([
                'id_type_sortie' => 'required|integer',
                'poids_total' => 'required',
                'nombre' => 'required|integer',
                'prix_unite' => 'required',
                'date_sortie' => 'required|date',
                'id_client' => 'nullable|integer',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'montant' => 'nullable',
                'id_produit' => 'required',
            ]);
        }else{
            $this->validate([
                'id_type_sortie' => 'required|integer',
                'poids_total' => 'required',
                'nombre' => 'required|integer',
                'nom' => 'required',
                'raison_sociale' => 'required',
                'adresse' => 'required',
                'prix_unite' => 'required',
                'date_sortie' => 'required|date',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'montant' => 'nullable|numeric',
                'valeur' => 'required',
                'qte_sortie' => 'required|numeric',
                'prix_unitaire_sortie' => 'required|numeric',
                'nb_disponible_constat' => 'required|numeric',
                'id_produit' => 'required',
            ]);   
        }
        // verifier disponibilite
        $constat = ConstatPoulet::where('id', $this->id_dernier_constat)->first();
        
        if($constat !=null)
        {
            if($this->nombre > $constat->nb_disponible){
                session()->flash('stock_not_ok', 'Opération impossible, stock insuffisant');
            }else{
            DB::beginTransaction();
                    try{
                        //creation de nouvele client
                        $client = new Client();
                        $client->nom = $this->nom;
                        $client->raison_sociale = $this->raison_sociale;
                        $client->adresse = $this->adresse;
                        $client->save();
                        
                        //création sortie poulet
                        $sortiePoulet = new SortiePoulet();
                        $sortiePoulet->id_type_sortie = $this->id_type_sortie;
                        $sortiePoulet->poids_total = $this->poids_total;
                        $sortiePoulet->nombre = $this->nombre;
                        $sortiePoulet->prix_unite = $this->prix_unite;
                        $sortiePoulet->date_sortie = $this->date_sortie;
                        $sortiePoulet->date_action = now();
                        $sortiePoulet->id_client = $client->id;
                        $sortiePoulet->id_utilisateur = $this->id_utilisateur;
                        $sortiePoulet->montant = ($this->prix_unite * $this->poids_total);
                        $sortiePoulet->pu_poulet = round($sortiePoulet->montant / $this->nombre, 2);
                
                        $sortiePoulet->save();
                    
                        // enregistrer detail sortie
                        $detailSortie = new DetailSortie();
                        $detailSortie->id_sortie = $sortiePoulet->id;
                        $detailSortie->id_constat = $this->id_dernier_constat;
                        $detailSortie->id_produit = $this->id_produit;
                        $detailSortie->qte = $this->qte_sortie;
                        $detailSortie->valeur = $this->valeur;
                        $detailSortie->pu = $this->prix_unitaire_sortie;
                        $detailSortie->save();

                        // mmettre à jour nombre disponible constat utilisé
                        $constat->update([
                            'nb_disponible' => $constat->nb_disponible - $this->qte_sortie,
                        ]); 

                        // enregistrement produit cycle
                        $produitCycle = new ProduitCycle();
                        $produitCycle->id_cycle = $constat->id_cycle;
                        $produitCycle->id_produit = $this->id_produit;
                        $produitCycle->id_sortie = $sortiePoulet->id;
                        $produitCycle->qte = $this->qte_sortie;
                        $produitCycle->pu = $this->prix_unitaire_sortie;
                        $produitCycle->valeur = $this->valeur;
                        $produitCycle->save();

                        $this->resetFormSortieConstat();
                        $this->resetValidation();
                        $this->isLoading = false;
                        $this->notification = true;
                        session()->flash('message', 'Sortie poulet bien enregistré!');
                        DB::commit();
                        $this->resetPage();
                    }catch(\Exception $e){
                        DB::rollback();
                        //return $e->getMessage();
                        session()->flash('message', $e->getMessage());
                        
                    }
            }
        }
    }

    //pour enregistrer sortie pour client existe
    public function saveSortieAndDetailForExisteClient()
    {
        $this->isLoading = true;
            $this->validate([
                'id_type_sortie' => 'required|integer',
                'poids_total' => 'required',
                'nombre' => 'required|integer',
                'id_client' => 'required',
                'prix_unite' => 'required',
                'date_sortie' => 'required|date',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'montant' => 'nullable|numeric',
                'valeur' => 'required',
                'qte_sortie' => 'required|numeric',
                'prix_unitaire_sortie' => 'required|numeric',
                'nb_disponible_constat' => 'required|numeric',
                'id_produit' => 'required',
            ]);
        // verifier disponibilite
        $constat = ConstatPoulet::where('id', $this->id_dernier_constat)->first();
        
        if($constat !=null)
        {
            if($this->nombre > $constat->nb_disponible){
                session()->flash('stock_not_ok', 'Opération impossible, stock insuffisant');
            }else{
            DB::beginTransaction();
                    try{
                        //création sortie poulet
                        $sortiePoulet = new SortiePoulet();
                        $sortiePoulet->id_type_sortie = $this->id_type_sortie;
                        $sortiePoulet->poids_total = $this->poids_total;
                        $sortiePoulet->nombre = $this->nombre;
                        $sortiePoulet->prix_unite = $this->prix_unite;
                        $sortiePoulet->date_sortie = $this->date_sortie;
                        $sortiePoulet->date_action = now();
                        $sortiePoulet->id_client = $this->id_client;
                        $sortiePoulet->id_utilisateur = $this->id_utilisateur;
                        $sortiePoulet->montant = ($this->prix_unite * $this->poids_total);
                        $sortiePoulet->pu_poulet = round($sortiePoulet->montant / $this->nombre, 2);
                
                        $sortiePoulet->save();
                    
                        // enregistrer detail sortie
                        $detailSortie = new DetailSortie();
                        $detailSortie->id_sortie = $sortiePoulet->id;
                        $detailSortie->id_constat = $this->id_dernier_constat;
                        $detailSortie->id_produit = $this->id_produit;
                        $detailSortie->qte = $this->qte_sortie;
                        $detailSortie->valeur = $this->valeur;
                        $detailSortie->pu = $this->prix_unitaire_sortie;
                        $detailSortie->save();

                        // mmettre à jour nombre disponible constat utilisé
                        $constat->update([
                            'nb_disponible' => $constat->nb_disponible - $this->qte_sortie,
                        ]); 

                        // enregistrement produit cycle
                        $produitCycle = new ProduitCycle();
                        $produitCycle->id_cycle = $constat->id_cycle;
                        $produitCycle->id_produit = $this->id_produit;
                        $produitCycle->id_sortie = $sortiePoulet->id;
                        $produitCycle->qte = $this->qte_sortie;
                        $produitCycle->pu = $this->prix_unitaire_sortie;
                        $produitCycle->valeur = $this->valeur;
                        $produitCycle->save();

                        $this->resetFormSortieConstat();
                        $this->resetValidation();
                        $this->isLoading = false;
                        $this->notification = true;
                        session()->flash('message', 'Sortie poulet bien enregistré!');
                        DB::commit();
                        $this->resetPage();
                    }catch(\Exception $e){
                        DB::rollback();
                        //return $e->getMessage();
                        session()->flash('message', $e->getMessage());
                        
                    }
            }
        }
    }

    /*
    * fin sortie constat
    */
}
