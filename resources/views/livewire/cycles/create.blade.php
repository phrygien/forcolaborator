<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création cycle')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Description cycle')}}</label>
                        <input type="text" wire:model.defer="description" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('description') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type poulets')}}</label>
                        <select wire:model="id_type_poulet" class="form-control form-control-rounded">
                            <option value="">Choisir un type de poulet</option>
                            @foreach ($typePouletActif as $typepoulet)
                                <option value="{{ $typepoulet->id }}">{{ $typepoulet->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_poulet') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nombre des poulet pour le cycle')}}</label>
                        <input type="number" wire:model.defer="nb_poulet" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nb_poulet') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Site')}}</label>
                        <select wire:model="selectedSite" class="form-control form-control-rounded">
                            <option>Choisir un site pour avoir batiment</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->site }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Batiment')}}</label>
                        <select wire:model="id_batiment" class="form-control form-control-rounded">
                            <option value="">Choisir un batiment</option>
                            @foreach ($batiments as $batiment)
                                <option value="{{ $batiment->id }}">{{ $batiment->nom }}</option>
                            @endforeach
                        </select>
                        @error('id_batiment') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date entrée')}}</label>
                        <input type="date" wire:model.defer="date_entre" class="form-control form-control-rounded">
                        @error('date_entre') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Status cycle')}}</label>
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
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveCycle()" wire:loading.attr="disabled" wire:target="saveCycle()">
                            <span wire:loading.remove wire:target="saveCycle"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveCycle">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormBatiment()" wire:loading.attr="disabled" wire:target="resetFormBatiment()">
                            <span wire:loading.remove wire:target="resetFormBatiment"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reset</span>
                            <span wire:loading wire:target="resetFormBatiment">
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