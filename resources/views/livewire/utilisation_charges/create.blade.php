<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création utilisation charge')}}</div>
            <form>
                <div class="row">

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type d\'affectation depense')}}</label>
                        <select wire:model="affectation" class="form-control form-control-rounded">
                            <option value="">Choisir un affectation</option>
                                <option value="2">Depense commune par site</option>
                                <option value="3">Depense commune par cycle</option>
                        </select>
                        @error('affectation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Depense charges')}}</label>
                        <select wire:model="id_depense" class="form-control form-control-rounded">
                            <option value="">Choisir un depense charge</option>
                                @foreach ($depenses as $depense)
                                    <option value="{{ $depense->id }}">{{ $depense->nom_depense}}</option>
                                @endforeach
                        </select>
                        @error('id_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Cycles')}}</label>
                        <select wire:model="id_cycle" class="form-control form-control-rounded">
                            <option value="">Choisir un cycle</option>
                                @foreach ($cycles as $cycle)
                                    <option value="{{ $cycle->id }}">{{ $cycle->description}}</option>
                                @endforeach
                        </select>
                        @error('id_cycle') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Site')}}</label>
                        <select wire:model="id_site" class="form-control form-control-rounded">
                            <option value="">Choisir un site</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->site}}</option>
                                @endforeach
                        </select>
                        @error('id_site') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Qte')}}</label>
                        <input type="number" wire:model.defer="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date utilisation')}}</label>
                        <input type="date" wire:model.defer="date_utilisation" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('date_utilisation') 
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
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveUtilisation()" wire:loading.attr="disabled" wire:target="saveUtilisation()">
                            <span wire:loading.remove wire:target="saveUtilisation"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveUtilisation">
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