

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
        @include('livewire.sortie_oeufs.create')
    @endif

@if($afficherListe)

<div class="col-md-12">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formSortie" wire:loading.attr="disabled" wire:target="formSortie">
                        <span wire:loading.remove wire:target="formSortie">Créer sortie oeuf</span>
                        <span wire:loading wire:target="formSortie">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
            </h4>

            <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Type oeuf')}}</th>
                                <th scope="col">{{ __('Type sortie')}}</th>
                                <th scope="col">{{ __('Client')}}</th>
                                <th scope="col">{{ __('Date sortie')}}</th>
                                <th scope="col">{{ __('Quantité')}}</th>
                                <th scope="col">{{ __('Montant total')}}</th>
                                <th scope="col">{{ __('Utilisateur')}}</th>
                                <th scope="col">{{ __('Status')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sorties as $sortie)
                            <tr @if($sortie->retour != 0) class="text-danger" @endif>
                                <td>{{ $sortie->type }}</td>
                                <td>{{ $sortie->libelle }}</td>
                                <td>{{ $sortie->nom }}</td>
                                <td>{{ get_formatted_date($sortie->date_sortie, "d - M - Y") }}</td>
                                <td>{{ $sortie->qte }}</td>
                                <td>{{ number_format($sortie->montant, 0, ',', ' ') }} Ar</td>
                                <td>{{ $sortie->name }}</td>
                                <td>
                                    @if($sortie->retour == 0)
                                        <span class="text-success"> <i class="nav-icon i-Yes font-weight-bold"></i> aucun retour</span>
                                    @else
                                        <span class="text-danger"> <i class="nav-icon i-Reload font-weight-bold"></i> deja retourner</span>
                                    @endif
                                </td>
                                <td>
                                    <button @if($sortie->retour !=0) disabled @endif wire:click="retourSortie({{$sortie->id }})" wire:loading.attr="disabled" wire:target="retourSortie({{$sortie->id }})" class="btn btn-youtube btn-icon m-1 btn-rounded">
                                        <span wire:loading.remove wire:target="retourSortie({{$sortie->id }})">retour produit </span>
                                        <span class="ul-btn__icon"><i class="i-Right1"></i></span>
                                        <span wire:loading wire:target="retourSortie({{$sortie->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            chargement...
                                        </span>
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
@if($retourSortie)
@include('livewire.sortie_oeufs.retour')
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