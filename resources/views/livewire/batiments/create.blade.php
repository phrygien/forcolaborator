<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création batiment')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nom batiment')}}</label>
                        <input type="text" wire:model.defer="nom" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nom') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Site')}}</label>
                        <select wire:model.defer="id_site" class="form-control form-control-rounded">
                            <option>Select site</option>
                            @foreach ($sitesActif as $site)
                            <option value="{{ $site->id }}" >{{ $site->site }}</option>
                            @endforeach
                        </select>
                        @error('id_site') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Status')}}</label>
                        <select wire:model="actif" class="form-control form-control-rounded">
                            <option>Select status</option>
                            <option value="1" selected>Actif</option>
                            <option value="2">Inactif</option>
                        </select>
                        @error('actif') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveBatiment()" wire:loading.attr="disabled" wire:target="saveBatiment()">
                            <span wire:loading.remove wire:target="saveBatiment"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveBatiment">
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