@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="oem_model">
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
                             <div class="clone_container">
                                <div class="from-group row mb-3 clone"> 
                                <div class="col-lg-6">
                                    <label for="product_code" class="col-form-label required">Product Code:</label>
                                    <input type="text" name="product_code[]" id="product_code" class="form-control" placeholder="Product Code" value="{{ old('product_code', $row->product_code) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="product_name" class="col-form-label required">Product Name:</label>
                                    <input type="text" name="product_name[]" id="product_name" class="form-control" placeholder="Product Name" value="{{ old('product_name', $row->product_name) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="code_oem" class="col-form-label required">Code Oem:</label>
                                    <input type="text" name="code_oem[]" id="code_oem" class="form-control" placeholder="Code Oem" value="{{ old('code_oem', $row->code_oem) }}" />
                                        <option value="{{ old('code_oem', $row->code_oem) }}">Select Part Code Oem </option>
                                         {!! selectBox(DB_enumValues('oem_models', 'code_oem'), old('code_oem', $row->code_oem)) !!}
                                    </div>
                                 <div class="col-lg-6">
                                    <label for="part_name_oem" class="col-form-label required">Part Name Oem:</label>
                                    <input type="text" name="part_name_oem[]" id="part_name_oem" class="form-control" placeholder="Part Name Oem" value="{{ old('part_name_oem', $row->part_name_oem) }}" />
                                        <option value="{{ old('part_name_oem', $row->part_name_oem) }}">Select Part Name Oem </option>
                                         {!! selectBox(DB_enumValues('oem_models', 'part_name_oem'), old('part_name_oem', $row->part_name_oem)) !!}
                                    </div>
                                <div class="col-lg-6">
                                    <label for="part_no_oem" class="col-form-label required">Part No Oem:</label>
                                    <input type="text" name="part_no_oem[]" id="part_no_oem" class="form-control" placeholder="Part No Oem" value="{{ old('part_no_oem', $row->part_no_oem) }}" />
                                        <option value="">Select Part No Oem </option>
                                         {!! selectBox(DB_enumValues('oem_models', 'part_no_oem'), old('part_no_oem', $row->part_no_oem)) !!}
                                    </select>                                   
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="type_id" class="col-form-label required">Type:</label>
                                    <select name="type_id" id="type_id" value="{{ old('type_id', $row->type_id) }}" class="form-control m_selectpicker">
                                        <option value="">Select Type</option>
                                        {!! selectBox(DB_enumValues('finished_product_profiles', 'type_id'), old('type_id', $row->type_id)) !!}
                                    </select>                                
                                 </div>
                                  <div class="col-lg-6">
                                    <label for="man_min" class="col-form-label required">Man Min:</label>
                                    <input type="text" name="man_min" id="man_min" class="form-control" placeholder="Man Min" value="{{ old('man_min', $row->man_min) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="safety_stock" class="col-form-label required">Safety Stock:</label>
                                    <input type="text" name="safety_stock" id="safety_stock" class="form-control" placeholder="Safety Stock" value="{{ old('safety_stock', $row->safety_stock) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="quantity_pack" class="col-form-label required">Quantity / Pack:</label>
                                    <input type="text" name="quantity_pack" id="quantity_pack" class="form-control" placeholder="Quantity / Pack" value="{{ old('quantity_pack', $row->quantity_pack) }}" />
                                </div>
                                
                                <div class="col-lg-6">
                                    <label for="line" class="col-form-label">{{ __('No of Production Line') }}:</label>
                                    <input type="text" name="line[]" id="line" class="form-control" placeholder="{{ __('No Line') }}" value="{{ old('line', $row->line ?? 1) }}" />
                                </div>


                                  <div class="col-lg-6">
                                    <label for="production_capacity_day" class="col-form-label required">Production Capacity Day:</label>
                                    <input type="text" name="production_capacity_day" id="production_capacity_day" class="form-control" placeholder="Production Capacity Day" value="{{ old('production_capacity_day', $row->production_capacity_day) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="sequence" class="col-form-label required">Sequence:</label>
                                    <input type="text" name="sequence" id="sequence" class="form-control" placeholder="Sequence" value="{{ old('sequence', $row->sequence) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="oem_model_id" class="col-form-label required">Oem Model:</label>
                                        <input type="text" name="oem_model_id[]" id="oem_model_id" class="form-control" placeholder="Oem Model" value="{{ old('oem_model_id', $row->oem_model_id) }}" />
                                        <option value="{{ old('oem_model_id', $row->oem_model_id) }}">Select Oem Model </option>
                                         {!! selectBox(DB_enumValues('oem_models', 'oem_model_id'), old('oem_model_id', $row->oem_model_id)) !!}
                                    </div>
                                 <div class="col-lg-6">
                                    <label for="station" class="col-form-label required">Station:</label>
                                    <input type="text" name="station" id="station" class="form-control" placeholder="Station" value="{{ old('station', $row->station) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="dc_type" class="col-form-label required">Dc Type:</label>
                                    <input type="text" name="dc_type" id="dc_type" class="form-control" placeholder="Dc Type" value="{{ old('dc_type', $row->dc_type) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="oem_man_min" class="col-form-label required">Oem Man Min:</label>
                                    <input type="text" name="oem_man_min" id="oem_man_min" class="form-control" placeholder="Oem Man Min" value="{{ old('oem_man_min', $row->oem_man_min) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="sale_price" class="col-form-label required">Sale Price:</label>
                                    <input type="text" name="sale_price" id="sale_price" class="form-control" placeholder="Sale Price" value="{{ old('sale_price', $row->sale_price) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="wip_bin" class="col-form-label required">WIP Bin :</label>
                                       <input type="text" name="wip_bin[]" id="wip_bin" class="form-control" placeholder="Wip Bin" value="{{ old('wip_bin', $row->wip_bin) }}" />
                                        <option value="{{ old('wip_bin', $row->wip_bin) }}">Select Wip Bin </option>
                                         {!! selectBox(DB_enumValues('oem_models', 'wip_bin'), old('wip_bin', $row->wip_bin)) !!}
                                    </div>

                                  <div class="col-lg-6">
                                       <label for="store_id" class="col-form-label required">Store:</label>
                                       <input type="text" name="store_id[]" id="store_id" class="form-control" placeholder="Wip Bin" value="{{ old('wip_bin', $row->wip_bin) }}" />
                                        <option value="{{ old('store_id', $row->store_id) }}">Select Store </option>
                                         {!! selectBox(DB_enumValues('finished_product_profiles', 'store_id'), old('store_id', $row->store_id)) !!}
                                    </div>

                                <div class="col-lg-6">
                                    <label for="storage_level_1" class="col-form-label required">Storage Level 1:</label>
                                    <input type="text" name="storage_level_1[]" id="storage_level_1" class="form-control" placeholder="Storage Level 1" value="{{ old('storage_level_1', $row->storage_level_1) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="storage_level_2" class="col-form-label required">Storage Level 2:</label>
                                    <input type="text" name="storage_level_2" id="storage_level_2" class="form-control" placeholder="Storage Level 2" value="{{ old('storage_level_2', $row->storage_level_2) }}"/>
                                </div>
                                <div class="col-lg-6">
                                        <label for="location" class="col-form-label required">Exclusive Location:</label>
                                        <input type="text" name="exclusive[location][]" id="location" class="form-control" placeholder="Exclusive Location" value="{{ old('location.' . $index, $exclusive->location) }}" />
                                 </div>
                                  <div class="col-lg-6" style="margin-top: 35px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
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
     $(form#semi_finished_product_profiles).on('click', '.is_stations', function() {
                let is_stations = $(this).val();

                if (is_stations == 'true') {
                    $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
                    $('#is_stations-input-area').show();
                } else {
                    $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
                    $('#is_stations-input-area').hide();
                }
            });

            $(form#semi_finished_product_profiles).on('click', '#modal-submit-button', function() {
                if (!checkRequiredInputs()) {
                    notify(2, 'Please fill required inputs.');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('admin') }}",
                    type: 'POST',
                    data: $('#modal-form').serialize(),
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        notify(response.status, response.message);
                    }
                });
            });
            $(document).on('click', '.edit-button', function() {
                let url = "{{ url('admin', ":id") }}";
                var id = $(this).data('id');
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            $('#modal-heading').text('Edit Semi Finished Product Profile');
                            $('#modal-body').html(response.data);
                            if ($('#station_checked').val() == 'true') {
                                $('#stations-input-area').show();
                            } else {
                                $('#stations-input-area').hide();
                            }
                            $('#modal').show();
                        } else {
                            notify(response.status, response.message);
                        }
                    }
                });
            });
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'model_name[]');
        }

        $("form#semi_finished_product_profiles_model").validate({
            // define validation rules
            rules: {
                model_name: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    </script>
    
    
@endsection
