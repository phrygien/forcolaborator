<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\ConstatOeuf;
use App\Models\Cycle;
use App\Models\DetailSortie;
use App\Models\PrixOeuf;
use App\Models\ProduitCycle;
use App\Models\SortieOeuf;
use App\Models\TypeOeuf;
use App\Models\TypeSortie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class LivSortieOeuf extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createSortie = false, $editSortie= false;

    public $sortie_id, $id_type_oeuf, $id_type_sortie, $qte, $pu, $id_utilisateur,$montant,
    $date_sortie, $id_client, $actif, $date_action, $nom, $raison_sociale, $adresse;

    public $confirmUpdate;
    public $typeOeufActifs = [];
    public $typeSortieActifs = [];
    public $clientActifs = [];
    public $newClient;
    public $cycleActifs;
    public $existClient;
    public $selectedOption;

    public $prix_unite_select;
    public $selectedTypePoulet;
    public $selectedPrixPoulet;

    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $addLigne = true;
    public $constatDisponibles = [];
    public $detailSortie;

    public $sortie = [
        'details' => [],
    ];

    public function addDetail()
    {
        $this->sortie['details'][] = [
            'id_constat' => null,
            'id_produit' => 'oeuf',
            'nb_disponible' => null,
            'qte_detail' => 0,
            'prix_unitaire_detail' => $this->pu,
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
        $constat = ConstatOeuf::find($id_constat);
    
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

    public function mount()
    {
        $this->date_action = date('Y-m-d');
        $this->date_sortie = date('Y-m-d');
        $this->typeOeufActifs = TypeOeuf::where('actif', 1)->get();
        $this->typeSortieActifs = TypeSortie::where('actif', 1)->whereIn('id', ['14','15'])->get();
        $this->clientActifs = Client::all();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;

        //$this->montant = ($this->prix_unite * $this->nombre);
        $this->constatDisponibles = ConstatOeuf::whereNotIn('id', $this->getDetailsSelectionnes())
        ->where('nb_disponible', '>', 0)
        ->orderBy('date_entree', 'asc')
        ->get();
    }

    public $selectedType = '';

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function getPrix()
    {
        $prixs = [];
    
        if ($this->id_type_oeuf) {
            $prixs = PrixOeuf::where('id_type_oeuf', $this->id_type_oeuf)
                        ->where('actif', 1)
                        ->get();
        }
    
        return $prixs;
    }

    public function updatedIdTypeOeuf()
    {
        $dernierSortieOeuf = SortieOeuf::where('id_type_oeuf', $this->id_type_oeuf)
            ->orderByDesc('date_sortie')
            ->first();
        
        $this->constatDisponibles = ConstatOeuf::whereNotIn('id', $this->getDetailsSelectionnes())
        ->where('nb_disponible', '>', 0)
        ->where('id_type_oeuf', $this->id_type_oeuf)
        ->orderBy('date_entree', 'asc')
        ->get();

        if ($dernierSortieOeuf) {
            $this->pu = $dernierSortieOeuf->pu;
        } else {
            $dernierPrixOeuf = PrixOeuf::where('id_type_oeuf', $this->id_type_oeuf)
                ->orderByDesc('date_application')
                ->first();

            if ($dernierPrixOeuf) {
                $this->pu = $dernierPrixOeuf->pu;
            } else {
                $this->pu = null;
            }
        }
    }

    public function calculateSumConstatOeuf()
    {
        $sommenbdisponible = ConstatOeuf::where('id_type_oeuf', $this->id_type_oeuf)
        ->sum('nb_disponible');
        if($sommenbdisponible >= $this->qte)
        {
            $this->addLigne = true;
        }else{
            session()->flash('somme_non_ok', 'Opperation impossible. Qte disponible pour ce type d\'oeuf ='.$sommenbdisponible);
            $this->addLigne = false;
        }
    }

    public function updatedMontant($value)
    {
        if (is_numeric($value) && is_numeric($this->qte) && $this->qte != 0) {
            $this->qte = $value / $this->qte;
        }
    }

    public function updatedPu($value)
    {
        if (is_numeric($value) && is_numeric($this->qte) && $this->qte != 0) {
            $this->montant = $value * $this->qte;
        }
    }

    public function updatedQte($value)
    {
        if (is_numeric($value) && is_numeric($this->pu) && $value != 0) {
            $this->montant = $this->pu * $value;
        }
        $this->calculateSumConstatOeuf();
    }


    public function render()
    {
        $sorties = DB::table('sortie_oeufs')
        ->join('type_oeufs', 'type_oeufs.id', 'sortie_oeufs.id_type_oeuf')
        ->join('clients', 'clients.id', 'sortie_oeufs.id_client')
        ->join('type_sorties', 'type_sorties.id', 'sortie_oeufs.id_type_sortie')
        ->join('users', 'users.id', 'sortie_oeufs.id_utilisateur')
        ->select('sortie_oeufs.*', 'clients.nom', 'type_oeufs.type', 'users.name', 'type_sorties.libelle')
        ->orderBy('date_sortie', 'desc')
        ->paginate(15);

        $prixs = $this->getPrix();
        return view('livewire.liv-sortie-oeuf', [
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
        $this->id_type_oeuf = '';
        $this->id_type_sortie = '';
        $this->id_client = '';
        $this->nom = '';
        $this->raison_sociale = '';
        $this->adresse = '';
        $this->qte = '';
        $this->pu = '';
        $this->date_sortie = date('Y-m-d');
        $this->date_action = '';
        $this->montant = '';
        $this->creatBtn = false;
        $this->sortie['details'] = [];
        $this->resetValidation();
    }

    public function saveNewSortie()
    {
        $this->isLoading = true;
        $this->validate([
            'id_type_oeuf' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'montant' => 'required|integer',
            'nom' => 'required',
            'qte' => 'required|integer',
            'pu' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
        ]);

        $total = 0;

        if($this->sortie['details']){
            foreach ($this->sortie['details'] as $detail) {
                $total += $detail['qte_detail'];
            }
        }

        if($total == $this->qte){
        DB::beginTransaction();
            try{
                //creation de nouvele client
                $client = new Client();
                $client->nom = $this->nom;
                $client->raison_sociale = $this->raison_sociale;
                $client->adresse = $this->adresse;
                $client->save();
                //création sortie oeuf
                $sortieOeuf = new SortieOeuf();
                $sortieOeuf->id_type_oeuf = $this->id_type_oeuf;
                $sortieOeuf->id_type_sortie = $this->id_type_sortie;
                $sortieOeuf->qte = $this->qte;
                $sortieOeuf->pu = $this->pu;
                $sortieOeuf->date_sortie = $this->date_sortie;
                $sortieOeuf->date_action = now();
                $sortieOeuf->id_client = $client->id;
                $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                $sortieOeuf->montant = ($this->pu * $this->qte);
        
                $sortieOeuf->save();
        
                // Enregistrer les détails de la commande dans la table "details_commande"
                foreach ($this->sortie['details'] as $detail) {
                    DetailSortie::create([
                        'id_sortie' => $sortieOeuf->id,
                        'id_constat' => $detail['id_constat'],
                        'id_produit' => $detail['id_produit'],
                        'qte' => $detail['qte_detail'],
                        'pu' => $detail['prix_unitaire_detail'],
                        'valeur' => $detail['montant_total_detail'],
                    ]);

                    // Modifier la quantité de stock du constat utilisé dans le sortie
                    $constatUsed = ConstatOeuf::where('id', $detail['id_constat'])->first();
                    if ($constatUsed) {
                        $constatUsed->nb_disponible -= $detail['qte_detail'];
                        $constatUsed->save();
                    }

                    //$constatData = ConstatPoulet::where('id', $detail['id_constat'])->first();
                    // enregistrement produit cycle
                    $produitCycle = new ProduitCycle();
                    $produitCycle->id_cycle = $constatUsed->id_cycle;
                    $produitCycle->id_produit = $detail['id_produit'];
                    $produitCycle->id_sortie = $sortieOeuf->id;
                    $produitCycle->qte = $detail['qte_detail'];
                    $produitCycle->pu = $detail['prix_unitaire_detail'];
                    $produitCycle->valeur = $detail['montant_total_detail'];
                    $produitCycle->save();

                }

                $this->resetFormSortie();
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
            }else{
                //$this->notification = true;
                session()->flash('impossible', 'Opération impossible. La somme des quantités de détail doit être égale au nombre de poulets à sortir !');
            }
    }

    public function saveExistSortie()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'montant' => 'required|integer',
            'qte' => 'required|integer',
            'pu' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
        ]);

            DB::beginTransaction();
            try{

                $ouefs = ConstatOeuf::where('nb_disponible', '>', 0)
                ->where('id_type_oeuf', $this->id_type_oeuf)
                ->get();

                $total_nb_disponible = 0;
                if($ouefs)
                {
                    foreach($ouefs as $oeuf){
                        $total_nb_disponible +=$oeuf->nb_disponible;
                    }
                }

                if($this->qte <= $total_nb_disponible)
                {
                    // recuper oeuf par type d'oeuf
                    $ouefs = ConstatOeuf::where('nb_disponible', '>', 0)
                    ->where('id_type_oeuf', $this->id_type_oeuf)
                    ->orderBy('date_entree', 'DESC')
                    ->get();

                    $totalQte = $this->qte;
                    $selectedOeuf = collect();
                
                    $utilisationQte = $totalQte;

                    foreach($ouefs as $detail)
                    {
                        $qte = $detail->nb_disponible;

                        if($utilisationQte > 0){
                            if($utilisationQte >= $qte){
                                $selectedOeuf->push($detail);
                                $utilisationQte -= $qte;
                                $detail->update(['nb_disponible' => $qte - $qte]);
                                $qteUtilisee = $qte;
                            }else{
                                $selectedOeuf->push($detail->replicate(['nb_disponible']));
                                $detail->update(['nb_disponible' => $qte - $utilisationQte]);
                                $qteUtilisee = $utilisationQte;
                                $utilisationQte = 0;
                            }
                        }else{
                            break;
                        }

                        //création sortie oeuf
                        $sortieOeuf = new SortieOeuf();
                        $sortieOeuf->id_type_oeuf = $this->id_type_oeuf;
                        $sortieOeuf->id_type_sortie = $this->id_type_sortie;
                        $sortieOeuf->qte = $this->qte;
                        $sortieOeuf->pu = $this->pu;
                        $sortieOeuf->date_sortie = $this->date_sortie;
                        $sortieOeuf->date_action = now();
                        $sortieOeuf->id_client = $this->id_client;
                        $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                        $sortieOeuf->montant = ($this->pu * $this->qte);
                        $sortieOeuf->save();

                        // enregistrer details sortie
                        DetailSortie::create([
                            'id_sortie' => $sortieOeuf->id,
                            'id_constat' => $detail->id,
                            'id_produit' => 'oeuf',
                            'qte' => $qteUtilisee,
                            'pu' => $this->pu,
                            'valeur' => $this->pu * $qteUtilisee,
                        ]);

                        $constatUsed = ConstatOeuf::where('id', $detail->id)->first();
                        // enregistrement produit cycle
                        $produitCycle = new ProduitCycle();
                        $produitCycle->id_cycle = $constatUsed->id_cycle;
                        $produitCycle->id_produit = 'oeuf';
                        $produitCycle->id_sortie = $sortieOeuf->id;
                        $produitCycle->qte = $qteUtilisee;
                        $produitCycle->pu = $this->pu;
                        $produitCycle->valeur = $this->pu * $qteUtilisee;
                        $produitCycle->save();

                        DB::commit();

                        // $this->isLoading = false;
                        // $this->notification = true;
                        // session()->flash('message', 'Sortie oeuf bien enregistré!');
                        // DB::commit();
                    }
                    $this->notification = true;
                    session()->flash('message', 'Utilisation charge bien enregistré!');
                    $this->resetFormSortie();
                    $this->resetValidation();

                    $this->createSortie = false;
                    $this->afficherListe = true;
                    $this->resetPage();

                }else{
                    session()->flash('impossible', 'Opération impossible. La somme des quantités de détail doit être égale au nombre de poulets à sortir !');
                }
                
            }catch(\Exception $e){
        
                    return $e->getMessage();
                    //session()->flash('message', $e->getMessage());
                    DB::rollBack();
                    
                
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
        $sortie = SortieOeuf::findOrFail($id);
        $this->sortie_id = $id;
        $this->id_type_oeuf = $sortie->id_type_oeuf;
        $this->id_type_sortie = $sortie->id_type_sortie;
        $this->date_action = $sortie->date_constat;
        $this->qte = $sortie->qte;
        $this->pu = $sortie->pu;
        $this->date_sortie = $sortie->date_sortie;
        $this->id_client = $sortie->id_client;
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
            'id_type_oeuf' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'qte' => 'required|integer',
            'montant' => 'required|integer',
            'pu' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
        ]);

        try{
            
            $sortie = SortieOeuf::findOrFail($this->sortie_id);
            $sortie->update([
                'id_type_oeuf' => $this->id_type_oeuf,
                'id_type_sortie' => $this->id_type_sortie,
                'qte' => $this->qte,
                'pu' => $this->pu,
                'date_sortie' => $this->date_sortie,
                'id_client' => $this->id_client,
                'actif' => $this->actif,
                'date_action' => $this->date_action,
                'id_utilisateur' => $this->id_utilisateur,
                'montant' => ($this->pu * $this->qte),
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



    public $retourSortie;
    public $retour;
    public $id_detail, $retour_id_constat, $retour_id_produit, $retour_qte, $retour_valeur, $retour_pu, $qte_retour;
    public $disableBtnValider = '';
    public $confirmRetour;

    public function retourSortie($id)
    {
        $this->retourSortie = true;
        $this->afficherListe = false;
        $this->isLoading = true;

        $sortie = SortieOeuf::findOrFail($id);

        $this->sortie_id = $id;
        $this->id_type_sortie = $sortie->id_type_sortie;
        $this->id_type_oeuf = $sortie->id_type_oeuf;
        $this->qte = $sortie->qte;
        $this->pu = $sortie->pu;
        $this->date_sortie = $sortie->date_sortie;
        $this->id_client = $sortie->id_client;
        $this->montant = $sortie->montant;
        $this->retour = $sortie->retour;

        // trouver les details du sortie
        $this->detailSortie = DetailSortie::where('id_sortie', $sortie->id)->get();
        
        foreach($this->detailSortie as $detail)
        {
            $this->id_detail = $detail->id;
            $this->retour_id_constat = $detail->id_constat;
            $this->retour_id_produit = $detail->id_produit;
            $this->retour_qte = $detail->qte;
            $this->retour_valeur = $detail->valeur;
            $this->retour_pu = $detail->pu;
        }

        $this->isLoading = false;

    }

    public function confirmerRetour()
    {
        $this->confirmRetour = true;
    }

    public function cancelRetour()
    {
        $this->confirmRetour = false;
        $this->retourSortie = true;
        $this->afficherListe = false;
        //$this->resetFormSortie();
    }

    public function afficherSortie()
    {
        $this->isLoading = true;
        $this->afficherListe = true;
        $this->retourSortie = false;
        $this->resetFormSortie();
        $this->resetValidation();
        $this->resetQteRetour();
        $this->isLoading = false;
    }

    public function resetQteRetour()
    {
        $this->qte_retour = '';
        $this->resetValidation();
    }

    public function saveRetour()
    {
        $this->isLoading = true;
        $this->validate([
            'qte_retour' => 'required|integer',
        ]);

        DB::beginTransaction();

        try{

            $sortie = SortieOeuf::findOrFail($this->sortie_id);
            $sortie->update([
                'retour' => 1,
            ]);

            // recuperation details sortie concernee
            $detailSortie = DetailSortie::where('id_sortie', $this->sortie_id)->get();
            $totalQteRetour = $this->qte_retour;
            $selectedDetails = collect();
        
            $remainingQte = $totalQteRetour;

            foreach($detailSortie as $details)
            {
                $qte = $details->qte;

                if ($remainingQte > 0) {
                    if ($remainingQte >= $qte) {
                        $selectedDetails->push($details);
                        $remainingQte -= $qte;
                        //$details->delete();
                        //$details->update(['qte' => $qte - $qte]);
                    } else {
                        // Si la quantité restante est inférieure à la quantité du détail actuel, divisez le détail en deux parties
                        $selectedDetails->push($details->replicate(['qte']));
                        //$details->update(['qte' => $qte - $remainingQte]);
                        $remainingQte = 0;
                    }
                }else{
                    break;
                }
                // trouver constat du detail sortie
                $constat = ConstatOeuf::where('id', $details->id_constat)->first();

                $produitCycle = new ProduitCycle();
                $produitCycle->id_cycle = $constat->id_cycle;
                $produitCycle->id_produit = $details['id_produit'];
                $produitCycle->id_sortie = $this->sortie_id;
                $produitCycle->qte = -$details->qte;
                $produitCycle->pu = -$details->pu;
                $produitCycle->valeur = -$details->valeur;
                $produitCycle->save();

                // creation nouveau constat
                $constatOeuf = new ConstatOeuf();
                $constatOeuf->id_type_oeuf = $constat->id_type_oeuf;
                $constatOeuf->nb = $details->qte;
                $constatOeuf->id_cycle = $constat->id_cycle;
                $constatOeuf->date_entree = now();
                $constatOeuf->date_action = now();
                $constatOeuf->nb_disponible = $details->qte;
                $constatOeuf->id_utilisateur = Auth::user()->id;
                $constatOeuf->retour = 0;
                $constatOeuf->save();

            }
            // $this->editSortie = false;
            $this->resetQteRetour();
            $this->resetValidation();
            $this->resetFormSortie();
            $this->confirmRetour = false;
            $this->creatBtn = true;
            $this->notification = true;
            session()->flash('message', 'Retour produit bien enregistré!');
            $this->afficherListe = true;
            $this->retourSortie = false;

            DB::commit();

        }catch(\Exception $e){
            return $e->getMessage();
            DB::rollback();
        }
        $this->isLoading = false;
    }

    public function updatedQteRetour()
    {
        $this->validate([
            'qte_retour' => 'required|integer',
        ]);
        
        if($this->qte_retour > $this->qte){
            session()->flash('retour_impossible', 'Impossible de retourner cette quantite, le quanite à reourner doit inferieur a la qte sortie!');
            $this->disableBtnValider = 'disabled';
        }else{
            $this->disableBtnValider = '';
        }
    }
}
