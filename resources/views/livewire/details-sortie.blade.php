{{-- <div class="col-md-12 col-lg-12 mb-4">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card text-left">

                <div class="card-body">
                    <h4 class="card-title mb-3"> Informations du sortie poulet</h4>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>

                                <tr class="bg-primary text-white">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre poulets</th>
                                    <th scope="col">Poids totale</th>
                                    <th scope="col">Prix unitaire</th>
                                    <th scope="col">Montant totale</th>
                                    <th scope="col">Prix par poulet</th>
                                    <th scope="col">Date de sortie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedSortie as $sortie)
                                <tr>
                                    <th scope="row">{{ $sortie->id }}</th>
                                    <td>{{ $sortie->nombre }} poulets</td>
                                    <td>{{ $sortie->poids_total }} kg</td>
                                    <td>{{ $sortie->prix_unite }} Ar</td>
                                    <td>{{ $sortie->montant }}</td>
                                    <td>{{ $sortie->pu_poulet }} Ar</td>
                                    <td>{{ $sortie->date_sortie }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="card text-left">

                <div class="card-body">
                    <h4 class="card-title mb-3"> Informations du client</h4>
                    <div class="table-responsive">
                        <table class="table ">
                            <tbody>
                                @foreach ($selectedSortie as $sortie)
                                <tr>
                                    <td scope="col" class="text-primary">Nom et prenom :</td>
                                    <td>{{ $sortie->nom }}</td>
                                </tr>
                                <tr>
                                    <td scope="col" class="text-primary">Raison sociale :</td>
                                    <td>{{ $sortie->raison_sociale }}</td>
                                </tr>
                                <tr>
                                    <td scope="col" class="text-primary">Adresse :</td>
                                    <td>{{ $sortie->adresse }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>

<div class="col-md-12 col-lg-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3"> Details de la sortie poulet</h4>
            <div class="table-responsive">
                <table class="table ">
                    <thead class="thead-dark">

                        <tr>
                            <th scope="col">ID Sortie</th>
                            <th scope="col">ID Constat</th>
                            <th scope="col">ID Produit</th>

                            <th scope="col">Qte details sortie</th>
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Montat totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailSorties as $detailSortie)
                        <tr>
                            <th scope="row">{{ $detailSortie->id_sortie }}</th>
                            <td>{{ $detailSortie->id_constat }}</td>
                            <td>{{ $detailSortie->id_produit }}</td>
                            <td>{{ $detailSortie->qte }}</td>
                            <td>{{ $detailSortie->valeur }}</td>
                            <td>{{ $detailSortie->pu }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div> --}}
<div class="col-md-12">
    <div class="card mb-4">
        @foreach ($selectedSortie as $sortie)
        <div class="card-body">
            <div class="card-title mb-3">Information sortie poulet</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type sortie')}}</label>
                        <select readonly disabled wire:model="id_type_sortie" class="form-control form-control-rounded">
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
                        <input type="number" readonly wire:model="nombre" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('nombre') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                                        
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Poids total')}}</label>
                        <input type="number" readonly wire:model="poids_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('poids_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="number" readonly wire:model="prix_unite" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('prix_unite') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant total')}}</label>
                        <input type="number" readonly disabled wire:model="montant" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix poulet')}}</label>
                        <input type="number" readonly wire:model="pu_poulet" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu_poulet') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date sortie')}}</label>
                        <input type="date" readonly wire:model="date_sortie" disabled class="disable form-control form-control-rounded">
                        @error('date_sortie') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Client')}}</label>
                        <select readonly disabled wire:model="id_client" class="form-control form-control-rounded">
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

                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

<div class="col-md-12 col-lg-12 mb-4">
    <div class="card text-left" style="border-top: solid 3px purple;">

        <div class="card-body">
            <h4 class="card-title mb-3"> Details de la sortie poulet</h4>
            <div class="table-responsive">
                <table class="table ">
                    <thead class="">

                        <tr>
                            <th scope="col">ID Sortie</th>
                            <th scope="col">ID Constat</th>
                            <th scope="col">ID Produit</th>

                            <th scope="col">Qte details sortie</th>
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Montat totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailSorties as $detailSortie)
                        <tr>
                            <th scope="row">{{ $detailSortie->id_sortie }}</th>
                            <td>{{ $detailSortie->id_constat }}</td>
                            <td>{{ $detailSortie->id_produit }}</td>
                            <td>{{ $detailSortie->qte }}</td>
                            <td>{{ $detailSortie->valeur }}</td>
                            <td>{{ $detailSortie->pu }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
<div class="col-md-12">
    <button class="btn btn-instagram float-right btn-raised btn-rounded" wire:click="validerRetour"><i class="nav-icon i-Start1"></i> Valider retour produit</button>
</div>