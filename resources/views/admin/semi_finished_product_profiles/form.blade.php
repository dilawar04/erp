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
                                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code" value="{{ old('product_code', $row->product_code) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="product_name" class="col-form-label required">Product Name:</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="{{ old('product_name', $row->product_name) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="parent_product" class="col-form-label required">Parent Product:</label>
                                    <select name="parent_product" id="parent_product" value="{{ old('parent_product', $row->parent_product) }}"class="form-control m_selectpicker">
                                        <option value="">Select Parent Product</option>
                                         {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'parent_product'), old('parent_product', $row->parent_product)) !!}
                                    </select>                                   
                                 </div>
                                <div class="col-lg-6">
                                    <label for="process_location" class="col-form-label required">Process Location:</label>
                                    <select name="process_location" id="process_location" value="{{ old('process_location', $row->process_location) }}" class="form-control m_selectpicker">
                                        <option value="">Select Process Location</option>
                                         {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'process_location'), old('process_location', $row->process_location)) !!}
                                    </select>                                
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="workstation_id" class="col-form-label required">Workstation:</label>
                                    <select name="workstation_id" id="workstation_id" value="{{ old('workstation_id', $row->workstation_id) }}" class="form-control m_selectpicker">
                                        <option value="">Select Workstation</option>
                                         {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'workstation_id'), old('workstation_id', $row->workstation_id)) !!}
                                    </select>                                
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="line_of_list" class="col-form-label required">Line Of List:</label>
                                    <select name="line_of_list" id="line_of_list" value="{{ old('line_of_list', $row->line_of_list) }}" class="form-control m_selectpicker">
                                        <option value="">Select Line Of List</option>
                                        {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'line_of_list'), old('line_of_list', $row->line_of_list)) !!}
                                    </select>                                
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="daily_production_capacity" class="col-form-label required">Daily Production Capacity:</label>
                                    <input type="text" name="daily_production_capacity" id="daily_production_capacity" class="form-control" placeholder="Daily Production Capacity" value="{{ old('daily_production_capacity', $row->daily_production_capacity) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="safety_stock" class="col-form-label required">Safety Stock:</label>
                                    <input type="text" name="safety_stock" id="safety_stock" class="form-control" placeholder="Safety Stock" value="{{ old('safety_stock', $row->safety_stock) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="mode_of_storage" class="col-form-label required">Mode of Storage:</label>
                                    <select name="mode_of_storage" id="mode_of_storage" value="{{ old('mode_of_storage', $row->mode_of_storage) }}" class="form-control m_selectpicker">
                                        <option value="">Select Mode of Storage</option>
                                        {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'mode_of_storage'), old('mode_of_storage', $row->mode_of_storage)) !!}
                                    </select>                                
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="quantity_pack" class="col-form-label required">Quantity / Pack:</label>
                                    <input type="text" name="quantity_pack" id="quantity_pack" class="form-control" placeholder="Quantity / Pack" value="{{ old('quantity_pack', $row->quantity_pack) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="wip_bin" class="col-form-label required">WIP Bin :</label>
                                    <select name="c" id="wip_bin" value="{{ old('wip_bin', $row->wip_bin) }}" class="form-control m_selectpicker">
                                        <option value="">Select Wip Bin</option>
                                        {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'wip_bin'), old('wip_bin', $row->wip_bin)) !!}
                                    </select>                                
                                 </div>
                                
                                <div class="col-lg-6">
                                    <label for="store" class="col-form-label required">Store:</label>
                                    <input type="text" name="store" id="store" class="form-control" placeholder="Store" value="{{ old('store', $row->store) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="storage_level-1" class="col-form-label required">Storage Level 1:</label>
                                    <input type="text" name="storage_level-1" id="storage_level-1" class="form-control" placeholder="Storage Level 1" value="{{ old('storage_level_1', $row->storage_level_1) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="storage_level-2" class="col-form-label required">Storage Level 2:</label>
                                    <input type="text" name="storage_level-2" id="storage_level-2" class="form-control" placeholder="Storage Level 2" value="{{ old('storage_level_2', $row->storage_level_2) }}"/>
                                </div>
                                <div class="col-lg-6">
                                    <label for="exclusive_location" class="col-form-label required">Exclusive Location:</label>
                                    <select name="exclusive_location" id="exclusive_location" value="{{ old('exclusive_location', $row->exclusive_location) }}" class="form-control m_selectpicker">
                                        <option value="">Select Exclusive Location</option>
                                        {!! selectBox(DB_enumValues('semi_finished_product_profiles', 'exclusive_location'), old('exclusive_location', $row->exclusive_location)) !!}
                                    </select>                                
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
