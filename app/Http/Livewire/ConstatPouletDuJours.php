<?php

namespace App\Http\Livewire;

use App\Models\ConstatPoulet;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ConstatPouletDuJours extends Component
{
    public function render()
    {
        // $constatsDuJour = ConstatPoulet::select('cycles.description', DB::raw('count(*) as total_constats'))
        //     ->join('cycles', 'constat_poulets.id_cycle', '=', 'cycles.id')
        //     ->whereDate('constat_poulets.date_constat', '=', now()->format('Y-m-d'))
        //     ->groupBy('cycles.description')
        //     ->get();

        $constatsDuJour = ConstatPoulet::select(
            'cycles.description','type_poulets.type',
            DB::raw('count(*) as total_constats'),
            DB::raw('sum(nb) as total_nb')
        )
            ->join('cycles', 'constat_poulets.id_cycle', '=', 'cycles.id')
            ->join('type_poulets', 'constat_poulets.id_type_poulet', '=', 'type_poulets.id')
            ->whereDate('constat_poulets.date_constat', '=', now()->format('Y-m-d'))
            ->groupBy('cycles.description','type_poulets.type')
            ->get();


        return view('livewire.constat-poulet-du-jours',[
            'constatsDuJour' => $constatsDuJour
        ]);
    }
}
