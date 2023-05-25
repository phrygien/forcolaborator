<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Modification dépense globale')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Libelle dépense')}}</label>
                        <select wire:model="id_libelle_depense" class="form-control form-control-rounded">
                            <option>Choisir un libelle depense</option>
                            @foreach ($libelleDepenseActifs as $libelledepense)
                                <option value="{{ $libelledepense->id }}">{{ $libelledepense->libelle }}</option>
                            @endforeach
                        </select>
                        @error('id_libelle_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type dépense')}}</label>
                        <select wire:model="id_type_depense" class="form-control form-control-rounded">
                            <option value="">Choisir un type dépense</option>
                            @foreach ($typeDepenseActifs as $typedepense)
                                <option value="{{ $typedepense->id }}">{{ $typedepense->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité')}}</label>
                        <input type="number" wire:model.defer="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total')}}</label>
                        <input type="number" wire:model.defer="montant_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date entrée')}}</label>
                        <input type="date" wire:model="date_entree" class="form-control form-control-rounded">
                        @error('date_entree') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3" hidden>
                        <label for="firstName2">{{ __('Utilisateur ID')}}</label>
                        <input type="text" wire:model.defer="id_utilisateur" class="form-control form-control-rounded">
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="confirmerUpdate()">
                            <i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer
                        </button>
                        <button class="btn btn-secondary btn-rounded" wire:click.prevent="cancelUpdate()">
                            <i class="nav-icon i-Arrow-Back font-weight-bold"></i> Retour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if($confirmUpdate)
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
        <strong class="text-black">{{ __('Modification depense globale')}} !</strong>
        <p class="text-black">Pouvez-vous confirmer cette modification ?</p>
        <p class="text-center">
            <button class="btn btn-secondary btn-rounded" wire:click="cancelModal()">{{ __('Annuler') }}</button>
            <button class="btn btn-danger btn-rounded" wire:click.prevent="updateDepense()">{{ __('Confirmer') }}</button>
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