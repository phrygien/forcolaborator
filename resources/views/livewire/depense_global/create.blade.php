<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création dépense globale')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Libelle dépense')}}</label>
                        <select wire:model="id_libelle_depense" class="form-control form-control-rounded">
                            <option>Choisir un libelle depense</option>
                            @foreach ($libelleDepenseActifs as $libelledepense)
                                <option value="{{ $libelledepense->id }}">{{ $libelledepense->libelle }}</option>
                            @endforeach
                        </select>
                        @error('id_libelle_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type dépense')}}</label>
                        <select wire:model="id_type_depense" class="form-control form-control-rounded">
                            <option value="">Choisir un type dépense</option>
                            @foreach ($typeDepenseActifs as $typedepense)
                                <option value="{{ $typedepense->id }}">{{ $typedepense->type }}</option>
                            @endforeach
                        </select>
                        @error('id_type_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité')}}</label>
                        <input type="number" wire:model.defer="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total')}}</label>
                        <input type="number" wire:model.defer="montant_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date entrée')}}</label>
                        <input type="date" wire:model="date_entree" class="form-control form-control-rounded">
                        @error('date_entree') 
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
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveDepense()" wire:loading.attr="disabled" wire:target="saveDepense()">
                            <span wire:loading.remove wire:target="saveDepense"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveDepense">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn btn-success btn-rounded mr-3" wire:click.prevent="saveDepense()" wire:loading.attr="disabled" wire:target="saveDepense()">
                            <span wire:loading.remove wire:target="saveDepense"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer et detailler</span>
                            <span wire:loading wire:target="saveDepense">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormDepense()" wire:loading.attr="disabled" wire:target="resetFormDepense()">
                            <span wire:loading.remove wire:target="resresetFormDepenseetFormBatiment"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reset</span>
                            <span wire:loading wire:target="resetFormDepense">
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