<div class="row mb-4">
    @if($notification)
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
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

    @if($createUtilisation)
        @include('livewire.utilisations.create')
    @endif

    @if($editUtilisation)
        @include('livewire.utilisations.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formUtilisation" wire:loading.attr="disabled" wire:target="formUtilisation">
                        <span wire:loading.remove wire:target="formUtilisation">Créer</span>
                        <span wire:loading wire:target="formUtilisation">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
                <div class="table-responsive">
                                    
                @if($recordToDelete)
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
                        <strong class="text-black">Suppression utilisation dépense !</strong>
                        <p class="text-black">Vous etes sure de supprimer l'utilisation depense de : {{$recordToDelete->date_utilisation }}?</p>
                        @if (session()->has('error'))
                        <div class="alert alert-warning border-danger" role="alert">
                            <i class="icon-info1"></i>{{ session('error')}}
                        </div>
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-warning btn-rounded" wire:click="desactiverCycle()">{{ __('Desactiver') }}</button>
                        </p>
                        @else
                        @if (session()->has('inactif'))
                        <div class="alert alert-info border-info" role="alert">
                            <i class="icon-info1"></i>{{ session('inactif')}}
                        </div>
                        @endif
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-danger btn-rounded" wire:click="delete()">{{ __('Supprimer') }}</button>
                        </p>
                        @endif
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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Libelle dépense')}}</th>
                                <th scope="col">{{ __('Type dépense')}}</th>
                                <th scope="col">{{ __('Quantité utilisé')}}</th>
                                <th scope="col">{{ __('Montant total')}}</th>
                                <th scope="col">{{ __('Date utilisation')}}</th>
                                <th scope="col">{{ __('Date création')}}</th>
                                <th scope="col">{{ __('Dernier modification')}}</th>
                                <th scope="col" width="150px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($utilisations as $utilisation)
                            <tr>
                                <td>{{ $utilisation->libelle }}</td>
                                <td>{{ $utilisation->type }}</td>
                                <td>{{ number_format($utilisation->qte, 0, ',', ' ') }}</td>
                                <td>{{ number_format($utilisation->montant, 0, ',', ' ') }}</td>
                                <td>{{ get_formatted_date($utilisation->date_utilisation, "d / M / Y") }}</td>
                                <td>{{ get_formatted_date($utilisation->created_at, "d / M / Y H:m:s") }}</td>
                                <td>{{ get_formatted_date($utilisation->updated_at, "d / M / Y H:m:s") }}</td>
                                <td>
                                    <button wire:click="editDepense({{$utilisation->id }})" wire:loading.attr="disabled" wire:target="editDepense({{$utilisation->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editDepense({{$utilisation->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editDepense({{$utilisation->id }})">
                                            <svg wire:loading wire:target="editDepense({{$utilisation->id }})"  class="spinner" viewBox="0 0 50 50">
                                                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$utilisation->id }})" wire:loading.attr="disabled" wire:target="confirmerDelete({{$utilisation->id }})">
                                        <span wire:loading.remove wire:target="comfirmerDelete({{$utilisation->id }})">
                                            <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                        </span>
                                        <svg wire:loading wire:target="comfirmerDelete({{$utilisation->id }})"  class="spinner" viewBox="0 0 50 50">
                                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                        </svg>
                                    </button>
                                </td>
                            </tr>  
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <span class="text-20 text-center text-secondary">Aucune donnée disponible</span>
                                </td>
                            </tr>                                
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $utilisations->links() }}

            </div>
        </div>
    </div>
    <!-- end of col-->
    @endif
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