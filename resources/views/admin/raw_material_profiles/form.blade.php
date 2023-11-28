@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="raw_material_profiles">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head') @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                           <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="material_code" class="col-form-label required">{{ __('Material Code') }}:</label>
                                    <input type="text" name="material_code" id="material_code" class="form-control" placeholder="{{ __('Material Code') }}" value="{{ old('material_code', $row->material_code) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="market_name" class="col-form-label required">{{ __('Market Name') }}:</label>
                                    <input type="text" name="market_name" id="market_name" class="form-control" placeholder="{{ __('Market Name') }}" value="{{ old('market_name', $row->market_name) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="raw_material_categories_id" class="col-form-label required">{{ __('Raw Material Category') }}:</label>
                                    <select name="raw_material_categories_id" id="raw_material_categories_id" class="form-control m-select2">
                                        {!! selectBox("SELECT id, name FROM raw_material_categories", old('raw_material_categories_id', $row->raw_material_categories_id)) !!}
                                    </select>         
                                </div>
                                <div class="col-lg-3">
                                    <label for="unit_id" class="col-form-label required">{{ __('Unit') }}:</label>
                                    <select name="unit_id" id="unit_id" class="form-control m-select2">
                                        {!! selectBox("SELECT id, unit FROM units", old('unit_id', $row->unit_id)) !!}
                                    </select>   
                                </div>
                                <div class="col-lg-3">
                                    <label for="multiple_unit" class="col-form-label required">{{ __('Multiple Units') }}:</label>
                                    <select name="multiple_unit" id="multiple_unit" class="form-control m-select2 multiple-form">
                                        {!! selectBox(DB_enumValues('raw_material_profiles', 'multiple_unit'), old('multiple_unit', $row->multiple_unit)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-6 secondary-unit">
                                    <label for="secondary_unit" class="col-form-label required">{{ __('Secondary Unit') }}:</label>
                                    <select name="secondary_unit" id="secondary_unit" class="form-control m-select2">
                                        {!! selectBox("SELECT id, unit FROM units", old('secondary_unit', $row->secondary_unit)) !!}
                                    </select>   
                                </div>
                                <div class="col-lg-6">
                                    <label for="conversion_factor" class="col-form-label required">{{ __('Conversion Factor') }}:</label>
                                    <input type="number" name="conversion_factor" id="conversion_factor" class="form-control" placeholder="{{ __('Conversion Factor') }}" value="{{ old('conversion_factor', $row->conversion_factor) }}" />
                                </div>
                            </div>
                            <div class="from-group row mb-3 mt-3 border p-3 bg-light">
                                <div class="col-lg-3">
                                    <label for="safety_stock" class="col-form-label required">{{ __('Safety Stock') }}:</label>
                                    <input type="text" name="safety_stock" id="safety_stock" class="form-control" placeholder="{{ __('Safety Stock') }}" value="{{ old('safety_stock', $row->safety_stock) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="reorder_quantity" class="col-form-label required">{{ __('Re-Order Quantity') }}:</label>
                                    <input type="text" name="reorder_quantity" id="reorder_quantity" class="form-control" placeholder="{{ __('Re-Order Quantity') }}" value="{{ old('reorder_quantity', $row->reorder_quantity) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="moq" class="col-form-label required">{{ __('MOQ') }}:</label>
                                    <input type="text" name="moq" id="moq" class="form-control" placeholder="{{ __('MOQ') }}" value="{{ old('moq', $row->moq) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="store" class="col-form-label required">{{ __('Store') }}:</label>
                                    <select name="store_id" id="store_id" class="form-control m-select2">
                                        {!! selectBox("SELECT id, name FROM stores", old('store_id', $row->store_id)) !!}
                                    </select>                                   
                                </div>
                                <div class="col-lg-3">
                                    <label for="storage_level_1" class="col-form-label required">{{ __('Storage Level 1') }}:</label>
                                    <select name="storage_level_1" id="storage_level_1" class="form-control m-select2">
                                        {!! selectBox("SELECT id, title FROM mode_storages", old('storage_level_1', $row->storage_level_1)) !!}
                                    </select>    
                                </div>
                                <div class="col-lg-3">
                                    <label for="storage_level_2" class="col-form-label required">{{ __('Storage Level 2') }}:</label>
                                    <select name="storage_level_2" id="storage_level_2" class="form-control m-select2">
                                        {!! selectBox("SELECT id, title FROM mode_storages", old('storage_level_2', $row->storage_level_2)) !!}
                                    </select>    
                                </div>
                                <div class="col-lg-6">
                                    <label for="exclusive_location" class="col-form-label required">{{ __('Exclusive Location') }}:</label>
                                    <select name="exclusive_location" id="exclusive_location" class="form-control m-select2" >
                                        {!! selectBox(DB_enumValues('raw_material_profiles', 'exclusive_location'), old('exclusive_location', $row->exclusive_location)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php $Form_btn = new Form_btn(); echo $Form_btn->buttons($form_buttons); @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection {{-- Scripts --}} @section('scripts')
    <script>
        $(document).ready(function(){
            $("div.secondary-unit").show();
    		$('.multiple-form').on('change', function(){
    			var value = $(this).val(); 
    			if(value == 'Yes'){
        			$("div.secondary-unit").show();
    			}
    			else if(value == 'No'){
        			$("div.secondary-unit").hide();
    			}
    		});
        });


        //  $(form#raw_material_dimensons).on('click', '.is_stations', function() {
        //         let is_stations = $(this).val();

        //         if (is_stations == 'true') {
        //             $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
        //             $('#is_stations-input-area').show();
        //         } else {
        //             $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
        //             $('#is_stations-input-area').hide();
        //         }
        //     });

            // $(form#raw_material_dimensons).on('click', '#modal-submit-button', function() {
            //     if (!checkRequiredInputs()) {
            //         notify(2, 'Please fill required inputs.');
            //     }

            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //         }
            //     });
            //     $.ajax({
            //         url: "{{ url('admin') }}",
            //         type: 'POST',
            //         data: $('#modal-form').serialize(),
            //         dataType: 'Json',
            //         success: function(response) {
            //             if (response.status) {
            //                 setTimeout(() => {
            //                     location.reload();
            //                 }, 2000);
            //             }
            //             notify(response.status, response.message);
            //         }
            //     });
            // });
            // $(document).on('click', '.edit-button', function() {
            //     let url = "{{ url('admin', ":id") }}";
            //     var id = $(this).data('id');
            //     url = url.replace(':id', id);

            //     $.ajax({
            //         url: url,
            //         type: 'get',
            //         dataType: 'Json',
            //         success: function(response) {
            //             if (response.status) {
            //                 $('#modal-heading').text('Edit OEM');
            //                 $('#modal-body').html(response.data);
            //                 if ($('#station_checked').val() == 'true') {
            //                     $('#stations-input-area').show();
            //                 } else {
            //                     $('#stations-input-area').hide();
            //                 }
            //                 $('#modal').show();
            //             } else {
            //                 notify(response.status, response.message);
            //             }
            //         }
            //     });
            // });

        // $("form#raw_material_dimensons").validate({
        //     // define validation rules
        //     rules: {
        //         opening_quantity: {
        //             required: true,
        //         },
        //         opening_date: {
        //             required: true,
        //         },
        //         stock_value: {
        //             required: true,
        //         },
        //     },
        //     /*messages: {
        // 'title' : {required: 'title is required',},'email' : {required: 'email is required',},'phone' : {required: 'phone is required',},    },*/
        //     //display error alert on form submit
        //     invalidHandler: function (event, validator) {
        //         KTUtil.scrollTop();
        //         //validator.errorList[0].element.focus();
        //     },
        //     submitHandler: function (form) {
        //         form.submit();
        //     },
        // });
    </script>
@endsection
