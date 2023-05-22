<?php

namespace App\Http\Livewire;

use App\Models\ConstatOeuf;
use Livewire\Component;

class LivSortieOeuf2 extends Component
{
    public $constats;
    public $selectedConstats = [];
    public $quantities = [];
    public $inputs = [];
    public $dynamicInputs = [];

    public function mount()
    {
        $this->constats = ConstatOeuf::all();
    }

    public function render()
    {
        return view('livewire.liv-sortie-oeuf2');
    }

    public function addDynamicInput()
    {
        $this->dynamicInputs[] = '';
    }

    public function removeDynamicInput($index)
    {
        unset($this->dynamicInputs[$index]);
        $this->dynamicInputs = array_values($this->dynamicInputs);
    }
}
