<div class="col-md-12">
    <div class="card mb-4">
        @if($notification)
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mt-3">
            <div id="notification" wire:transition.fade.out.500ms>
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    <i class="icon-info1"></i>{{ session('message')}}
                </div>
            @endif
        </div>
        <div wire:poll.5s="hideNotification"></div>
        </div>
        @endif

        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création utilisation dépense')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Type depense')}}</label>
                        <select wire:model="selectedType" class="select2 form-control form-control-rounded">
                            <option value="">Choisir un type de dépense</option>
                            @foreach ($typeDepenseActif as $typedepense)
                                <option value="{{ $typedepense->id }}">{{ $typedepense->type }}</option>
                            @endforeach
                        </select>
                        @error('selectedType') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Depense brute (depense globale)')}}</label>
                        <select wire:model="id_depense_brut" class="form-control form-control-rounded">
                            <option value="">Choisir un depense brute</option>
                            @foreach ($depenses as $depense)
                                <option value="{{ $depense->id }}">Date entrée: {{ $depense->date_entree}} - Montant brut : {{ $depense->montant_total }} - Qte brut : {{ $depense->qte }}</option>
                            @endforeach
                        </select>
                        @error('id_depense_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="picker1">{{ __('Utilisation cible')}}</label>
                        <select wire:model.defer="utilisation_cible" class="js-example-basic-single form-control form-control-rounded">
                            @if($choix_cycle)
                                <option>Selectioner un cycle</option>
                                @foreach($cycles as $cycle)
                                <option value="{{ $cycle->description }}">{{ $cycle->description }}</option>
                                @endforeach
                            @endif

                            @if($choix_site)
                            <option>Selectioner un site</option>
                            @foreach($sites as $site)
                            <option value="{{ $site->site }}">{{ $site->site }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('utilisation_cible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Montant brut')}}</label>
                        <input type="number" wire:model="montant_brut" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité brut')}}</label>
                        <input type="number" wire:model="qte_brut" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte_brut') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Quantité utlisation')}}</label>
                        <input type="number" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
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
                        <label for="firstName2">{{ __('Montant total utilisation')}}</label>
                        <input type="number" wire:model="montant" readonly class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('montant') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date utilisation')}}</label>
                        <input type="date" wire:model="date_utilisation" class="form-control form-control-rounded">
                        @error('date_utilisation') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <a href="{{ route('gestion_depense.depense_globales')}}" class="float-right btn btn-secondary btn-rounded mr-3" >
                            <span wire:loading.remove wire:target="cancelCreate"><i class="nav-icon i-Arrow-Back font-weight-bold"></i> Liste dépense globale</span>
                            <span wire:loading wire:target="cancelCreate">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                annulation...
                            </span>
                        </a>
                        <button class="float-right btn btn-danger btn-rounded mr-3" wire:click.prevent="resetFormUtilisation()" wire:loading.attr="disabled" wire:target="resetFormUtilisation()">
                            <span wire:loading.remove wire:target="resetFormUtilisation"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reinitialiser</span>
                            <span wire:loading wire:target="resetFormUtilisation">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                reinitialisation...
                            </span>
                        </button>
                        <button {{ $btn_disabled }} class="float-right btn btn-primary btn-rounded mr-3" wire:click.prevent="saveUtilisation()" wire:loading.attr="disabled" wire:target="saveUtilisation()">
                            <span wire:loading.remove wire:target="saveUtilisation"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveUtilisation">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            Livewire.on('removeNotification', function () {
                setTimeout(function () {
                    document.getElementById('notification').remove();
                }, 1000);
            });
        });
    </script>
@endpush
