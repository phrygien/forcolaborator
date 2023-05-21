<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Cycle;
use App\Models\PrixOeuf;
use App\Models\PrixPoulet;
use App\Models\SortieOeuf;
use App\Models\TypeOeuf;
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

    public $sortie_id, $id_type_oeuf, $id_type_sortie, $qte, $pu, $id_utilisateur,$montant,
    $date_sortie, $id_client, $actif, $date_action, $nom, $raison_sociale, $adresse;

    public $confirmUpdate;
    public $typeOeufActifs;
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
        $this->typeOeufActifs = TypeOeuf::where('actif', 1)->get();
        $this->typeSortieActifs = TypeSortie::where('actif', 1)->get();
        $this->clientActifs = Client::all();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;
        $this->actif = 1;
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
    
        if ($this->id_type_oeuf) {
            $prixs = PrixOeuf::where('id_type_oeuf', $this->id_type_oeuf)
                        ->where('actif', 1)
                        ->get();
        }
    
        return $prixs;
    }

    public function updatedSelectedTypePoulet($value)
    {
        $this->pu = null;
    }


    public function render()
    {
        $sorties = DB::table('sortie_oeufs')
        ->join('type_oeufs', 'type_oeufs.id', 'sortie_oeufs.id_type_oeuf')
        ->join('clients', 'clients.id', 'sortie_oeufs.id_client')
        ->join('type_sorties', 'type_sorties.id', 'sortie_oeufs.id_type_sortie')
        ->join('users', 'users.id', 'sortie_oeufs.id_utilisateur')
        ->select('sortie_oeufs.*', 'clients.nom', 'type_oeufs.type', 'users.name', 'type_sorties.libelle')
        ->where('sortie_oeufs.actif', 1)
        ->paginate(7);
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
        $this->actif = 1;
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveNewSortie()
    {
        $this->isLoading = true;
        $this->validate([
            'id_type_oeuf' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            //'id_cycle' => 'required|integer',
            'nom' => 'required',
            'qte' => 'required|integer',
            'pu' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
            'montant' => 'nullable',
        ]);

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
                $sortieOeuf->actif = $this->actif;
                $sortieOeuf->id_client = $client->id;
                $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                $sortieOeuf->montant = ($this->pu * $this->qte);
        
                $sortieOeuf->save();
        
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
    }

    public function saveExistSortie()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'id_type_oeuf' => 'required|integer',
            'id_type_sortie' => 'required|integer',
            //'id_cycle' => 'required|integer',
            'qte' => 'required|integer',
            'pu' => 'required',
            'date_sortie' => 'required|date',
            'id_client' => 'nullable|integer',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable',
            'actif' => 'required|integer',
            'montant' => 'nullable',
        ]);

            try{

                //création sortie poulet
                $sortieOeuf = new SortieOeuf();
                $sortieOeuf->id_type_oeuf = $this->id_type_oeuf;
                $sortieOeuf->id_type_sortie = $this->id_type_sortie;
                $sortieOeuf->qte = $this->qte;
                $sortieOeuf->pu = $this->pu;
                $sortieOeuf->date_sortie = $this->date_sortie;
                $sortieOeuf->date_action = now();
                $sortieOeuf->actif = $this->actif;
                $sortieOeuf->id_client = $this->id_client;
                $sortieOeuf->id_utilisateur = $this->id_utilisateur;
                $sortieOeuf->montant = ($this->pu * $this->qte);
        
        
                $sortieOeuf->save();
        
                $this->resetFormSortie();
                $this->resetValidation();
                $this->isLoading = false;
                $this->notification = true;
                session()->flash('message', 'Sortie oeuf bien enregistré!');
                $this->createSortie = false;
                $this->afficherListe = true;
                $this->resetPage();
                }catch(\Exception $e){
        
                    return $e->getMessage();
                    //session()->flash('message', $e->getMessage());
                    
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

    public function comfirmerDelete($id)
    {
        $this->recordToDelete = SortieOeuf::findOrFail($id);
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
