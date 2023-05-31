<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création constat poulet')}}</div>
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

                    {{-- <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type poulet')}}</label>
                        <select wire:model.defer="id_type_poulet" class="form-control form-control-rounded">
                            <option value="">Choisir un type de poulet</option>
                            @foreach ($typePouletActifs as $typepoulet)
                                <option value="{{ $typepoulet->id }}">{{ $typepoulet->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_poulet') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div> --}}

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nombre poulets')}}</label>
                        <input type="number" wire:model.defer="nb" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nb') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date constat')}}</label>
                        <input type="date" wire:model.defer="date_constat" class="form-control form-control-rounded">
                        @error('date_constat') 
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
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveConstat()" wire:loading.attr="disabled" wire:target="saveConstat()">
                            <span wire:loading.remove wire:target="saveConstat"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveConstat">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormConstat()" wire:loading.attr="disabled" wire:target="resetFormConstat()">
                            <span wire:loading.remove wire:target="resetFormConstat"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reset</span>
                            <span wire:loading wire:target="resetFormConstat">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                reinitialisation...
                            </span>
                        </button>
                        <button class="btn btn-secondary btn-rounded" wire:click.prevent="cancelCreate()" wire:loading.attr="disabled" wire:target="cancelCreate()">
                            <span wire:loading.remove wire:target="cancelCreate"><i class="nav-icon i-Arrow-Back font-weight-bold"></i> Retour</span>
                            <span wire:loading wire:target="cancelCreate">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                annulation...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>