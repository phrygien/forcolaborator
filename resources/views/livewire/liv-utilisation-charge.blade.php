
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
        @include('livewire.utilisation_charges.create')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste utilisation charge ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formUtilisation" wire:loading.attr="disabled" wire:target="formUtilisation">
                        <span wire:loading.remove wire:target="formUtilisation">Créer utilisation charge</span>
                        <span wire:loading wire:target="formUtilisation">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
                <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Nom depense')}}</th>
                                <th scope="col">{{ __('Site')}}</th>
                                <th scope="col">{{ __('Cycle')}}</th>
                                <th scope="col">{{ __('Qte')}}</th>
                                <th scope="col">{{ __('Date utilisation')}}</th>
                                <th scope="col">{{ __('Status')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($utilisations as $utilisation)
                            <tr>
                                <td>{{ $utilisation->nom_depense }}</td>
                                <td>
                                    @if($utilisation->site !=null)
                                    {{ $utilisation->site }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    @if($utilisation->description !=null)
                                        {{ $utilisation->description }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>{{ $utilisation->qte }}</td>
                                <td>{{ get_formatted_date($utilisation->date_utilisation, "d - M - Y") }}</td>
                                <td>
                                    @if($utilisation->avec_retour == 0)
                                        <span class="text-success"> <i class="nav-icon i-Yes font-weight-bold"></i> aucun retour</span>
                                    @else
                                        <span class="text-danger"> <i class="nav-icon i-Reload font-weight-bold"></i> deja retourner</span>
                                    @endif
                                </td>
                                <td>
                                    <button @if($utilisation->avec_retour !=0) disabled @endif wire:click="retourUtilisation({{$utilisation->id }})" wire:loading.attr="disabled" wire:target="retourUtilisation({{$utilisation->id }})" class="btn btn-youtube btn-icon m-1 btn-rounded">
                                        <span wire:loading.remove wire:target="retourUtilisation({{$utilisation->id }})">retour utilisation </span>
                                        <span class="ul-btn__icon"><i class="i-Right1"></i></span>
                                        <span wire:loading wire:target="retourUtilisation({{$utilisation->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            chargement...
                                        </span>
                                    </button>
                                </td>
                            </tr>                                  
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $utilisations->links() }}

            </div>
        </div>
    </div>
    <!-- end of col-->
    @endif
    @if($retourUtilisation)
        @include('livewire.utilisation_charges.retour')
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

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('affectationUpdated', function (value) {
            if (value === '2') {
                document.getElementById('id_site_div').style.display = 'block';
            } else {
                document.getElementById('id_site_div').style.display = 'none';
            }
        });
    });
</script>
@endpush