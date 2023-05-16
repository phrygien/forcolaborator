<?php

namespace App\Http\Livewire;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class LivClient extends Component
{
    use WithPagination;
    public $isLoading, $client_id, $nom, $raison_sociale, $adresse;
    public $afficherListe=true;
    public $createClient=false;
    public $editClient=false;
    public $notification =false; 
    public $confirmUpdate = false; 
    public $recordToDelete;
    public $btnCreate = true;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $clients = Client::select('clients.nom', 'clients.raison_sociale', 'clients.adresse')
        ->leftJoin('sortie_poulets', 'clients.id', '=', 'sortie_poulets.id_client')
        ->selectRaw('clients.*, COALESCE(SUM(sortie_poulets.nombre * sortie_poulets.prix_unite), 0) as total_montant')
        ->groupBy('clients.id')
        ->paginate(10);

        return view('livewire.liv-client', [
            'clients' => $clients
        ]);
    }

    public function formClient()
    {
        $this->isLoading = true;
        $this->createClient =true;
        $this->afficherListe = false;
        $this->btnCreate = false;
        $this->isLoading = false;
    }

    public function resetInput()
    {
        $this->nom = '';
        $this->raison_sociale = '';
        $this->adresse = '';
        $this->resetValidation();
    }

    public function saveClient()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nom' => 'required|unique:clients,nom',
            'raison_sociale' => 'required',
            'adresse' => 'required'
        ]);

        try{

        Client::create($data);
        $this->notification = true;
        session()->flash('message', 'Client bien enregistré!');
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
        $this->createClient = false;
        $this->afficherListe = true;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->isLoading = false;
    }

    public function editClient($id)
    {
        $this->isLoading = true;

        $client = Client::findOrFail($id);
        $this->nom = $client->nom;
        $this->raison_sociale = $client->raison_sociale;
        $this->adresse = $client->adresse;
        $this->client_id = $id;
        $this->editClient = true;
        $this->createClient = false;
        $this->btnCreate = false;
        $this->isLoading = false;
        $this->afficherListe = false;
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

    public function updateClient()
    {
        $this->isLoading = true;

        $this->validate([
            'nom' => 'required|unique:clients,nom,' . $this->client_id,
            'raison_sociale' => 'required',
            'adresse' => 'required'
        ]);

        try{

            $client = Client::findOrFail($this->client_id);
            $client->update([
                'nom' => $this->nom,
                'raison_sociale' => $this->raison_sociale,
                'adresse' => $this->adresse,
            ]);

            session()->flash('message', 'Modification avec sucée');
            $this->editClient = false;
            $this->notification = true;
            $this->resetInput();
            $this->resetValidation();
            $this->confirmUpdate = false;
            $this->afficherListe = true;
            $this->btnCreate = true;

            $this->isLoading = false;
        }catch(\Exception $e){

        }

    }

    public function cancelModal()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editClient = true;

        $this->isLoading = false;
    }

    public function cancelUpdate()
    {
        $this->isLoading = true;

        $this->confirmUpdate = false;
        $this->editClient = false;
        $this->resetInput();
        $this->resetValidation();
        $this->btnCreate = true;
        $this->afficherListe = true;
        $this->isLoading = false;
    }

    public function confirmerDelete($id)
    {
        $this->recordToDelete = Client::findOrFail($id);
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
            //$this->notification = true;
            session()->flash('error', 'Impossible de supprimer le client. Il est déja utilisé !');
        }

    }

}
