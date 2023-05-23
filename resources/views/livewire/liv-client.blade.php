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

    @if($createClient)
        @include('livewire.clients.create')
    @endif

    @if($editClient)
        @include('livewire.clients.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste clients ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formClient" wire:loading.attr="disabled" wire:target="formClient">
                        <span wire:loading.remove wire:target="formClient">Créer client</span>
                        <span wire:loading wire:target="formClient">
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
                        <strong class="text-black">Suppression client !</strong>
                        <p class="text-black">Vous etes sure de supprimer le client : {{$recordToDelete->nom }}?</p>
                        @if (session()->has('error'))
                        <div class="alert alert-warning border-danger" role="alert">
                            <i class="icon-info1"></i>{{ session('error')}}
                        </div>
                        @endif
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
                                <th scope="col">{{ __('Nom')}}</th>
                                <th scope="col">{{ __('Raison sociale')}}</th>
                                <th scope="col">{{ __('Adresse')}}</th>
                                <th scope="col">{{ __('Montant vente poulet')}}</th>
                                <th scope="col">{{ __('Montant vente oeuf')}}</th>
                                <th scope="col">{{ __('Derniere vente poulet')}}</th>
                                <th scope="col">{{ __('Derniere vente oeuf')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->nom }}</td>
                                <td>{{ $client->raison_sociale }}</td>
                                <td>{{ $client->adresse }}</td>
                                <td><span class="text-success text-14">{{ $client->total_montant_poulet  }}</span> (Ar)</td>
                                <td><span class="text-success text-14">{{ $client->total_montant_oeuf  }}</span> (Ar)</td>
                                <td>
                                    @if($client->date_vente_poulet !=null)
                                    {{  get_formatted_date($client->date_vente_poulet, 'd / M / Y') }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @if($client->date_vente_oeuf !=null)
                                    {{  get_formatted_date($client->date_vente_oeuf, 'd/ M/ Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="editClient({{$client->id }})" wire:loading.attr="disabled" wire:target="editClient({{$client->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editClient({{$client->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editClient({{$client->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="confirmerDelete({{$client->id }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </button>
                                </td>
                            </tr>                                  
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $clients->links() }}

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