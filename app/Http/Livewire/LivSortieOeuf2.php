<?php

namespace App\Http\Livewire;

use App\Models\ConstatOeuf;
use Livewire\Component;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class LivSortieOeuf2 extends Component
{
    public $constats;
    public $selectedConstats = [];
    public $quantities = [];
    public $inputs = [];
    public $dynamicInputs = [];
    public $produitsDisponibles = [];

    public $sortie = [
        'nom_client' => '',
        'adresse' => '',
        'date_commande' => '',
        'produits' => [],
    ];

    public function mount()
    {
        //$this->constats = ConstatOeuf::all();
        $this->produitsDisponibles = ConstatOeuf::whereNotIn('id', $this->getProduitsSelectionnes())->get();
    }

    private function getProduitsSelectionnes()
    {
        return collect($this->sortie['produits'])->pluck('id_constat')->filter()->all();
    }

    public function addProduit()
    {
        $this->sortie['produits'][] = [
            'id_constat' => null,
            'qte' => 0,
            'montant_total' => 0,
        ];
    }

    public function removeProduit($index)
    {
        unset($this->sortie['produits'][$index]);
        $this->sortie['produits'] = array_values($this->sortie['produits']);
    }

    public function updatedSortieProduits()
    {
        $this->produitsDisponibles = ConstatOeuf::whereNotIn('id', $this->getProduitsSelectionnes())->get();

        // foreach ($this->sortie['produits'] as $index => $produit) {
        //     if (!empty($produit['id_constat']) && $produit['qte'] > 0) {
        //         $constats = ConstatOeuf::find($produit['id_constat']);
        //         $montantTotal = $constats->prix_unitaire * $produit['qte'];
        //         $this->sortie['produits'][$index]['montant_total'] = $montantTotal;
        //     } else {
        //         $this->sortie['produits'][$index]['montant_total'] = 0;
        //     }
        // }
    }

    public function render()
    {
        return view('livewire.liv-sortie-oeuf2');
    }

    // public function saveCommande()
    // {
    //     // Valider les données du formulaire ici

    //     // Enregistrer la commande dans la table "commandes"
    //     $commandeId = \App\Models\Commande::create([
    //         'nom_client' => $this->commande['nom_client'],
    //         'adresse' => $this->commande['adresse'],
    //         'date_commande' => $this->commande['date_commande'],
    //     ])->id;

    //     // Enregistrer les détails de la commande dans la table "details_commande"
    //     foreach ($this->commande['produits'] as $produit) {
    //         \App\Models\DetailsCommande::create([
    //             'id_commande' => $commandeId,
    //             'id_produit' => $produit['id_produit'],
    //             'qte' => $produit['qte'],
    //             'montant_total' => $produit['montant_total'],
    //         ]);
    //     }

    //     // Réinitialiser le formulaire
    //     $this->commande = [
    //         'nom_client' => '',
    //         'adresse' => '',
    //         'date_commande' => '',
    //         'produits' => [],
    //     ];

    //     // Afficher un message de succès ou effectuer une autre action après l'enregistrement
    //     session()->flash('success', 'La commande a été enregistrée avec succès.');
    // }

}
