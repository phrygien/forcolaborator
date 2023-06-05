<?php

namespace App\Http\Livewire;

use App\Models\DetailSortie;
use App\Models\SortiePoulet;
use Livewire\Component;

class DetailsSortie extends Component
{

    public $selectedSortie;
    public $detailSorties;

    public function mount($idConstat)
    {
        $this->selectedSortie = SortiePoulet::where('id', $idConstat)->get();
        $this->detailSorties = DetailSortie::where('id_sortie', $idConstat)->get();
    }


    public function render()
    {
        return view('livewire.details-sortie');
    }
}
