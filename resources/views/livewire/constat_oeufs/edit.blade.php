<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Modification constat d\'oeuf')}}</div>
            <div class="row">

                <div class="col-md-6 form-group mb-3">
                    <label for="picker1">{{ __('Cycle')}}</label>
                    <select disabled wire:model.defer="id_cycle" class="form-control form-control-rounded">
                        <option>Choisir un cycle</option>
                        @foreach ($cycleActifs as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->description }}</option>
                        @endforeach
                    </select>
                    @error('id_cycle') 
                    <div class="alert alert-danger" role="alert">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                
                <div class="col-md-6 form-group mb-3">
                    <label for="picker1">{{ __('Type oeuf')}}</label>
                    <select wire:model.defer="id_type_oeuf" class="form-control form-control-rounded">
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
                    <label for="firstName2">{{ __("Nombre d'oeuf actuele")}}</label>
                    <input type="number" readonly wire:model="nb" class="form-control form-control-rounded" id="firstName2" placeholder="">
                    @error('nb') 
                    <div class="alert alert-danger" role="alert">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="firstName2">{{ __('Nombre disponible actuele')}}</label>
                    <input type="number" readonly wire:model="nb_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                    @error('nb_disponible') 
                    <div class="alert alert-danger" role="alert">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3">
                    <label for="firstName2">{{ __('Date entrée')}}</label>
                    <input type="date" wire:model.defer="date_entree" class="form-control form-control-rounded">
                    @error('date_entree') 
                    <div class="alert alert-danger" role="alert">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6 form-group mb-3" hidden>
                    <label for="firstName2">{{ __('Date action')}}</label>
                    <input type="hidden" wire:model.defer="date_action" class="form-control form-control-rounded">
                </div>

                <div class="col-md-6 form-group mb-3" hidden>
                    <label for="firstName2">{{ __('Utilisateur ID')}}</label>
                    <input type="text" wire:model.defer="id_utilisateur" class="form-control form-control-rounded">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4" style="border-bottom: solid 4px rgb(150, 25, 161);">
        <div class="card-body">
            <div class="card-title mb-3">{{ __("Nouvelle nombre d'oufs")}}</div>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="firstName2">{{ __('Nouvelle valeur des nombre oeuf')}}</label>
                    <input type="number"  wire:model="new_nb" class="form-control form-control-rounded" id="firstName2" placeholder="">
                    <small class="text-info"><b>{{ __('Entrer la nouvelle valeur si vous-voulez modifier le nombre actuele')}}</b></small>
                    @error('new_nb') 
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
                    <label for="firstName2">{{ __('Nouvelle nombre disponible')}}</label>
                    <input type="number" readonly wire:model="new_nb_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                    @error('new_nb_disponible') 
                    <div class="alert alert-danger" role="alert">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
            </div>            
        </div>

        <div class="m-3 col-md-12 m-2">
            <button class="float-right btn btn-primary btn-rounded mr-3" wire:click.prevent="confirmerUpdate()">
                <i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer
            </button>
            <button class="btn btn-secondary btn-rounded" wire:click.prevent="cancelUpdate()">
                <i class="nav-icon i-Arrow-Back font-weight-bold"></i> Retour
            </button>
        </div>
    </div>
    {{-- <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Modification constat oeuf')}}</div>
            <form>
                <div class="row">

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Cycle')}}</label>
                        <select wire:model.defer="id_cycle" class="form-control form-control-rounded">
                            <option>Choisir un cycle</option>
                            @foreach ($cycleActifs as $cycle)
                                <option value="{{ $cycle->id }}">{{ $cycle->description }}</option>
                            @endforeach
                        </select>
                        @error('id_cycle') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type oeuf')}}</label>
                        <select wire:model.defer="id_type_oeuf" class="form-control form-control-rounded">
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
                        <label for="firstName2">{{ __("Nombre d'oeuf actuele")}}</label>
                        <input type="number" readonly wire:model="nb" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nb') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nombre disponible actuele')}}</label>
                        <input type="number" readonly wire:model="nb_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nb_disponible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nouvelle valeur des nombre oeuf')}}</label>
                        <input type="number"  wire:model="new_nb" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        <small class="text-info"><b>{{ __('Entrer la nouvelle valeur si vous-voulez modifier le nombre actuele')}}</b></small>
                        @error('new_nb') 
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
                        <label for="firstName2">{{ __('Nouvelle nombre disponible')}}</label>
                        <input type="number" readonly wire:model="new_nb_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('new_nb_disponible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date entrée')}}</label>
                        <input type="date" wire:model.defer="date_entree" class="form-control form-control-rounded">
                        @error('date_entree') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3" hidden>
                        <label for="firstName2">{{ __('Date action')}}</label>
                        <input type="hidden" wire:model.defer="date_action" class="form-control form-control-rounded">
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
    </div> --}}
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
        <strong class="text-black">{{ __('Modification constat oeuf')}} !</strong>
        <p class="text-black">Pouvez-vous confirmer cette modification ?</p>
        <p class="text-center">
            <button class="btn btn-secondary btn-rounded" wire:click="cancelModal()">{{ __('Annuler') }}</button>
            <button class="btn btn-danger btn-rounded" wire:click.prevent="updateConstat()">{{ __('Confirmer') }}</button>
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