<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\DetailSortie;
use App\Models\SortiePoulet;
use App\Models\TypeSortie;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailsSortie extends Component
{

    public $selectedSortie;
    public $detailSorties;
    public $typesorties ;
    public $clients;
    public $validerRetour;
    public $retourValide;
    /*
    * propriete sortie poulet
    */
    public $id_sortie, $id_type_sortie, $poids_total, $nombre, $prix_unite, $date_sortie, $id_client, $montant, $pu_poulet, $retour;
    
    public function mount($idConstat)
    {
        //$this->selectedSortie = SortiePoulet::where('id', $idConstat)->get();
        $this->selectedSortie = DB::table('sortie_poulets')
                                ->join('clients', 'clients.id', 'sortie_poulets.id_client')
                                ->select('sortie_poulets.*', 'clients.nom', 'clients.raison_sociale', 'clients.adresse')
                                ->where('sortie_poulets.id', $idConstat)
                                ->get();

        $this->detailSorties = DetailSortie::where('id_sortie', $idConstat)->get();

        $this->id_sortie = $this->selectedSortie[0]->id;
        $this->id_type_sortie = $this->selectedSortie[0]->id_type_sortie;
        $this->poids_total = $this->selectedSortie[0]->poids_total;
        $this->nombre = $this->selectedSortie[0]->nombre;
        $this->prix_unite = $this->selectedSortie[0]->prix_unite;
        $this->date_sortie = $this->selectedSortie[0]->date_sortie;
        $this->id_client = $this->selectedSortie[0]->id_client;
        $this->montant = $this->selectedSortie[0]->montant;
        $this->pu_poulet = $this->selectedSortie[0]->pu_poulet;
        $this->retour = $this->selectedSortie[0]->retour;

        $this->typesorties = TypeSortie::where('actif', 1)->get();
        $this->clients = Client::all();
    }


    public function render()
    {
        return view('livewire.details-sortie', [
            'retourValide' => $this->retourValide,
        ]);
    }

    /*
    * valider retour sortie poulet
    */
    public function validerRetour()
    {
        $sortie = SortiePoulet::findorFail($this->id_sortie);
    }
}
