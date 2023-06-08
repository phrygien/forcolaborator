<div class="col-md-12">
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
                        <label for="firstName2">{{ __('Quantité')}}</label>
                        <input type="number" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                        @if (session()->has('somme_non_ok'))
                        <div class="alert alert-danger border-info" role="alert">
                            <i class="icon-info1"></i>{{ session('somme_non_ok')}}
                        </div>
                        @endif
                    </div>


                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="number" wire:model="pu" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu') 
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

                                        
                    <div class="col-md-12 col-lg-12">
                        <div class="alert alert-card alert-info" role="alert">
                            <strong class="text-capitalize">Détails de la sortie oeuf</strong> - veuillez ajouter les éléments pour la sortie.
                        </div>
                        <p>
                            @if($addLigne)
                            <button type="button" wire:click="addDetail" class="btn btn-instagram btn-rounded btn-icon m-1">
                                <span class="ul-btn__icon"><i class="i-Add"></i></span>
                                <span class="ul-btn__text">Ajouter detail</span>
                            </button>
                            @endif
                        </p>
                        <p>
                          
                            
                            <div class="table-responsive">
                                @if (session()->has('impossible'))
                                <div class="alert alert-danger border-info" role="alert">
                                    <i class="icon-info1"></i>{{ session('impossible')}}
                                </div>
                                @endif

                                <table id="user_table" class="table  text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Constat ID</th>
                                            <th scope="col">Nombre d'eouf disponible</th>
                                            <th scope="col">Qte utilise</th>
                                            <th scope="col">Prix unitaire (Ar) </th>
                                            <th scope="col">Montant total (Ar)</th>
                                            <th scope="col">ID Produit</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sortie['details'] as $index => $produit)
                                        <tr>
                                            <th scope="row">
                                                <select class="form-control form-control-rounded"  wire:model="sortie.details.{{ $index }}.id_constat" wire:change="updateNombreDisponible($event.target.value, {{ $index }})">
                                                    <option value="">Sélectionner un constat</option>
                                                    @foreach ($constatDisponibles as $constatDisponible)
                                                    @php
                                                        $constatDejaAffiche = false;
                                                    @endphp
                                                    @foreach ($sortie['details'] as $i => $const)
                                                        @if ($i < $index && $const['id_constat'] == $constatDisponible->id)
                                                            @php
                                                                $constatDejaAffiche = true;
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if (!$constatDejaAffiche)
                                                        <option value="{{ $constatDisponible->id }}">ID  constat: {{ $constatDisponible->id }} - Date constat : {{ $constatDisponible->date_entree }}</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                            </th>
                                            <td>
                                                <input type="text" readonly class="form-control form-control-rounded" wire:model.defer="sortie.details.{{ $index }}.nb_disponible" id="firstName2" placeholder="">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-rounded" id="firstName2" wire:keyup="calculateMontantTotal({{ $index }})" wire:model="sortie.details.{{ $index }}.qte_detail" placeholder="">
                                                @if(session()->has("error.{$index}"))
                                                <div class="alert alert-warning border-info" role="alert">
                                                    <p class="text-danger">{{ session("error.{$index}") }}</p>
                                                </div>
                                                @endif
                                            </td>

                                            <td>
                                                <input type="number" class="form-control form-control-rounded" wire:keydown="calculateMontantTotal({{ $index }})" wire:model.defer="sortie.details.{{ $index }}.prix_unitaire_detail" placeholder="">
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control form-control-rounded"  wire:model="sortie.details.{{ $index }}.montant_total_detail" placeholder="">
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control form-control-rounded"  wire:model="sortie.details.{{ $index }}.id_produit" placeholder="">
                                            </td>
                                            <td>
                                                <a wire:click="removeDetail({{ $index }})" href="#" class="text-danger mr-2">
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </p>
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