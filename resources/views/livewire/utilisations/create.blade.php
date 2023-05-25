<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création utilisation dépense')}}</div>
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
                        <input type="date" wire:model="date_utilisation" disabled class="disable form-control form-control-rounded">
                        @error('date_utilisation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveExistSortie()" wire:loading.attr="disabled" wire:target="saveExistSortie()">
                            <span wire:loading.remove wire:target="saveExistSortie"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveExistSortie">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>

                        <button class="btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormSortie()" wire:loading.attr="disabled" wire:target="resetFormSortie()">
                            <span wire:loading.remove wire:target="resetFormSortie"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reinitialiser</span>
                            <span wire:loading wire:target="resetFormSortie">
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