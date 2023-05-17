

<div class="row mb-4">

    @if($notification)
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
        <div id="notification" wire:transition.fade.out.500ms>
        @if (session()->has('message'))
            <div class="alert alert-success" role="alert">
                <i class="icon-info1"></i>{{ session('message')}}
            </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger border-info" role="alert">
            <i class="icon-info1"></i>{{ session('error')}}
        </div>
        @endif
    </div>
    <div wire:poll.5s="hideNotification"></div>
    </div>
    @endif
    @if($createSortie)
        @include('livewire.sortie_poulets.create')
    @endif

    @if($editSortie)
        @include('livewire.sortie_poulets.edit')
    @endif

@if($afficherListe)

<div class="col-md-12">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formSortie" wire:loading.attr="disabled" wire:target="formSortie">
                        <span wire:loading.remove wire:target="formSortie">Créer sortie poulet</span>
                        <span wire:loading wire:target="formSortie">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
            </h4>

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
                        <strong class="text-black">Suppression sortie poulet !</strong>
                        <p class="text-black">Vous etes sure de supprimer le sortie : {{$recordToDelete->date_sortie }}?</p>
                        <p class="text-center">
                            <button class="btn btn-secondary btn-rounded" wire:click="cancelDelete()">{{ __('Annuler') }}</button>
                            <button class="btn btn-danger btn-rounded" wire:click="delete()">{{ __('Supprimer') }}</button>
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

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Type poulet')}}</th>
                                <th scope="col">{{ __('Type sortie')}}</th>
                                <th scope="col">{{ __('Client')}}</th>
                                <th scope="col">{{ __('Date sortie')}}</th>
                                <th scope="col">{{ __('Poid total')}}</th>
                                <th scope="col">{{ __('Nombre')}}</th>
                                <th scope="col">{{ __('Montant total')}}</th>
                                <th scope="col">{{ __('Utilisateur')}}</th>
                                <th scope="col">{{ __('Status')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sorties as $sortie)
                            <tr>
                                <td>{{ $sortie->type }}</td>
                                <td>{{ $sortie->libelle }}</td>
                                <td>{{ $sortie->nom }}</td>
                                <td>{{ $sortie->date_sortie }}</td>
                                <td>{{ $sortie->poids_total }}</td>
                                <td>{{ $sortie->nombre }}</td>
                                <td><span class="badge bg-info text-white">Ar {{ $sortie->montant }}</span></td>
                                <td>{{ $sortie->name }}</td>
                                <td>
                                    @if($sortie->actif == 1)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="editSortie({{$sortie->id }})" wire:loading.attr="disabled" wire:target="editSortie({{$sortie->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editSortie({{$sortie->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editSortie({{$sortie->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$sortie->id }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </button>
                                </td>
                            </tr>                                  
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <span class="text-25 text-center text-warning">Aucune donnée disponible</span>
                                </td>
                            </tr>                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $sorties->links() }}
        </div>
    </div>
</div>
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