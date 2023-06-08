<div class="col-md-12">
    <div class="card mb-4" style="border-top: solid 3px rgb(202, 20, 20);">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Retour sortie d\'oeuf')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type oeuf')}}</label>
                        <select disabled wire:model="id_type_oeuf" class="form-control form-control-rounded">
                            <option value="">Choisir un type d'oeuf</option>
                            @foreach ($typeOeufActifs as $typeoeuf)
                                <option value="{{ $typeoeuf->id }}">{{ $typeoeuf->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_oeuf') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type sortie')}}</label>
                        <select disabled wire:model="id_type_sortie" class="form-control form-control-rounded">
                            <option>Choisir un type sortie</option>
                            @foreach ($typeSortieActifs as $typesortie)
                                <option value="{{ $typesortie->id }}">{{ $typesortie->libelle }}</option>
                            @endforeach
                        </select>
                        @error('id_type_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité')}}</label>
                        <input disabled type="number" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input disabled type="number" wire:model="pu" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total')}}</label>
                        <input disabled type="number" disabled wire:model="montant" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date sortie')}}</label>
                        <input disabled type="date" wire:model="date_sortie" disabled class="disable form-control form-control-rounded">
                        @error('date_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Client')}}</label>
                        <select disabled wire:model="id_client" class="form-control form-control-rounded">
                            <option value="">Choisir un client</option>
                            @foreach ($clientActifs as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                            @endforeach
                        </select>
                        @error('id_client') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantite retour')}}</label>
                        <input type="number" wire:model="qte_retour" class="disable form-control form-control-rounded" style="border-bottom: solid 3px rgb(177, 139, 16);">
                        @error('qte_retour') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                        @if (session()->has('retour_impossible'))
                        <div class="alert alert-danger border-info" role="alert">
                            <i class="icon-info1"></i>{{ session('retour_impossible')}}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-raised mb-3 btn-raised-primary btn-rounded" wire:click.prevent="afficherSortie()"><i class="nav-icon i-Arrow-Left-in-Circle"></i> Annuler retour</button>

                        <button {{ $disableBtnValider }} class="btn btn-raised btn-raised-warning float-right btn-rounded mr-3" wire:click.prevent="confirmerRetour()">
                            <i class="nav-icon i-Yes font-weight-bold"></i> Valider retour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if($detailSortie)
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card text-left" style="border-top: solid 3px purple;">

        <div class="card-body">
            <h4 class="card-title mb-3"> Details de la sortie poulet</h4>
            <div class="table-responsive">
                <table class="table ">
                    <thead class="">

                        <tr>
                            <th scope="col">ID Sortie</th>
                            <th scope="col">ID Constat</th>
                            <th scope="col">ID Produit</th>

                            <th scope="col">Qte details sortie</th>
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Montat totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailSortie as $detail)
                        <tr>
                            <td>{{ $detail->id }}</td>
                            <td>{{ $detail->id_constat }}</td>
                            <td>{{ $detail->id_produit }}</td>
                            <td>{{ $detail->qte }}</td>
                            <td>{{ $detail->valeur }}</td>
                            <td>{{ $detail->pu }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
@endif

@if($confirmRetour)
<!-- CSS -->
<style>
    .overlay {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    }
    
    .centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }
</style>

<!-- HTML -->
<div class="overlay">
    <div class="centered">
    <div class="alert alert-warning text-center">
        <strong class="text-black">{{ __('Retour sortie poulet')}} !</strong>
        <p class="text-black">Pouvez-vous confirmer retour sortie poulet ?</p>
        <p class="text-center">
            <button class="btn btn-secondary mr-3 btn-rounded" wire:click="cancelRetour()">{{ __('Fermer') }}</button>
            <button class="btn btn-danger ml-2 btn-rounded" wire:click.prevent="saveRetour()">{{ __('Confirmer') }}</button>
        </p>
    </div>
    </div>
</div>

<script>
    // Désactiver le clic sur le reste de la page
    document.querySelector('.overlay').addEventListener('click', function(e) {
    e.stopPropagation();
    });
</script>
@endif