<div class="col-md-12">
    <form>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">{{ __('Création sortie oeuf')}}</div>
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
                            <label for="picker1">{{ __('Type oeuf')}}</label>
                            <select wire:model="id_type_oeuf" class="form-control form-control-rounded">
                                <option value="">Choisir un type d'oeuf</option>
                                @foreach ($typeOeufActifs as $typeoeuf)
                                    <option value="{{ $typeoeuf->id }}">{{ $typeoeuf->type }}</option>
                                @endforeach
                            </select>
                            @error('id_type_oeuf') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                        </div>
                        
                        <hr>
                        <div class="col-md-6 form-group mb-3">
                            <label for="picker1">{{ __('Type sortie')}}</label>
                            <select wire:model="id_type_sortie_sortie" class="form-control form-control-rounded">
                                <option>Choisir un type sortie</option>
                                @foreach ($typesorties as $typesortie)
                                    <option value="{{ $typesortie->id }}">{{ $typesortie->libelle }}</option>
                                @endforeach
                            </select>
                            @error('id_type_sortie_sortie') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName2">{{ __('Quantité')}}</label>
                            <input type="number" wire:model="qte_sortie" class="form-control form-control-rounded" id="firstName2" placeholder="">
                            @error('qte_sortie') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                        </div>
    
    
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName2">{{ __('Prix unitaire')}}</label>
                            <input type="number" wire:model="pu_sortie" class="form-control form-control-rounded" id="firstName2" placeholder="">
                            @error('pu_sortie') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                        </div>
    
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName2">{{ __('Montant total')}}</label>
                            <input type="number" disabled wire:model="montant_sortie" class="form-control form-control-rounded" id="firstName2" placeholder="">
                            @error('montant_sortie') 
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

    
                        <div class="col-md-6 form-group mb-3" hidden>
                            <label for="firstName2">{{ __('Utilisateur ID')}}</label>
                            <input type="text" wire:model.defer="id_utilisateur" class="form-control form-control-rounded">
                        </div>
    
                    </div>
                </form>
            </div>
        </div>
    <div class="card mb-4" style="border: solid 3px #ececec;">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Détails sortie oeuf')}}</div>
                <div class="row">
                    <div class="col-md-6 form-group mb-5">
                        <label for="id_dernier_constat">ID du constat</label>
                        <input type="text" readonly class="form-control form-control-rounded" wire:model="id_dernier_constat">
                        @error('id_dernier_constat') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-5">
                        <label for="date_constat">Date de constat</label>
                        <input type="text" readonly class="form-control form-control-rounded" id="lastName2" wire:model="date_constat_detail">
                        @error('date_constat_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="nb_disponible">Nombre d'oeufs disponible</label>
                        <input type="text" readonly class="form-control form-control-rounded" id="exampleInputEmail2" wire:model="nb_disponible_constat">
                        @error('nb_disponible_constat') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">ID du produit</label>
                        <select class="form-control form-control-rounded" wire:model="id_produit">
                            <option>Sellectioner un ID produit</option>
                            <option value="oeuf">Oeuf</option>
                        </select>
                        @error('id_produit') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker3">Prix unitaire en (Ar)</label>
                        <input type="number" class="form-control form-control-rounded" wire:model="prix_unitaire_detail">
                        @error('prix_unitaire_detail') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
    
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="credit2">Quantité d'oeufs à sortir</label>
                        <input type="number" class="form-control form-control-rounded" wire:model="qte_sortie_detail">
                        @error('qte_sortie_detail') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror

                        @if (session()->has('error'))
                        <div class="alert alert-warning border-info" role="alert">
                            {{ session('error')}}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="website2">Montant en (Ar)</label>
                        <input type="number" readonly class="form-control form-control-rounded" wire:model="valeur">
                        @error('valeur') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-12 mt-3 mb-3">
                        <button class="btn btn-secondary btn-rounded" wire:click.prevent="cancelCreate()" wire:loading.attr="disabled" wire:target="cancelCreate()">
                            <span wire:loading.remove wire:target="cancelCreate"><i class="nav-icon i-Arrow-Back font-weight-bold"></i> Retour</span>
                            <span wire:loading wire:target="cancelCreate">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                annulation...
                            </span>
                        </button>
                        <button class="float-right btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormSortieConstat()" wire:loading.attr="disabled" wire:target="resetFormSortieConstat()">
                            <span wire:loading.remove wire:target="resetFormSortieConstat"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reinitialiser</span>
                            <span wire:loading wire:target="resetFormSortieConstat">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                reinitialisation...
                            </span>
                        </button>
                        @if ($selectedOption == 'existe')
                        <button {{ $btn_disabled }} class="float-right btn btn-primary btn-rounded mr-3" wire:click.prevent="saveSortieAndDetailForExisteClient()" wire:loading.attr="disabled" wire:target="saveSortieAndDetailForExisteClient()">
                            <span wire:loading.remove wire:target="saveSortieAndDetailForExisteClient"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveSortieAndDetailForExisteClient">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        @endif

                        @if ($selectedOption == 'nouvele')
                        <button {{ $btn_disabled }} class="float-right btn btn-primary btn-rounded mr-3" wire:click.prevent="saveSortieAndDetailForNewClient()" wire:loading.attr="disabled" wire:target="saveSortieAndDetailForNewClient()">
                            <span wire:loading.remove wire:target="saveSortieAndDetailForNewClient"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveSortieAndDetailForNewClient">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        @endif
                    </div>
                </div>
        </div>
    </div>
</form>
</div>