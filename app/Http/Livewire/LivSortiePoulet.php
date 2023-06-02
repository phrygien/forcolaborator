<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\ConstatPoulet;
use App\Models\Cycle;
use App\Models\PrixPoulet;
use App\Models\SortiePoulet;
use App\Models\TypePoulet;
use App\Models\TypeSortie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class LivSortiePoulet extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createSortie = false, $editSortie= false;

    public $sortie_id, $id_type_poulet, $id_type_sortie, $poids_total, $nombre, $id_utilisateur,
    $prix_unite, $date_sortie, $id_client, $id_cycle, $actif, $date_action, $nom, $raison_sociale, $adresse, $montant;

    public $confirmUpdate;
    public $typePouletActifs;
    public $typeSortieActifs;
    public $clientActifs;
    public $newClient;
    public $cycleActifs;
    public $existClient;
    public $selectedOption;
    public $recordToDelete;

    public $prix_unite_select;
    public $selectedTypePoulet;
    public $selectedPrixPoulet;

    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;
    public $addLigne = true;

    public $constatDisponibles;
    /*
    * debut utils sortie poulet
    */
    public $sortie = [
        'nom_client' => '',
        'adresse' => '',
        'date_commande' => '',
        'details' => [],
    ];

    public function addDetail()
    {
        $this->sortie['details'][] = [
            'id_constat' => null,
            'id_produit' => null,
            'nb_disponible' => null,
            'qte_detail' => 0,
            'prix_unitaire_detail' => 0,
            'montant_total_detail' => 0,
        ];
    }

    public function removeDetail($index)
    {
        unset($this->sortie['details'][$index]);
        $this->sortie['details'] = array_values($this->sortie['details']);
    }

    public function actualiserDetail()
    {
        $this->creatBtn = false;
    }

    private function getDetailsSelectionnes()
    {
        return collect($this->sortie['details'])->pluck('id_constat')->filter()->all();
    }

    public function getNombreDisponible($id_constat)
    {
        $constat = ConstatPoulet::find($id_constat);
    
        if ($constat) {
            return $constat->nb_disponible;
        }
    
        return 0;
    }
    

    public function updateNombreDisponible($id_constat, $index)
    {
        $nombreDisponible = $this->getNombreDisponible($id_constat);

        $this->sortie['details'][$index]['nb_disponible'] = $nombreDisponible;
    }


    // public function updatedSortieDetails($index)
    // {
    //     $qte = $this->sortie['details'][$index]['qte_detail'];
    //     $prixUnitaire = $this->sortie['details'][$index]['prix_unitaire_detail'];

    //     $this->sortie['details'][$index]['montant_total_detail'] = $qte * $prixUnitaire;
    // }

    public function calculateMontantTotal($index)
    {
        $qte = $this->sortie['details'][$index]['qte_detail'];
        $prixUnitaire = $this->sortie['details'][$index]['prix_unitaire_detail'];
        $nbDisponible = $this->sortie['details'][$index]['nb_disponible'];

        if(is_numeric($qte) && is_numeric($prixUnitaire)){
            $this->sortie['details'][$index]['montant_total_detail'] = $qte * $prixUnitaire;
        }else{
            $this->sortie['details'][$index]['montant_total_detail'] = '';
        }

        if(is_numeric($qte) || is_numeric($prixUnitaire)){
            if ($qte > $nbDisponible) {
                session()->flash("error.{$index}", 'La quantité saisie est supérieure au nombre disponible.');
                $this->addLigne = false;
            }else
            {
                $this->addLigne = true;
            }
        }
    }

    /*
    * fin utils sortie poulet
    */
    public function mount()
    {
        $this->date_action = date('Y-m-d');
        $this->date_sortie = date('Y-m-d');
        $this->typePouletActifs = TypePoulet::where('actif', 1)->get();
        $this->typeSortieActifs = TypeSortie::where('actif', 1)->get();
        $this->clientActifs = Client::all();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
        //$this->montant = ($this->prix_unite * $this->nombre);
        $this->actif = 1;

        $this->constatDisponibles = ConstatPoulet::whereNotIn('id', $this->getDetailsSelectionnes())->get();
    }

    public $selectedType = '';

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function getPrix()
    {
        $prixs = [];
    
        if ($this->id_type_poulet) {
            $prixs = PrixPoulet::where('id_type_poulet', $this->id_type_poulet)
                        ->where('actif', 1)
                        ->get();
        }
    
        return $prixs;
    }


    public function updatedIdTypePoulet()
    {
        $dernierSortiePoulet = SortiePoulet::where('id_type_poulet', $this->id_type_poulet)
            ->orderByDesc('date_sortie')
            ->first();

        if ($dernierSortiePoulet) {
            $this->prix_unite = $dernierSortiePoulet->prix_unite;
        } else {
            $dernierPrixPoulet = PrixPoulet::where('id_type_poulet', $this->id_type_poulet)
                ->orderByDesc('date_application')
                ->first();

            if ($dernierPrixPoulet) {
                $this->prix_unite = $dernierPrixPoulet->pu_kg;
            } else {
                $this->prix_unite = null;
            }
        }
    }

    public function updatedMontant($value)
    {
        if (is_numeric($value) && is_numeric($this->poids_total) && $this->poids_total != 0) {
            $this->poids_total = $value / $this->poids_total;
        }
    }

    public function updatedPrixUnite($value)
    {
        if (is_numeric($value) && is_numeric($this->poids_total) && $this->poids_total != 0) {
            $this->montant = $value * $this->poids_total;
        }
    }

    public function updatedPoidsTotal($value)
    {
        if (is_numeric($value) && is_numeric($this->prix_unite) && $value != 0) {
            $this->montant = $this->prix_unite * $value;
        }
    }

    public function render()
    {
        $sorties = DB::table('sortie_poulets')
        ->join('clients', 'clients.id', 'sortie_poulets.id_client')
        ->join('type_sorties', 'type_sorties.id', 'sortie_poulets.id_type_sortie')
        ->join('users', 'users.id', 'sortie_poulets.id_utilisateur')
        ->select('sortie_poulets.*', 'clients.nom', 'users.name', 'type_sorties.libelle')
        ->orderBy('date_sortie', 'DESC')
        ->paginate(7);
        $prixs = $this->getPrix();
        return view('livewire.liv-sortie-poulet', [
            'sorties' => $sorties,
            'prixs' => $prixs
        ]);
    }

    public function forNewClient()
    {
        $this->newClient = true;
    }

    public function forExistClient()
    {
        $this->existClient = true;
    }

    public function formSortie()
    {
        $this->isLoading = true;
        $this->createSortie = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    public function resetFormSortie()
    {
        $this->id_type_poulet = '';
        $this->id_type_sortie = '';
        $this->id_client = '';
        $this->id_cycle = '';
        $this->nom = '';
        $this->raison_sociale = '';
        $this->adresse = '';
        $this->poids_total = '';
        $this->nombre = '';
        $this->prix_unite = '';
        //$this->date_sortie = '';
        $this->date_action = '';
        $this->montant = '';
        $this->actif = 1;
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveNewSortie()
    {
        $this->isLoading = true;
        if($this->selectedOption == "existe"){
        $this->validate([
            'id_type_poulet' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'poids_total' => 'required',
            'nombre' => 'required|integer',
            'prix_unite' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
            'montant' => 'nullable',
        ]);
        }else{
            $this->validate([
                'id_type_poulet' => 'required|integer',
                'id_type_sortie' => 'required|integer',
                'poids_total' => 'required',
                'nombre' => 'required|integer',
                'nom' => 'required',
                'prix_unite' => 'required',
                'date_sortie' => 'required|date',
                'id_client' => 'nullable|integer',
                'id_utilisateur' => 'nullable',
                'date_action' => 'nullable',
                'actif' => 'required|integer',
                'montant' => 'nullable',
            ]);     
        }
        if($this->id_cycle !=null){
                $cycleSelected = Cycle::find($this->id_cycle);
                $stockActuale = $cycleSelected->nb_poulet;
                if($stockActuale >= $this->nombre){
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
                        $sortiePoulet->id_type_poulet = $this->id_type_poulet;
                        $sortiePoulet->id_type_sortie = $this->id_type_sortie;
                        $sortiePoulet->id_cycle = $this->id_cycle;
                        $sortiePoulet->poids_total = $this->poids_total;
                        $sortiePoulet->nombre = $this->nombre;
                        $sortiePoulet->prix_unite = $this->prix_unite;
                        $sortiePoulet->date_sortie = $this->date_sortie;
                        $sortiePoulet->date_action = now();
                        $sortiePoulet->actif = $this->actif;
                        $sortiePoulet->id_client = $client->id;
                        $sortiePoulet->id_utilisateur = $this->id_utilisateur;
                        $sortiePoulet->montant = ($this->prix_unite * $this->poids_total);
                
                        $sortiePoulet->save();
                        //update stock cyle selected
                        $cycleSelected = Cycle::find($this->id_cycle);
                        $stockActuale = $cycleSelected->nb_poulet;
                        $cycleSelected->update([
                            'nb_poulet' => ($stockActuale - $this->poids_total),
                        ]);
                        $cycleSelected->save();
                
                        $this->resetFormSortie();
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
                }else{
                    $this->notification = true;
                    session()->flash('error', 'Operation impossible, stock du cycle insufusant!');
                }
        }else{
            DB::beginTransaction();
            try{
            $client = new Client();
            $client->nom = $this->nom;
            $client->raison_sociale = $this->raison_sociale;
            $client->adresse = $this->adresse;
            $client->save();
            
            $sortiePoulet = new SortiePoulet();
            $sortiePoulet->id_type_poulet = $this->id_type_poulet;
            $sortiePoulet->id_type_sortie = $this->id_type_sortie;
            $sortiePoulet->id_cycle = NULL;
            $sortiePoulet->poids_total = $this->poids_total;
            $sortiePoulet->nombre = $this->nombre;
            $sortiePoulet->prix_unite = $this->prix_unite;
            $sortiePoulet->date_sortie = $this->date_sortie;
            $sortiePoulet->date_action = now();
            $sortiePoulet->actif = $this->actif;
            $sortiePoulet->id_client = $client->id;
            $sortiePoulet->id_utilisateur = $this->id_utilisateur;
            $sortiePoulet->montant = ($this->prix_unite * $this->poids_total);
            $sortiePoulet->save();
            $this->resetFormSortie();
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

    public function saveExistSortie()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_poulet' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'poids_total' => 'required',
            'nombre' => 'required|integer',
            'prix_unite' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
        ]);

        if($this->id_cycle !=null){
        $cycleSelected = Cycle::find($this->id_cycle);
        $stockActuale = $cycleSelected->nb_poulet;
        if($stockActuale >= $this->nombre){

            try{

                //création sortie poulet
                $sortiePoulet = new SortiePoulet();
                $sortiePoulet->id_type_poulet = $this->id_type_poulet;
                $sortiePoulet->id_type_sortie = $this->id_type_sortie;
                $sortiePoulet->id_cycle = $this->id_cycle;
                $sortiePoulet->poids_total = $this->poids_total;
                $sortiePoulet->nombre = $this->nombre;
                $sortiePoulet->prix_unite = $this->prix_unite;
                $sortiePoulet->date_sortie = $this->date_sortie;
                $sortiePoulet->date_action = now();
                $sortiePoulet->actif = $this->actif;
                $sortiePoulet->id_client = $this->id_client;
                $sortiePoulet->id_utilisateur = $this->id_utilisateur;
                $sortiePoulet->montant = ($this->prix_unite * $this->nombre);
        
                $sortiePoulet->save();
        
                $cycleSelected = Cycle::find($this->id_cycle);
                $stockActuale = $cycleSelected->nb_poulet;
                $cycleSelected->update([
                    'nb_poulet' => ($stockActuale - $this->nombre),
                ]);
                $cycleSelected->save();
        
                $this->resetFormSortie();
                $this->resetValidation();
                $this->isLoading = false;
                $this->notification = true;
                session()->flash('message', 'Sortie poulet bien enregistré!');
                $this->createSortie = false;
                $this->afficherListe = true;
                $this->resetPage();
                }catch(\Exception $e){
        
                    return $e->getMessage();
                    //session()->flash('message', $e->getMessage());
                    
                }
        }else{
            $this->notification = true;
            session()->flash('error', 'Operation impossible, stock du cycle insufusant!');
        }
        }else{
            //création sortie poulet
            $sortiePoulet = new SortiePoulet();
            $sortiePoulet->id_type_poulet = $this->id_type_poulet;
            $sortiePoulet->id_type_sortie = $this->id_type_sortie;
            //$sortiePoulet->id_cycle = $this->id_cycle;
            $sortiePoulet->poids_total = $this->poids_total;
            $sortiePoulet->nombre = $this->nombre;
            $sortiePoulet->prix_unite = $this->prix_unite;
            $sortiePoulet->date_sortie = $this->date_sortie;
            $sortiePoulet->date_action = now();
            $sortiePoulet->actif = $this->actif;
            $sortiePoulet->id_client = $this->id_client;
            $sortiePoulet->id_utilisateur = $this->id_utilisateur;
            $sortiePoulet->montant = ($this->prix_unite * $this->nombre);
    
            $sortiePoulet->save();
            
            $this->resetFormSortie();
            $this->resetValidation();
            $this->isLoading = false;
            $this->notification = true;
            session()->flash('message', 'Sortie poulet bien enregistré!');
            $this->createSortie = false;
            $this->afficherListe = true;
            $this->resetPage();
        }
    }


    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createSortie = false;
        $this->afficherListe = true;
        $this->resetFormSortie();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editSortie($id)
    {
        $sortie = SortiePoulet::findOrFail($id);
        $this->sortie_id = $id;
        $this->id_type_poulet = $sortie->id_type_poulet;
        $this->id_type_sortie = $sortie->id_type_sortie;
        $this->poids_total = $sortie->poids_total;
        $this->date_action = $sortie->date_constat;
        $this->nombre = $sortie->nombre;
        $this->prix_unite = $sortie->prix_unite;
        $this->date_sortie = $sortie->date_sortie;
        $this->id_client = $sortie->id_client;
        $this->id_cycle = $sortie->id_cycle;
        $this->actif = $sortie->actif;
        $this->date_action = $sortie->date_action;
        $this->id_utilisateur = $sortie->id_utilisateur;
        $this->montant = $sortie->montant;

        $this->editSortie = true;
        $this->createSortie = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateSortie()
    {
        $this->validate([
            'id_type_poulet' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'poids_total' => 'required',
            'nombre' => 'required|integer',
            'prix_unite' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
        ]);

        try{
            
            $sortie = SortiePoulet::findOrFail($this->sortie_id);
            $sortie->update([
                'id_type_poulet' => $this->id_type_poulet,
                'id_type_sortie' => $this->id_type_sortie,
                'poids_total' => $this->poids_total,
                'nombre' => $this->nombre,
                'prix_unite' => $this->prix_unite,
                'date_sortie' => $this->date_sortie,
                'id_cycle' => $this->id_cycle,
                'id_client' => $this->id_client,
                'actif' => $this->actif,
                'date_action' => $this->date_action,
                'id_utilisateur' => $this->id_utilisateur,
                'montant' => ($this->prix_unite * $this->poids_total),
            ]);

            $this->editSortie = false;
            $this->resetFormSortie();
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
        $this->editSortie = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editSortie = false;
        $this->resetFormSortie();
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
        $this->recordToDelete = SortiePoulet::findOrFail($id);
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

}
