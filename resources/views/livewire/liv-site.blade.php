
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

    @if($createSite)
        @include('livewire.sites.create')
    @endif

    @if($updateSite)
        @include('livewire.sites.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste site ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formCreation" wire:loading.attr="disabled" wire:target="formCreation">
                        <span wire:loading.remove wire:target="formCreation">Créer</span>
                        <span wire:loading wire:target="formCreation">
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
                        <strong class="text-black">Suppression site !</strong>
                        <p class="text-black">Vous etes sure de supprimer le site : {{$recordToDelete->site }}?</p>
                        @if (session()->has('error'))
                        <div class="alert alert-warning border-danger" role="alert">
                            <i class="icon-info1"></i>{{ session('error')}}
                        </div>
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-warning btn-rounded" wire:click="desactiverSite()">{{ __('Desactiver') }}</button>
                        </p>
                        @else
                        @if (session()->has('inactif'))
                        <div class="alert alert-info border-info" role="alert">
                            <i class="icon-info1"></i>{{ session('inactif')}}
                        </div>
                        @endif
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-danger btn-rounded" wire:click="delete()" wire:loading.attr="disabled" wire:target="delete">
                                <span wire:loading.remove wire:target="delete"> {{ __('Supprimer') }}</span>
                                <svg wire:loading wire:target="delete"  class="spinner" viewBox="0 0 50 50">
                                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                </svg>
                            </button>
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
                                <th scope="col">{{ __('Nom site')}}</th>
                                <th scope="col">{{ __('Adresse')}}</th>
                                <th scope="col">{{ __('Status')}}</th>
                                <th scope="col">{{ __('Date création')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sites as $site)
                            <tr>
                                <td>{{ $site->site }}</td>
                                <td>{{ $site->adresse }}</td>
                                <td>
                                    @if($site->actif == 1)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ $site->created_at->format('d, M y') }}</td>
                                <td>
                                    <button wire:click="edit({{$site->id }})" wire:loading.attr="disabled" wire:target="edit({{$site->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="edit({{$site->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <svg wire:loading wire:target="edit({{$site->id }})"  class="spinner" viewBox="0 0 50 50">
                                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                        </svg>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$site->id }})" wire:loading.attr="disabled" wire:target="confirmerDelete({{$site->id }})">
                                        <span wire:loading.remove wire:target="comfirmerDelete({{$site->id }})"><i class="nav-icon i-Close-Window font-weight-bold"></i></span>
                                        <svg wire:loading wire:target="comfirmerDelete({{$site->id }})"  class="spinner" viewBox="0 0 50 50">
                                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                        </svg>
                                    </button>
                                </td>
                            </tr> 
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <span class="text-20 text-center text-secondary">pas de donnée pour le moment !</span>
                                </td>
                            </tr>                                
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $sites->links() }}

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