<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">{{ __('Type oeuf')}}</th>
                <th scope="col">{{ __("Nombre d’oeufs")}}</th>
                <th scope="col" width="149px">{{ __('Nb constat')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($constatsDuJour as $constat)
            <tr>
                <th scope="row">{{ $constat->type }}</th>
                <th><span class="badge bg-success text-white text-14">{{ number_format($constat->total_nb, 0, ',', ' ') }} oeufs </span></th>
                <td><span class="badge bg-info text-white text-14">{{ $constat->total_constats }} constat(s)</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">
                    <span class="text-20 text-center text-secondary">pas de constat pour le moment !</span>
                </td>
            </tr>                                
            @endforelse

        </tbody>
    </table>
</div>
