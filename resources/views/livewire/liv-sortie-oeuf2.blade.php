<div class="row mb-4">

    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">
                    <button wire:click.prevent="addDynamicInput" class="btn btn-primary">Ajouter ligne</button>
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Constat</th>
                                <th scope="col">Stock Disponible</th>
                                <th scope="col">Qte</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dynamicInputs as $index => $dynamicInput)
                            <tr>
                                <th scope="row">
                                    <select class="form-control form-control-rounded"  wire:model="addDynamicInput.{{ $index }}">
                                        <option>Option 1</option>
                                        @foreach ($constats as $const )
                                        <option>{{ $const->date_entree}}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <td>
                                    <input class="form-control form-control-rounded" id="credit2" placeholder="Disponible">
                                </td>
                                <td>
                                    <input class="form-control form-control-rounded" id="credit2" placeholder="Card">
                                </td>
                                <td>
                                    <a href="#" class="text-success mr-2">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                    <a href="#" class="text-danger mr-2"  wire:click.prevent="removeDynamicInput({{ $index }})">
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