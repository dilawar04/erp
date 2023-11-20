@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="store">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}">
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}"/>
                                </div>
                                <div class="col-lg-2">
                                    <label for="type" class="col-form-label required">{{ __('Store Material Type') }}:</label>
                                    <select name="type" id="type" class="form-control m_selectpicker" ="form-control" placeholder="{{ __('Store Material Type') }}" value="{{ old('store_material_type', $row->store_material_type) }}"/>
                                        {!! selectBox(DB_enumValues('stores', 'type'), old('type', $row->type)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="store_location_type" class="col-form-label">{{ __('Store Location Type') }}:</label>
                                    <input type="text" name="store_location_type" id="store_location_type" class="form-control" placeholder="{{ __('Store Location Type') }}" value="{{ old('store_location_type', $row->store_location_type) }}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-lg-6">
                                    <label for="location" class="col-form-label">{{ __('Location') }}:</label>
                                    <select name="location_id" id="location_id" class="form-control m-select2">
                                        <option value="">Select Office</option>
                                        {{--{!! selectBox("SELECT id, name FROM companies", old('location_id', $row->location_id)) !!}--}}
                                    </select>
                                    {{--<input type="text" name="location" id="location" class="form-control" placeholder="{{ __('Location') }}" value="{{ old('location', $row->location) }}"/>--}}
                                </div>
                                <div class="col-lg-2 internal-store">
                                    <label for="no_of_blocks" class="col-form-label">{{ __('No Of Blocks') }}:</label>
                                    <input type="number" min="1" name="no_of_blocks" id="no_of_blocks" class="form-control" placeholder="{{ __('No Of Blocks') }}" value="{{ old('no_of_blocks', ($row->no_of_blocks > 1 ? $row->no_of_blocks : 1)) }}"/>
                                </div>
                               
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="internal-store internal-stores-block" style="display: none;">
                                <div class="store-block border p-3 mb-2">
                                    <h4>Block <span>1</span></h4>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="mode_storages" class="col-form-label">{{ __('Mode of Storages') }}:</label>
                                            <input type="text" name="mode_storages" id="mode_storages" class="form-control" placeholder="{{ __('Mode of Storages') }}" value="{{ old('mode_storages', $row->mode_storages) }}"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="series_type" class="col-form-label">{{ __('Series Type') }}:</label>
                                            <input type="numeral" name="series_type" id="series_type" class="form-control" placeholder="{{ __('Series Type') }}" value="{{ old('series_type', $row->series_type) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="external-store" style="display: none;">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label for="address" class="col-form-label">{{ __('Address') }}:</label>
                                        <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('Address') }}" value="{{ old('address', $row->address) }}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="country" class="col-form-label">{{ __('Country') }}:</label><br>
                                        <select name="country" id="country" class="form-control m-select2" style="width: 100%">
                                            <option value="">Select Country</option>
                                            {!! selectBox("SELECT name, name as _name FROM countries", old('country', $row->country)) !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="city" class="col-form-label">{{ __('City') }}:</label>
                                        <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('City') }}" value="{{ old('city', $row->city) }}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="state" class="col-form-label">{{ __('State') }}:</label>
                                        <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('State') }}" value="{{ old('state', $row->state) }}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="postal_code" class="col-form-label">{{ __('Postal Code') }}:</label>
                                        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="{{ __('Postal Code') }}" value="{{ old('postal_code', $row->postal_code) }}"/>
                                    </div>
                                </div>
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-4">
                                        <label for="store_in_charge_name" class="col-form-label">{{ __('Store In Charge Name') }}:</label>
                                        <input type="text" name="store_in_charge_name" id="store_in_charge_name" class="form-control" placeholder="{{ __('Store In Charge Name') }}" value="{{ old('store_in_charge_name', $row->store_in_charge_name) }}"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="contact" class="col-form-label">{{ __('Contact') }}:</label>
                                        <input type="text" name="contact" id="contact" class="form-control" placeholder="{{ __('Contact') }}" value="{{ old('contact', $row->contact) }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php
                                    $Form_btn = new Form_btn();
                                    echo $Form_btn->buttons($form_buttons);
                                @endphp
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection

{{-- Scripts --}}
@section('scripts')
    <script>
        $('#type').on('change', function (){
           const _this = $(this);
           $('[class*="-store"]').hide(0, function (){
               $('.' + _this.val().toLowerCase() + '-store').show(0)
           })
        });
        $('#type').trigger('change');

        $('#no_of_blocks').on('blur', function (){
            const _this = $(this);
            const num = parseInt(_this.val());
            const exist_block = $('.store-block').length;
            if(exist_block > num){
                $('.store-block:gt(' + (num - 1) + ')').remove();
            }
            for (let i = exist_block; i < num; i++) {
                $('.store-block').eq(0).clone(true).appendTo('.internal-stores-block');
                let last_store = $('.store-block:last');
                last_store.find('h4 span').html(i + 1);
                last_store.find('input').val('');
            }
        });


        $("form#stores").validate({
            // define validation rules
            rules: {
                'name': {
                    required: true,
                },
                'type': {
                    required: true,
                },
            },
            /*messages: {
            'name' : {required: 'Name is required',},'type' : {required: 'Type is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>
@endsection
