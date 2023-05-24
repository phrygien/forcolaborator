<div class="row mb-4">

    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">
                    <button wire:click="addProduit" class="btn btn-outline-primary btn-rounded">Ajouter details sortie</button>
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Constat</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Montant</th>
                                <th scope="col" width="149px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produitsDisponibles as $produitDisponible)
                            <li>ID: {{ $produitDisponible->id}} / Date entrée: {{ $produitDisponible->date_entree}} </li>
                            @endforeach
                            @foreach ($sortie['produits'] as $index => $produit)
                            <tr>
                                <th scope="row">
                                    <select class="form-control form-control-rounded"  wire:model="sortie.produits.{{ $index }}.id_constat">
                                        <option value="">Sélectionner un produit</option>
                                        @foreach ($produitsDisponibles as $produitDisponible)
                                        @php
                                            $produitDejaAffiche = false;
                                        @endphp
                                        @foreach ($sortie['produits'] as $i => $prod)
                                            @if ($i < $index && $prod['id_constat'] == $produitDisponible->id)
                                                @php
                                                    $produitDejaAffiche = true;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        @if (!$produitDejaAffiche)
                                            <option value="{{ $produitDisponible->id }}">{{ $produitDisponible->date_entree }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                    </select>
                                    
                                </th>
                                <td>
                                    <input class="form-control form-control-rounded"  wire:model="sortie.produits.{{ $index }}.qte" id="credit2" placeholder="Quantité à sortir">
                                </td>
                                <td>
                                    <input class="form-control form-control-rounded"  wire:model="sortie.produits.{{ $index }}.montant_total" id="credit2" placeholder="Montant total">
                                </td>
                                <td>
                                    <a href="#" class="text-danger mr-2"  wire:click="removeProduit({{ $index }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <!-- end of col-->

</div>
<!-- end of row-->