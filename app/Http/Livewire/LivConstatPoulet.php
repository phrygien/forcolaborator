<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\ConstatOeuf;
use App\Models\ConstatPoulet;
use App\Models\Cycle;
use App\Models\TypeOeuf;
use App\Models\TypePoulet;
use App\Models\TypeSortie;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class LivConstatPoulet extends Component
{
    use WithPagination;
    public $afficherListe = true;

    public $createConstat = false, $editConstat= false;

    public $constat_id, $nb, $new_nb, $nb_disponible, $new_nb_disponible, $id_cycle, $date_constat, $date_action, $id_utilisateur;

    //pour le sortie du constat
    public $qte_sortie, $id_dernier_constat, $id_cycle_sortie, $date_constat_sortie, $nb_disponible_constat, $prix_unitaire_sortie, $valeur;
    public $montant, $poids_total, $prix_unite;

    public $confirmUpdate;
    public $typePouletActifs;
    public $cycleActifs;

    public $recordToDelete;
    public $isLoading;
    public $creatBtn = true;
    protected $paginationTheme = 'bootstrap';
    public $notification;

    public $data = [];
    public $labels = [];
    public $selectedDate;
    public $selectedOption;
    public $clients;
    public $typesorties;
    public $date_sortie;

    public $btn_disabled = '';

    public $createSortieConstant = false;

    public $dernierConstatPoulet;

    public function mount()
    {
        $this->date_action = date('Y-m-d');
        $this->date_constat = date('Y-m-d');
        $this->date_sortie = date('Y-m-d');
        $this->typePouletActifs = TypePoulet::where('actif', 1)->get();
        $this->cycleActifs = Cycle::where('actif', 1)->get();
        $this->id_utilisateur = Auth::user()->id;

        $this->clients = Client::all();
        $this->typesorties = TypeSortie::where('actif', 1)->get();
        $this->dernierConstatPoulet = ConstatPoulet::latest()->first();
        if ($this->dernierConstatPoulet) {
            // Assign the retrieved information to the class property
            $this->id_dernier_constat = $this->dernierConstatPoulet->id;
            $this->id_cycle_sortie = $this->dernierConstatPoulet->id_cycle;
            $this->date_constat_sortie = $this->dernierConstatPoulet->date_constat;
            //$this->date_action = $this->dernierConstatPoulet->date_action;
            $this->nb_disponible_constat = $this->dernierConstatPoulet->nb_disponible;
        }
    }

    public function updatedNewNb()
    {
        $this->calculeNewDisponible();
    }

    public function calculeNewDisponible()
    {
        if(is_numeric($this->new_nb)){
            if($this->nb < $this->new_nb)
            {
                if (is_numeric($this->new_nb)) {
                    $this->new_nb_disponible = $this->nb_disponible +($this->new_nb - $this->nb);
                }else{
                    $this->new_nb_disponible= '';
                }
            }elseif($this->nb >= $this->new_nb)
            {   
                if($this->nb - $this->new_nb > $this->nb_disponible){
                    session()->flash('error', 'operation impossible');
                }elseif($this->nb - $this->new_nb <= $this->nb_disponible){
                    $this->new_nb_disponible = $this->nb_disponible - ($this->nb - $this->new_nb);
                }
            }
        }else{
            $this->new_nb_disponible = '';
        }

    }

    public function render()
    {
        $constats = DB::table('constat_poulets')
            ->join('cycles', 'cycles.id', 'constat_poulets.id_cycle')
            ->join('type_poulets', 'type_poulets.id', 'cycles.id_type_poulet')
            ->join('users', 'users.id', 'constat_poulets.id_utilisateur')
            ->select('constat_poulets.*', 'type_poulets.type', 'cycles.description', 'users.name')
            ->paginate(10);

        return view('livewire.liv-constat-poulet', [
            'constats' => $constats
        ]);
    }

    public function formConstat()
    {
        $this->isLoading = true;
        $this->createConstat = true;
        $this->afficherListe = false;
        $this->isLoading = false;
        $this->creatBtn = false;
    }

    /*
    * enregistrer sortie du current constat
    */
    public function createSortieConstant()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable'
        ]);

        try{
            $data['nb_disponible'] = $this->nb;
            ConstatPoulet::create($data);
            //update stock cyle selected
            // $cycleSelected = Cycle::find($this->id_cycle);
            // $stockActuale = $cycleSelected->nb_poulet;
            // $cycleSelected->update([
            //     'nb_poulet' => ($stockActuale + $this->nb),
            // ]);
    
            // $cycleSelected->save();
            
            $this->resetFormConstat();
            $this->resetValidation();
            $this->isLoading = false;
            $this->notification = true;
            session()->flash('message', 'Constat poulet bien enregistré!');
            $this->createSortieConstant = true;
            $this->createConstat = false;
            $this->dernierConstatPoulet = ConstatPoulet::latest()->first();
            if ($this->dernierConstatPoulet) {
                // Assign the retrieved information to the class property
                $this->id_dernier_constat = $this->dernierConstatPoulet->id;
                $this->id_cycle_sortie = $this->dernierConstatPoulet->id_cycle;
                $this->date_constat_sortie = $this->dernierConstatPoulet->date_constat;
                //$this->date_action = $this->dernierConstatPoulet->date_action;
                $this->nb_disponible_constat = $this->dernierConstatPoulet->nb_disponible;
            }
            //return redirect()->to('gestion_entree/constat_poulet');
            //DB::commit();
    
            }catch(\Exception $e){
                //return $e->getMessage();
                session()->flash('message', $e->getMessage());
            }
    }
    /*
    * fin enregistrement sortie current constat
    */
    public function resetFormConstat()
    {
        $this->nb = '';
        $this->nb_disponible = '';
        $this->id_cycle = '';
        $this->new_nb = '';
        $this->new_nb_disponible = '';
        $this->date_constat = date('Y-m-d');
        $this->creatBtn = false;
        $this->resetValidation();
    }

    public function saveConstat()
    {
        $this->isLoading = true;
        $data = $this->validate([
            'nb' => 'required|integer',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'id_utilisateur' => 'nullable',
            'date_action' => 'nullable'
        ]);

        //DB::beginTransaction();
        // $cycleSelected = Cycle::find($this->id_cycle);
        // $stockActuale = $cycleSelected->nb_poulet;

        try{
        $data['nb_disponible'] = $this->nb;
        ConstatPoulet::create($data);
        //update stock cyle selected
        // $cycleSelected = Cycle::find($this->id_cycle);
        // $stockActuale = $cycleSelected->nb_poulet;
        // $cycleSelected->update([
        //     'nb_poulet' => ($stockActuale + $this->nb),
        // ]);

        // $cycleSelected->save();
        
        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->notification = true;
        session()->flash('message', 'Constat poulet bien enregistré!');
        //return redirect()->to('gestion_entree/constat_poulet');
        //DB::commit();

        }catch(\Exception $e){
            //return $e->getMessage();
            session()->flash('message', $e->getMessage());
        }

    }

    public function cancelCreate()
    {
        $this->isLoading = true;
        $this->createConstat = false;
        $this->afficherListe = true;
        $this->resetFormConstat();
        $this->resetValidation();
        $this->isLoading = false;
        $this->creatBtn = true;
    }

    public function editConstat($id)
    {
        $constat = ConstatPoulet::findOrFail($id);
        $this->constat_id = $id;
        $this->nb = $constat->nb;
        $this->new_nb = '';
        $this->nb_disponible = $constat->nb_disponible;
        $this->id_cycle = $constat->id_cycle;
        $this->date_constat = $constat->date_constat;
        $this->id_utilisateur = $constat->id_utilisateur;

        $this->editConstat = true;
        $this->createConstat = false;
        $this->creatBtn = false;
        $this->afficherListe = false;
    }

    public function confirmerUpdate()
    {
        $this->confirmUpdate = true;
    }

    public function updateConstat()
    {
        $this->validate([
            'nb' => 'required',
            'id_cycle' => 'required|integer',
            'date_constat' => 'required|date',
            'date_action' => 'nullable',
            'id_utilisateur' => 'nullable',
            'new_nb' => 'nullable',
        ]);

        try{
            
            $constat = ConstatPoulet::findOrFail($this->constat_id);
            //verifier si le nombre de poulet sont modifier
            if($this->new_nb !=null || $this->new_nb_disponible !=null){
                $constat->update([
                    'nb' => $this->new_nb,
                    'id_cycle' => $this->id_cycle,
                    'date_constat' => $this->date_constat,
                    'date_action' => $this->date_action,
                    'nb_disponible' => $this->new_nb_disponible,
                    'id_utilisateur' => $this->id_utilisateur,
                ]);
            }else{
                $constat->update([
                    'nb' => $this->nb,
                    'id_cycle' => $this->id_cycle,
                    'date_constat' => $this->date_constat,
                    'date_action' => $this->date_action,
                    'nb_disponible' => $this->nb_disponible,
                    'id_utilisateur' => $this->id_utilisateur,
                ]); 
            }
            $this->editConstat = false;
            $this->resetFormConstat();
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
        $this->editConstat = true;
    }


    public function cancelUpdate()
    {
        $this->confirmUpdate = false;
        $this->editConstat = false;
        $this->resetFormConstat();
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
        $this->recordToDelete = ConstatPoulet::findOrFail($id);
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

    /*
    * debut sortie constat
    */

    public function updatedQteSortie()
    {
        $this->verifierDisponibilite();
        $this->calculateMontant();
    }

    public function updatedPrixUnitaireSortie()
    {
        $this->calculateMontant();
    }

    public function verifierDisponibilite()
    {
        if($this->qte_sortie > $this->nb_disponible_constat)
        {
            session()->flash('error', 'La Qte à sortir ne doit pas >  aux nombre disponible'.' / '. 'Qte disponible du constat est : '.$this->nb_disponible_constat);
            $this->btn_disabled = 'disabled';
        }else{
            $this->btn_disabled = '';
        }
    }

    public function calculateMontant()
    {
        if (is_numeric($this->qte_sortie) && is_numeric($this->prix_unitaire_sortie)) {
            $this->valeur = $this->qte_sortie * $this->prix_unitaire_sortie;
        }else{
            $this->valeur = 0;
        }
    }

    public function updatedPrixUnite($value)
    {
        if(is_numeric($this->poids_total) && is_numeric($this->prix_unite))
        {
            $this->montant = $this->poids_total * $this->prix_unite;
        }else
        {
            $this->montant = '';
        }
    }

    public function updatedPoidsTotal($value)
    {
        if (is_numeric($value) && is_numeric($this->prix_unite) && $value != 0) {
            $this->montant = $this->prix_unite * $value;
        }
    }

    // public function saveSortieAndDetail()
    // {

    // }
    /*
    * fin sortie constat
    */
}
