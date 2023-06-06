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
            <div class="card-title mb-3">Details sortie poulet du : {{ $sortie->date_sortie }}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">First name</label>
                        <input type="text" class="form-control form-control-rounded" id="firstName2" placeholder="Enter your first name">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="lastName2">Last name</label>
                        <input type="text" class="form-control form-control-rounded" id="lastName2" placeholder="Enter your last name">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="exampleInputEmail2">Email address</label>
                        <input type="email" class="form-control form-control-rounded" id="exampleInputEmail2" placeholder="Enter email">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="phone1">Phone</label>
                        <input class="form-control form-control-rounded" id="phone1" placeholder="Enter phone">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="credit2">Cradit card number</label>
                        <input class="form-control form-control-rounded" id="credit2" placeholder="Card">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="website2">Website</label>
                        <input class="form-control form-control-rounded" id="website2" placeholder="Web address">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker3">Birth date</label>
                        <input id="picker3" class="form-control form-control-rounded" placeholder="yyyy-mm-dd" name="dp">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">Select</label>
                        <select class="form-control form-control-rounded">
                            <option>Option 1</option>
                            <option>Option 1</option>
                            <option>Option 1</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-instagram float-right btn-raised btn-rounded"><i class="nav-icon i-Start1"></i> Valider retour produit</button>
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