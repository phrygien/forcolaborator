
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

    @if($createLibelle)
        @include('livewire.libelle_depenses.create')
    @endif

    @if($editLibelle)
        @include('livewire.libelle_depenses.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste libelle dépenses ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formLibelle" wire:loading.attr="disabled" wire:target="formLibelle">
                        <span wire:loading.remove wire:target="formLibelle">Créer libelle depense</span>
                        <span wire:loading wire:target="formLibelle">
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
                        <strong class="text-black">Suppression libelle depense !</strong>
                        <p class="text-black">Vous etes sure de supprimer libelle depense : {{$recordToDelete->libelle }}?</p>
                        @if (session()->has('error'))
                        <div class="alert alert-warning border-danger" role="alert">
                            <i class="icon-info1"></i>{{ session('error')}}
                        </div>
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-warning btn-rounded" wire:click="desactiverLibelle()">{{ __('Desactiver') }}</button>
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
                                <th scope="col">{{ __('Libelle')}}</th>
                                <th scope="col">{{ __('Status')}}</th>
                                <th scope="col">{{ __('Date création')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($libelles as $libelle)
                            <tr>
                                <td>{{ $libelle->libelle }}</td>
                                <td>
                                    @if($libelle->actif == 1)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ get_formatted_date($libelle->created_at, "d / M/ Y") }}</td>
                                <td>
                                    <button wire:click="editLibelle({{$libelle->id }})" wire:loading.attr="disabled" wire:target="editLibelle({{$libelle->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editLibelle({{$libelle->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editLibelle({{$libelle->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="confirmerDelete({{$libelle->id }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </button>
                                </td>
                            </tr>                                  
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <span class="text-20 text-center text-secondary">pas de donnée pour le moment !</span>
                                </td>
                            </tr>                                
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $libelles->links() }}

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