

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
    @if($createConstat)
        @include('livewire.constat_oeufs.create')
    @endif

    @if($editConstat)
        @include('livewire.constat_oeufs.edit')
    @endif
    {{-- @livewire('donneejour-constant-oeuf') --}}
@if ($afficherListe)
<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formConstat" wire:loading.attr="disabled" wire:target="formConstat">
                        <span wire:loading.remove wire:target="formConstat">Créer constat oeuf</span>
                        <span wire:loading wire:target="formConstat">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
            </h4>

            <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#homeIcon" role="tab" aria-controls="homeIcon" aria-selected="true"><i class="nav-icon i-Check mr-1"></i>Liste constat d'oeufs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#profileIcon" role="tab" aria-controls="profileIcon" aria-selected="false"><i class="nav-icon i-File-Chart mr-1"></i> Rapport de constat du jour par type d’oeuf</a>
                </li>
            </ul>
            <div class="tab-content" id="myIconTabContent">
                <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">
                    <div class="table-responsive mt-3">
                                        
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
                                <strong class="text-black">Suppression constat d'oeuf !</strong>
                                <p class="text-black">Vous etes sure de supprimer le constat d'oeuf du : {{$recordToDelete->date_entree }}?</p>
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
                                        <th scope="col">{{ __('Type oeufs')}}</th>
                                        <th scope="col">{{ __("Nombre d’oeufs")}}</th>
                                        <th scope="col">{{ __('Cycle')}}</th>
                                        <th scope="col">{{ __('Date entrée')}}</th>
                                        <th scope="col">{{ __('Utilisateur')}}</th>
                                        <th scope="col">{{ __('Dernière modification')}}</th>
                                        <th scope="col" width="149px">{{ __('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($constats as $constat)
                                    <tr>
                                        <td>{{ $constat->type }}</td>
                                        <td>{{  number_format($constat->nb, 0, ',', ' ') }}</td>
                                        <td>{{ $constat->description }}</td>
                                        <td>{{ $constat->date_entree }}</td>
                                        <td>{{ $constat->name }}</td>
                                        <td>{{ $constat->updated_at }}</td>
                                        <td>
                                            <button wire:click="editConstat({{$constat->id }})" wire:loading.attr="disabled" wire:target="editConstat({{$constat->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                                <span wire:loading.remove wire:target="editConstat({{$constat->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                                <span wire:loading wire:target="editConstat({{$constat->id }})">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    modification...
                                                </span>
                                            </button>
                                            <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$constat->id }})">
                                                <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                            </button>
                                        </td>
                                    </tr>                                  
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <span class="text-20 text-center text-secondary">pas de donnée pour le moment !</span>
                                        </td>
                                    </tr>                                
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $constats->links() }}
                </div>
                <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">
                    <livewire:donneejour-constant-oeuf />
                </div>
                
            </div>
        </div>
    </div>
</div>
{{-- 
<div class="col-md-12">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formConstat" wire:loading.attr="disabled" wire:target="formConstat">
                        <span wire:loading.remove wire:target="formConstat">Créer constat oeuf</span>
                        <span wire:loading wire:target="formConstat">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
            </h4>

            {{-- <div class="table-responsive">
                                        
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
                        <strong class="text-black">Suppression constat d'oeuf !</strong>
                        <p class="text-black">Vous etes sure de supprimer le constat d'oeuf du : {{$recordToDelete->date_entree }}?</p>
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
                                <th scope="col">{{ __('Type oeufs')}}</th>
                                <th scope="col">{{ __('Nombre oeuf')}}</th>
                                <th scope="col">{{ __('Cycle')}}</th>
                                <th scope="col">{{ __('Date entrée')}}</th>
                                <th scope="col">{{ __('Utilisateur')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($constats as $constat)
                            <tr>
                                <td>{{ $constat->type }}</td>
                                <td>{{ $constat->nb }}</td>
                                <td>{{ $constat->description }}</td>
                                <td>{{ $constat->date_entree }}</td>
                                <td>{{ $constat->name }}</td>
                                <td>
                                    <button wire:click="editConstat({{$constat->id }})" wire:loading.attr="disabled" wire:target="editConstat({{$constat->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editConstat({{$constat->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editConstat({{$constat->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$constat->id }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </button>
                                </td>
                            </tr>                                  
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $constats->links() }} --}}
        {{-- </div>
    </div>
</div> --}}

    {{-- <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste constat oeufs ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formConstat" wire:loading.attr="disabled" wire:target="formConstat">
                        <span wire:loading.remove wire:target="formConstat">Créer constat oeuf</span>
                        <span wire:loading wire:target="formConstat">
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
                        <strong class="text-black">Suppression constat d'oeuf !</strong>
                        <p class="text-black">Vous etes sure de supprimer le constat d'oeuf du : {{$recordToDelete->date_entree }}?</p>
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
                                <th scope="col">{{ __('Type oeufs')}}</th>
                                <th scope="col">{{ __('Nombre oeuf')}}</th>
                                <th scope="col">{{ __('Cycle')}}</th>
                                <th scope="col">{{ __('Date entrée')}}</th>
                                <th scope="col">{{ __('Utilisateur')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($constats as $constat)
                            <tr>
                                <td>{{ $constat->type }}</td>
                                <td>{{ $constat->nb }}</td>
                                <td>{{ $constat->description }}</td>
                                <td>{{ $constat->date_entree }}</td>
                                <td>{{ $constat->name }}</td>
                                <td>
                                    <button wire:click="editConstat({{$constat->id }})" wire:loading.attr="disabled" wire:target="editConstat({{$constat->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editConstat({{$constat->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editConstat({{$constat->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
                                    </button>
                                    <button class="btn btn-raised btn-rounded btn-raised-danger"  wire:click="comfirmerDelete({{$constat->id }})">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                    </button>
                                </td>
                            </tr>                                  
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $constats->links() }}

            </div>
        </div>
    </div>
    <!-- end of col--> --}}
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