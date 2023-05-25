
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

    @if($createDepense)
        @include('livewire.depense_global.create')
    @endif

    @if($editDepense)
        @include('livewire.depense_global.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formDepense" wire:loading.attr="disabled" wire:target="formDepense">
                        <span wire:loading.remove wire:target="formDepense">Créer depense global</span>
                        <span wire:loading wire:target="formDepense">
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
                        <strong class="text-black">Suppression dépense globale !</strong>
                        <p class="text-black">Vous etes sure de supprimer le depense globale : {{$recordToDelete->date_entree }}?</p>
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
                                <th scope="col">{{ __('Quantité')}}</th>
                                <th scope="col">{{ __('Montant total')}}</th>
                                <th scope="col">{{ __('Date entrée')}}</th>
                                <th scope="col">{{ __('Date création')}}</th>
                                <th scope="col">{{ __('Dernier modification')}}</th>
                                <th scope="col" width="150px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($depenses as $depense)
                            <tr>
                                <td>{{ $depense->libelle }}</td>
                                <td>{{ $depense->type }}</td>
                                <td>{{ number_format($depense->qte, 0, ',', ' ') }}</td>
                                <td>{{ number_format($depense->montant_total, 0, ',', ' ') }}</td>
                                <td>{{ get_formatted_date($depense->date_entree, "d / M / Y") }}</td>
                                <td>{{ get_formatted_date($depense->created_at, "d / M / Y H:m:s") }}</td>
                                <td>{{ get_formatted_date($depense->updated_at, "d / M / Y H:m:s") }}</td>
                                <td>
                                    <button wire:click="editDepense({{$depense->id }})" wire:loading.attr="disabled" wire:target="editDepense({{$depense->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editDepense({{$depense->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editDepense({{$depense->id }})">
                                            <svg wire:loading wire:target="editDepense({{$depense->id }})"  class="spinner" viewBox="0 0 50 50">
                                                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$depense->id }})" wire:loading.attr="disabled" wire:target="confirmerDelete({{$depense->id }})">
                                        <span wire:loading.remove wire:target="comfirmerDelete({{$depense->id }})">
                                            <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                        </span>
                                        <svg wire:loading wire:target="comfirmerDelete({{$depense->id }})"  class="spinner" viewBox="0 0 50 50">
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

                {{ $depenses->links() }}

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