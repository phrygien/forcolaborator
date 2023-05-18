<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création site')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nom site')}}</label>
                        <input type="text" wire:model.defer="site" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('site') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="lastName2">{{ __('Adresse site')}}</label>
                        <input type="text" wire:model.defer="adresse" class="form-control form-control-rounded" id="lastName2" placeholder="">
                        @error('adresse') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Status')}}</label>
                        <select wire:model.defer="actif" class="form-control form-control-rounded">
                            <option>Select status</option>
                            <option value="1">Actif</option>
                            <option value="0">Inactif</option>
                        </select>
                        @error('actif') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
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
        <strong class="text-black">{{ __('Modification site')}} !</strong>
        <p class="text-black">Vous etes sure de valider la modification</p>
        <p class="text-center">
            <button class="btn btn-secondary btn-rounded" wire:click="cancelModal()">{{ __('Annuler') }}</button>
            <button class="btn btn-danger btn-rounded" wire:click.prevent="update()" wire:loading.attr="disabled" wire:target="update">
                <span wire:loading.remove wire:target="update">{{ __('Valider') }}</span>
                <span wire:loading wire:target="update">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    validation...
                </span>
            </button>
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