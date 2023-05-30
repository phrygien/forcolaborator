<?php

namespace App\Http\Livewire;

use App\Models\ConstatOeuf;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DonneejourConstantOeuf extends Component
{
    public $selectedDate;
    public $totalDonneesJournalieres = [];
    public function mount()
    {
        $this->selectedDate = today()->toDateString();
        $this->chargerDonneesChart();
    }

    public function render()
    {
        return view('livewire.donneejour-constant-oeuf');
    }

    public function chargerDonneesChart()
    {
        $this->totalDonneesJournalieres = ConstatOeuf::join('type_oeufs', 'constat_oeufs.id_type_oeuf', '=', 'type_oeufs.id')
            ->whereDate('date_entree', $this->selectedDate) // Remplacez 'votre_champ_de_date' par le nom correct de votre champ de date
            ->groupBy('id_type_oeuf', 'type_oeufs.type')
            ->selectRaw('id_type_oeuf, type_oeufs.type as nom_type_oeuf, SUM(nb) as total')
            ->get();

        $this->emit('chartUpdated', $this->totalDonneesJournalieres->toArray());
    }

    public function updatedSelectedDate($value)
    {
        $this->selectedDate = $value;
        $this->chargerDonneesChart();
    }
}
