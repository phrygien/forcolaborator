<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création prix oeuf')}}</div>
            <form>
                <div class="row">

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type poulets')}}</label>
                        <select wire:model="id_type_oeuf" class="form-control form-control-rounded">
                            <option value="">Choisir un type d'oeuf</option>
                            @foreach ($typeOeufActif as $typeoeuf)
                                <option value="{{ $typeoeuf->id }}">{{ $typeoeuf->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_poulet') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="number" wire:model.defer="pu" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date application')}}</label>
                        <input type="date" wire:model.defer="date_application" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('date_application') 
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
                            <option value="2">Inactif</option>
                        </select>
                        @error('actif') 
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
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="savePrix()" wire:loading.attr="disabled" wire:target="savePrix()">
                            <span wire:loading.remove wire:target="savePrix"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="savePrix">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn btn-danger btn-rounded mr-3" wire:click.prevent="resetInput()" wire:loading.attr="disabled" wire:target="resetInput()">
                            <span wire:loading.remove wire:target="resetInput"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reset</span>
                            <span wire:loading wire:target="resetInput">
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