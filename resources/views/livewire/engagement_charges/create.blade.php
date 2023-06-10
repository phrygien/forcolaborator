<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">{{ __('Création engagement charge')}}</div>
            <form>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="picker1">{{ __('Depense charges')}}</label>
                        <select wire:model.defer="id_depense" class="form-control form-control-rounded">
                            <option>Choisiser une depense</option>
                            @foreach ($depense_charges as $depensecharge)
                                <option value="{{ $depensecharge->id }}">{{ $depensecharge->nom_depense}}</option>
                            @endforeach
                        </select>
                        @error('id_depense') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="firstName2">{{ __('Prix unitaire')}}</label>
                        <input type="text" wire:model="pu" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('pu') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="firstName2">{{ __('Qte')}}</label>
                        <input type="text" wire:model="qte" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="firstName2">{{ __('Qte disponible')}}</label>
                        <input type="text" readonly wire:model.defer="qte_disponible" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('qte_disponible') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Prix total')}}</label>
                        <input type="text" wire:model.defer="prix_total" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('prix_total') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="firstName2">{{ __('Date engagement')}}</label>
                        <input type="text" readonly wire:model.defer="date_engagement" class="form-control form-control-rounded" id="firstName2" placeholder="">
                        @error('date_engagement') 
                        <div class="alert alert-danger" role="alert">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-12 mt-3">
                        <button class="btn btn-secondary btn-rounded" wire:click.prevent="cancelCreate()" wire:loading.attr="disabled" wire:target="cancelCreate()">
                            <span wire:loading.remove wire:target="cancelCreate"><i class="nav-icon i-Arrow-Back font-weight-bold"></i> Retour</span>
                            <span wire:loading wire:target="cancelCreate">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                annulation...
                            </span>
                        </button>

                        <button class="btn float-right btn-primary btn-rounded mr-3" wire:click.prevent="saveEngagement()" wire:loading.attr="disabled" wire:target="saveEngagement()">
                            <span wire:loading.remove wire:target="saveEngagement"><i class="nav-icon i-Yes font-weight-bold"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveEngagement">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                enregistrement...
                            </span>
                        </button>
                        <button class="btn float-right btn-danger btn-rounded mr-3" wire:click.prevent="resetInput()" wire:loading.attr="disabled" wire:target="resetInput()">
                            <span wire:loading.remove wire:target="resetInput"><i class="nav-icon i-Repeat-3 font-weight-bold"></i> Reinitialiser</span>
                            <span wire:loading wire:target="resetInput">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                reinitialisation...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>