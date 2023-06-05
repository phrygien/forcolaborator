<div class="col-md-12 col-lg-12 mb-4">
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
</div>