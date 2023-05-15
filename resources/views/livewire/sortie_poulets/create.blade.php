<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création sortie poulet')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                    <label class="radio radio-outline-success">
                        <input type="radio" name="radio" wire:model="selectedOption" value="existe">
                        <span>Client existant</span>
                        <span class="checkmark"></span>
                    </label>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                    <label class="radio radio-outline-warning">
                        <input type="radio" name="radio" wire:model="selectedOption" value="nouvele">
                        <span>Nouveau client</span>
                        <span class="checkmark"></span>
                    </label>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type poulets')}}</label>
                        <select wire:model="id_type_poulet" class="form-control form-control-rounded">
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
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Cycle')}}</label>
                        <select wire:model.defer="id_cycle" class="form-control form-control-rounded">
                            <option value="">Choisir un cycle</option>
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
                    
                    <hr>
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type sortie')}}</label>
                        <select wire:model="id_type_sortie" class="form-control form-control-rounded">
                            <option>Choisir un type sortie</option>
                            @foreach ($typeSortieActifs as $typesortie)
                                <option value="{{ $typesortie->id }}">{{ $typesortie->libelle }}</option>
                            @endforeach
                        </select>
                        @error('id_type_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nombre des poulet')}}</label>
                        <input type="number" wire:model.defer="nombre" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nombre') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                                        
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Poids total')}}</label>
                        <input type="number" wire:model.defer="poids_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('poids_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Prix unite')}}</label>
                        <select wire:model="prix_unite" class="form-control form-control-rounded">
                            <option value="">Choisir un prix</option>
                            @foreach ($prixs as $prix)
                                <option value="{{ $prix->pu_kg }}">{{ $prix->pu_kg }}</option>
                            @endforeach
                        </select>
                        @error('prix_unite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unite')}}</label>
                        <input type="number" wire:model.defer="prix_unite" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('prix_unite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div> --}}

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date sortie')}}</label>
                        <input type="date" wire:model="date_sortie" disabled class="disable form-control form-control-rounded">
                        @error('date_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type client')}}</label>
                        <select wire:model="selectedOption" class="form-control form-control-rounded">
                            <option>Selectioner type client</option>
                            <option value="nouvele">Nouveau client</option>
                            <option value="existe">Client existant</option>
                        </select>
                    </div> --}}

                    @if ($selectedOption == 'existe')
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Client')}}</label>
                        <select wire:model="id_client" class="form-control form-control-rounded">
                            <option value="">Choisir un client</option>
                            @foreach ($clientActifs as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                            @endforeach
                        </select>
                        @error('id_client') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    @endif

                    @if ($selectedOption == 'nouvele')
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Nom client')}}</label>
                        <input type="text" wire:model.defer="nom" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nom') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Raison sociale client')}}</label>
                        <input type="text" wire:model.defer="raison_sociale" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('raison_sociale') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Adresse client')}}</label>
                        <input type="text" wire:model.defer="adresse" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('adresse') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    @endif


                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Status sortie')}}</label>
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
                        @if ($selectedOption == 'existe')
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveExistSortie()" wire:loading.attr="disabled" wire:target="saveExistSortie()">
                            <span wire:loading.remove wire:target="saveExistSortie"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveExistSortie">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        @endif

                        @if ($selectedOption == 'nouvele')
                        <button class="btn btn-primary btn-rounded mr-3" wire:click.prevent="saveNewSortie()" wire:loading.attr="disabled" wire:target="saveNewSortie()">
                            <span wire:loading.remove wire:target="saveNewSortie"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveNewSortie">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        @endif

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