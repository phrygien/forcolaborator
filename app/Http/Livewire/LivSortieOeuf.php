<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Cycle;
use App\Models\PrixPoulet;
use App\Models\SortieOeuf;
use App\Models\TypePoulet;
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

    public $sortie_id, $id_type_oeuf, $id_type_sortie, $qte, $pu, $id_utilisateur,
    $date_sortie, $id_client, $id_cycle, $actif, $date_action, $nom, $raison_sociale, $adresse, $montant;

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

    public function updatedSelectedTypePoulet($value)
    {
        $this->prix_unite = null;
    }


    public function render()
    {
        $sorties = DB::table('sortie_poulets')
        ->join('type_poulets', 'type_poulets.id', 'sortie_poulets.id_type_poulet')
        ->join('clients', 'clients.id', 'sortie_poulets.id_client')
        ->join('type_sorties', 'type_sorties.id', 'sortie_poulets.id_type_sortie')
        ->join('users', 'users.id', 'sortie_poulets.id_utilisateur')
        ->select('sortie_poulets.*', 'clients.nom', 'type_poulets.type', 'users.name', 'type_sorties.libelle')
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
        $this->actif = '';
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveNewSortie()
    {
        $this->isLoading = true;
        $this->validate([
            'id_type_poulet' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            'id_cycle' => 'required|integer',
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

        DB::beginTransaction();
        $cycleSelected = Cycle::find($this->id_cycle);
        $stockActuale = $cycleSelected->nb_poulet;
        if($stockActuale >= $this->nombre){
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
                $sortiePoulet->montant = ($this->prix_unite * $this->nombre);
        
                $sortiePoulet->save();
                //update stock cyle selected
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
                'id_client' => $this->id_client,
                'actif' => $this->actif,
                'date_action' => $this->date_action,
                'id_utilisateur' => $this->id_utilisateur,
                'montant' => ($this->prix_unite * $this->nombre),
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