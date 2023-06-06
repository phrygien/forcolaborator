<?php

namespace App\Http\Livewire;

use App\Models\DetailSortie;
use App\Models\SortiePoulet;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailsSortie extends Component
{

    public $selectedSortie;
    public $detailSorties;

    public function mount($idConstat)
    {
        //$this->selectedSortie = SortiePoulet::where('id', $idConstat)->get();
        $this->selectedSortie = DB::table('sortie_poulets')
                                ->join('clients', 'clients.id', 'sortie_poulets.id_client')
                                ->select('sortie_poulets.*', 'clients.nom', 'clients.raison_sociale', 'clients.adresse')
                                ->where('sortie_poulets.id', $idConstat)
                                ->get();

        $this->detailSorties = DetailSortie::where('id_sortie', $idConstat)->get();
    }


    public function render()
    {
        return view('livewire.details-sortie');
    }
}
