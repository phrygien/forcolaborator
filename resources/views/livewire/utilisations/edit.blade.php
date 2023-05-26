<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Modification dépense globale')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type depense')}}</label>
                        <select wire:model="selectedType" class="form-control form-control-rounded">
                            <option value="">Choisir un type de dépense</option>
                            @foreach ($typeDepenseActif as $typedepense)
                                <option value="{{ $typedepense->id }}">{{ $typedepense->type }}</option>
                            @endforeach
                        </select>
                        @error('selectedSite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Depense brute (depense globale)')}}</label>
                        <select wire:model="id_depense_brut" class="form-control form-control-rounded">
                            <option value="">Choisir un depense brute</option>
                            @foreach ($depenses as $depense)
                                <option value="{{ $depense->id }}">Date entrée: {{ $depense->date_entree}} - Montant brut : {{ $depense->montant_total }} - Qte brut : {{ $depense->qte }}</option>
                            @endforeach
                        </select>
                        @error('id_depense_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Utilisation cible')}}</label>
                        <select wire:model.defer="utilisation_cible" class="form-control form-control-rounded">
                            @if($choix_cycle)
                                <option>Selectioner un cycle</option>
                                @foreach($cycles as $cycle)
                                <option value="{{ $cycle->description }}">{{ $cycle->description }}</option>
                                @endforeach
                            @endif

                            @if($choix_site)
                            <option>Selectioner un site</option>
                            @foreach($sites as $site)
                            <option value="{{ $site->site }}">{{ $site->site }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('utilisation_cible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant brut')}}</label>
                        <input type="number" wire:model="montant_brut" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité brut')}}</label>
                        <input type="number" wire:model="qte_brut" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité utlisation')}}</label>
                        <input type="number" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                        @if (session()->has('error'))
                        <div class="alert alert-warning border-info" role="alert">
                            {{ session('error')}}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total utilisation')}}</label>
                        <input type="number" wire:model="montant" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date utilisation')}}</label>
                        <input type="date" wire:model="date_utilisation" class="form-control form-control-rounded">
                        @error('date_utilisation') 
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