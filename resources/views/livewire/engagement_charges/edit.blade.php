<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Modification engagement charge')}}</div>
            @if (session()->has('update_error'))
            <div class="alert alert-danger border-info" role="alert">
                <i class="icon-info1"></i>{{ session('update_error')}}
            </div>
            @endif

            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Depense charges')}}</label>
                        <select wire:model.defer="id_depense" disabled class="form-control form-control-rounded">
                            <option>Choisiser une depense</option>
                            @foreach ($depense_charges as $depensecharge)
                                <option value="{{ $depensecharge->id }}">{{ $depensecharge->nom_depense}}</option>
                            @endforeach
                        </select>
                        @error('id_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="text" wire:model="pu" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Qte')}}</label>
                        <input type="text" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Qte disponible')}}</label>
                        <input type="text" readonly wire:model.defer="qte_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte_disponible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix total')}}</label>
                        <input type="text" readonly wire:model.defer="prix_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('prix_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date engagement')}}</label>
                        <input type="text" readonly wire:model.defer="date_engagement" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('date_engagement') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-12 mt-3">
                        <button class="btn float-right btn-primary btn-rounded" wire:click.prevent="confirmerUpdate()">
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
        <strong class="text-black">{{ __('Modification engagement charge')}} !</strong>
        <p class="text-black">Voulez-vous vraiment confirmer cette modification ?</p>
        <p class="text-center">
            <button class="btn btn-secondary btn-rounded" wire:click="cancelModal()">{{ __('Annuler') }}</button>
            <button class="btn btn-danger btn-rounded" wire:click.prevent="updateEngagement()">{{ __('Valider') }}</button>
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