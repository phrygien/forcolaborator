<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\ConstatPoulet;
use App\Models\TypeSortie;
use Livewire\Component;

class LivSortieConstant extends Component
{
    public $clients;
    public $typesorties;
    public $dernierConstatPoulet = [];

    public $nb, $id_dernier_constat, $id_cycle, $date_constat, $date_action, $nb_disponible;

    public $selectedOption;

    public function mount()
    {
        $this->clients = Client::all();
        $this->typesorties = TypeSortie::where('actif', 1)->get();
        $dernierConstatPoulet = ConstatPoulet::latest()->first();

        //dd($dernierConstatPoulet);
        if ($dernierConstatPoulet) {
            // Assign the retrieved information to the class property
            $this->id_dernier_constat = $dernierConstatPoulet->id;
            // $this->id_cycle = $this->dernierConstatPoulet->id_cycle;
            // $this->date_constat = $this->dernierConstatPoulet->date_constat;
            // $this->date_action = $this->dernierConstatPoulet->date_action;
            // $this->nb_disponible = $this->dernierConstatPoulet->nb_disponible;
        }
    }

    public function render()
    {
        return view('livewire.liv-sortie-constant');
    }
}
