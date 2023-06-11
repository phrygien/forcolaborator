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

    @if($createEngagement)
        @include('livewire.engagement_charges.create')
    @endif

    @if($editEngagement)
        @include('livewire.engagement_charges.edit')
    @endif

    @if ($afficherListe)
    <div class="col-md-12 mb-3">
        <div class="card text-left">

            <div class="card-body">
                <h4 class="card-title mb-3">{{ __('Liste engagement charges ') }}</h4>
                <p>
                    <button class="btn btn-primary btn-rounded" wire:click="formEngagement" wire:loading.attr="disabled" wire:target="formEngagement">
                        <span wire:loading.remove wire:target="formEngagement">Créer engagement</span>
                        <span wire:loading wire:target="formEngagement">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            création...
                        </span>
                    </button>
                </p>
                <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Depense')}}</th>
                                <th scope="col">{{ __('Prix Unitaire')}}</th>
                                <th scope="col">{{ __('Qte')}}</th>
                                <th scope="col">{{ __('Prix Total')}}</th>
                                <th scope="col">{{ __('Date d\'engagement ')}}</th>
                                <th scope="col">{{ __('Qte disponible')}}</th>
                                <th scope="col">{{ __('Date creation')}}</th>
                                <th scope="col" width="149px">{{ __('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($engagements as $engagement)
                            <tr>
                                <td>{{ $engagement->nom_depense }}</td>
                                <td>{{ $engagement->pu }}</td>
                                <td>{{ $engagement->qte }} {{ $engagement->label }}</td>
                                <td>{{ $engagement->prix_total }}</td>
                                <td>{{ get_formatted_date($engagement->date_engagement, "d - M - Y a H:s") }}</td>
                                <td>{{ $engagement->qte_disponible }}  {{ $engagement->label }}</td>
                                <td>{{ get_formatted_date($engagement->created_at, "d - M - Y a H:s") }}</td>
                                <td>
                                    <button wire:click="editEngagement({{$engagement->id }})" wire:loading.attr="disabled" wire:target="editEngagement({{$engagement->id }})" class="btn btn-raised btn-rounded btn-raised-primary">
                                        <span wire:loading.remove wire:target="editEngagement({{$engagement->id }})"><i class="nav-icon i-Pen-2 font-weight-bold"></i></span>
                                        <span wire:loading wire:target="editEngagement({{$engagement->id }})">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            modification...
                                        </span>
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

                {{ $engagements->links() }}

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