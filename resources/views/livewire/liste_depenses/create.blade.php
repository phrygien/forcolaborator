<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création liste depense')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Unité')}}</label>
                        <select wire:model.defer="id_unite" class="form-control form-control-rounded">
                            <option>Choisiser ununité de dépense</option>
                            @foreach ($unites as $unite)
                                <option value="{{ $unite->id }}">{{ $unite->unite}}</option>
                            @endforeach
                        </select>
                        @error('id_unite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nom dépense')}}</label>
                        <input type="text" wire:model.defer="nom_depense" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nom_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Cycle concernée')}}</label>
                        <select wire:model.defer="cycle_concerne" class="form-control form-control-rounded">
                            <option>Selectionner un cycle concerne</option>
                            <option value="1">Poulet de chaire</option>
                            <option value="2">Poule pondeuse</option>
                            <option value="3">Dépense commune</option>
                        </select>
                        @error('cycle_concerne') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Affectation')}}</label>
                        <select wire:model.defer="affectation" class="form-control form-control-rounded">
                            <option>Selectionner une affectation</option>
                            <option value="1">Dépense commune de ferme</option>
                            <option value="2">Dépense commune de site</option>
                            <option value="3">Dépense specifique de cycle</option>
                        </select>
                        @error('affectation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type dépense')}}</label>
                        <select wire:model.defer="type" class="form-control form-control-rounded">
                            <option>Selectionner un type depense</option>
                            <option value="1">Charges</option>
                            <option value="2">Immobilisations</option>
                        </select>
                        @error('type') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nombre d\'année d\'amortissement')}}</label>
                        <input type="text" wire:model.defer="nb_annee_amortissement" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nb_annee_amortissement') 
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

                    <div class="col-md-12">
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveListe()" wire:loading.attr="disabled" wire:target="saveListe()">
                            <span wire:loading.remove wire:target="saveListe"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveListe">
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