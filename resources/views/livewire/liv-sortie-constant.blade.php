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
                        <label for="picker1">{{ __('Type sortie')}}</label>
                        <select wire:model="id_type_sortie" class="form-control form-control-rounded">
                            <option>Choisir un type sortie</option>
                            @foreach ($typesorties as $typesortie)
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
                        <input type="number" wire:model="nombre" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nombre') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                                        
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Poids total')}}</label>
                        <input type="number" wire:model="poids_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('poids_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="number" wire:model="prix_unite" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('prix_unite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total')}}</label>
                        <input type="number" disabled wire:model="montant" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date sortie')}}</label>
                        <input type="date" wire:model="date_sortie" disabled class="disable form-control form-control-rounded">
                        @error('date_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>


                    @if ($selectedOption == 'existe')
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Client')}}</label>
                        <select wire:model="id_client" class="form-control form-control-rounded">
                            <option value="">Choisir un client</option>
                            @foreach ($clients as $client)
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
                        <input type="text" wire:model="nom" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nom') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Raison sociale client')}}</label>
                        <input type="text" wire:model="raison_sociale" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('raison_sociale') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Adresse client')}}</label>
                        <input type="text" wire:model="adresse" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('adresse') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    @endif

                    <div class="col-md-6 form-group mb-3" hidden>
                        <label for="firstName2">{{ __('Utilisateur ID')}}</label>
                        <input type="text" wire:model="id_utilisateur" class="form-control form-control-rounded">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Détails sortie poulet')}}</div>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="id_dernier_constat">ID du constat</label>
                        <input type="text" readonly class="form-control form-control-rounded" wire:model="id_dernier_constat">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="date_constat">Date de constat</label>
                        <input type="text" readonly class="form-control form-control-rounded" id="lastName2" wire:model="date_constat">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="nb_disponible">Nombre disponible</label>
                        <input type="text" readonly class="form-control form-control-rounded" id="exampleInputEmail2" wire:model="nb_disponible">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">ID du produit</label>
                        <select class="form-control form-control-rounded">
                            <option value="poulet_de_chaire">Poulet de chaire</option>
                            <option value="oeuf">Oeuf</option>
                            <option value="poulard">Poulard</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="credit2">Quantité a sortir</label>
                        <input type="number" class="form-control form-control-rounded">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker3">Prix unitaire</label>
                        <input type="number" class="form-control form-control-rounded">
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="website2">Montant</label>
                        <input type="number" class="form-control form-control-rounded">
                    </div>
                    <div class="col-md-12 mt-3 mb-3">
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
        </div>
    </div>
</div>