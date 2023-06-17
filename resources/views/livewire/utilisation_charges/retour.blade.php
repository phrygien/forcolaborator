<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            @if (session()->has('qte_error'))
            <div class="alert alert-danger border-info" role="alert">
                <i class="icon-info1"></i>{{ session('qte_error')}}
            </div>
            @endif

            <div class="card-title mb-3">{{ __('Retour utilisation charge')}}</div>
            <form>
                <div class="row">

                    {{-- <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type d\'affectation depense')}}</label>
                        <select wire:model="affectation" class="form-control form-control-rounded">
                            <option value="">Choisir un affectation</option>
                                <option value="2">Depense commune par site</option>
                                <option value="3">Depense commune par cycle</option>
                        </select>
                        @error('affectation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div> --}}

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Depense charges')}}</label>
                        <select wire:model="id_depense" disabled class="form-control form-control-rounded">
                            <option value="">Depense charge utilise</option>
                                @foreach ($depenses as $depense)
                                    <option value="{{ $depense->id }}">{{ $depense->nom_depense}}</option>
                                @endforeach
                        </select>
                        @error('id_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <!-- Sélection de l'ID du site -->
                    <div class="col-md-6 form-group mb-3" wire:loading.remove>
                            <label for="picker1">{{ __('Site')}}</label>
                            <select wire:model="id_site" disabled class="form-control form-control-rounded">
                                <option value="">Choisir un site</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->site}}</option>
                                @endforeach
                            </select>
                            @error('id_site') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                    </div>

                    <!-- Sélection de l'ID du cycle -->
                    <div class="col-md-6 form-group mb-3">
                            <label for="picker1">{{ __('Cycle')}}</label>
                            <select disabled wire:model="id_cycle" class="form-control form-control-rounded">
                                <option value="">Choisir un cycle</option>
                                @foreach ($cycles as $cycle)
                                    <option value="{{ $cycle->id }}">{{ $cycle->description}}</option>
                                @endforeach
                            </select>
                            @error('id_cycle') 
                            <div class="alert alert-danger" role="alert">
                                {{ $message}}
                            </div>
                            @enderror
                    </div>



                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Qte')}}</label>
                        <input type="number" disabled wire:model.defer="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date utilisation')}}</label>
                        <input type="date" disabled wire:model.defer="date_utilisation" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('date_utilisation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
{{-- 
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantite retour')}}</label>
                        <input type="number" wire:model="qte_retour" class="disable form-control form-control-rounded" style="border-bottom: solid 3px rgb(177, 139, 16);">
                        @error('qte_retour') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                        @if (session()->has('retour_impossible'))
                        <div class="alert alert-danger border-info" role="alert">
                            <i class="icon-info1"></i>{{ session('retour_impossible')}}
                        </div>
                        @endif
                    </div> --}}

                    <div class="col-md-6 form-group mb-3" hidden>
                        <label for="firstName2">{{ __('Utilisateur ID')}}</label>
                        <input type="text" wire:model.defer="id_utilisateur" class="form-control form-control-rounded">
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-raised mb-3 btn-raised-primary btn-rounded" wire:click.prevent="afficherUtilisation()" wire:loading.attr="disabled" wire:target="afficherUtilisation">
                            <span wire:loading.remove wire:target="afficherUtilisation"><i class="nav-icon i-Left1"></i> Annuler retour</span>
                            <span wire:loading wire:target="afficherUtilisation">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                chargement...
                            </span>
                        </button>

                        <button {{ $disableBtnValider }} class="btn btn-youtube btn-icon m-1 float-right mr-3 btn-rounded" wire:click.prevent="confirmerRetour()" wire:loading.attr="disabled" wire:target="confirmerRetour">
                            <span wire:loading.remove wire:target="confirmerRetour"><i class="nav-icon i-Yes font-weight-bold"></i> Valider retour</span>
                            <span wire:loading wire:target="confirmerRetour">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                chargement...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if($detailDepense)
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card text-left" style="border-top: solid 3px purple;">

        <div class="card-body">
            <h4 class="card-title mb-3"> Details utilisation charge</h4>
            <div class="table-responsive">
                <table class="table ">
                    <thead class="">

                        <tr>
                            <th scope="col">Cycle</th>
                            <th scope="col">Type depense</th>

                            <th scope="col">Qte utilisation</th>
                            <th scope="col">Valeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailDepense as $detail)
                        <tr>
                            <td> 
                                @if($detail['id_cycle'] !=null)
                                    {{ $detail['description'] }}
                                @else
                                    --
                                @endif</td>
                            <td>
                                @if($detail['type_depense'] == 1)
                                    Charges
                                @endif

                                @if($detail['type_depense'] == 2)
                                    Immobilisations
                                @endif
                            </td>
                            <td>{{ number_format($detail['qte'], 0, ',', ' ') }}</td>
                            <td><b>{{ number_format($detail['valeur'], 0, ',', ' ') }} Ar</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
@endif

@if($confirmRetour)
<!-- CSS -->
<style>
    .overlay {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    }
    
    .centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }
</style>

<!-- HTML -->
<div class="overlay">
    <div class="centered">
    <div class="alert alert-warning text-center">
        <strong class="text-black">{{ __('Retour utilisation charge')}} !</strong>
        <p class="text-black">Pouvez-vous confirmer retour utilisation ?</p>
        <p class="text-center">
            <button class="btn btn-secondary mr-3 btn-rounded" wire:click="cancelRetour()">{{ __('Fermer') }}</button>
            <button class="btn btn-danger ml-2 btn-rounded" wire:click.prevent="saveRetour()" wire:loading.attr="disabled" wire:target="saveRetour()">
                <span wire:loading.remove wire:target="saveRetour">{{ __('Confirmer') }}</span>
                <span wire:loading wire:target="saveRetour">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    validation...
                </span>
            </button>
        </p>
    </div>
    </div>
</div>

<script>
    // Désactiver le clic sur le reste de la page
    document.querySelector('.overlay').addEventListener('click', function(e) {
    e.stopPropagation();
    });
</script>
@endif
