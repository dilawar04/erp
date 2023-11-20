@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <style>
    .delete-entity{
        position: absolute;
        top: 37px;
        right: 0px;
    }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="supply-settup">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
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
                                <div class="col-lg-3">
                                    <label for="have-dalivery-station" class="col-form-label required">{{ __('Have Delivery Station') }}:</label>
                                    <select class="m-select2 w-100 multiple-form" name="have_delivery_station">
                            	        <option value="" selected>-- Select --</option>
                                        {!! selectBox(DB_enumValues('supply_setups', 'have_delivery_station'), old('have_delivery_station', $row->have_delivery_station)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="no_line" class="col-form-label">{{ __('No of Station') }}:</label>
                                    <input type="number" name="no_of_station" id="no_of_station" class="no_of_station form-control" placeholder="{{ __('No Of Station') }}" value="{{ old('no_of_station', $row->no_of_station ?? 1) }}" />
                                </div>
                                <div class="col-lg-3" style="margin-top:37px;">
                                    <button type="button" class="btn btn-success add-more" id="btnSubmit"><i class="la la-plus"></i>Add More</button
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            <div class="main-production-block col-lg-12">
                                <h5 class="kt-portlet__head-title">Stations</h5>
                                 @php
                                    // Decode the JSON string into a PHP array
                                    $station_names = json_decode($row->station_name ?? "[{}]" );
                                    $station_codes = json_decode($row->station_code);
                                    $i = 0;
                                @endphp
                                @foreach($station_names as $index => $station_name)
                                    <?php $i++ ?>
                                    <div class="production-block -border -p-3 mb-2" data-id="<?php if($i !== 1){ echo $i;} else{ echo '1' ;} ?>">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <div class="operation-block mb-2">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Station Name</th>
                                                        <th>Code</th>
                                                    </tr>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center"><span class="sn"><?php if($i){echo $i;}else{ echo 1 ;} ?></span></td>
                                                        <td><input type="text" name="station_name[]" id="station_name" class="station_name form-control" placeholder="{{ __('Station Name') }}"  value="{{ old('station_name.' . $index, $station_name) }}" /></td>
                                                        <td><input type="text" name="station_code[]" id="station_code" class="station_code form-control" placeholder="{{ __('Station Code') }}" value="{{ old('station_code.' . $index, $station_codes[$index]) }}" /></td>
                                                        <td><button type="button" class="btn btn-danger delete-btn"><i class="la la-minus"></i>Delete</button></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="follow-loading-sequence" class="col-form-label required">{{ __('Follow Loading Sequence') }}:</label>
                                <select class="m-select2 w-100 multiple-form" name="follow_loading_sequence">
                        	        <option value="" selected>-- Select --</option>
                                    {!! selectBox(DB_enumValues('supply_setups', 'follow_loading_sequence'), old('follow_loading_sequence', $row->follow_loading_sequence)) !!}
                                </select>
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="group-delivery-challan-by" class="col-form-label required">{{ __('Group Delivery Challan By') }}:</label>
                                <select class="m-select2 w-100 multiple-form" name="group_delivery_challan_by">
                        	        <option value="" selected>-- Select --</option>
                                    {!! selectBox(DB_enumValues('supply_setups', 'group_delivery_challan_by'), old('group_delivery_challan_by', $row->group_delivery_challan_by)) !!}
                                </select>
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="enable-cycle_time" class="col-form-label required">{{ __('Enable Cycle Time') }}:</label>
                                <select class="m-select2 w-100 multiple-form" name="enable_cycle_time">
                        	        <option value="" selected>-- Select --</option>
                                    {!! selectBox(DB_enumValues('supply_setups', 'enable_cycle_time'), old('enable_cycle_time', $row->enable_cycle_time)) !!}
                                </select>
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="enable-product-barcode" class="col-form-label required">{{ __('Enable Product Barcode') }}:</label>
                                <select class="m-select2 w-100 multiple-form" name="enable_product_barcode">
                        	        <option value="" selected>-- Select --</option>
                                    {!! selectBox(DB_enumValues('supply_setups', 'enable_product_barcode'), old('enable_product_barcode', $row->enable_product_barcode)) !!}
                                </select>
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="restrict-no-of-products-on-delivery-challann" class="col-form-label required">{{ __('Restrict No Of Products On Delivery Challan') }}:</label>
                                <select class="m-select2 w-100 multiple-form" name="restrict_no_of_products_on_delivery_challan">
                        	        <option value="" selected>-- Select --</option>
                                    {!! selectBox(DB_enumValues('supply_setups', 'restrict_no_of_products_on_delivery_challan'), old('restrict_no_of_products_on_delivery_challan', $row->restrict_no_of_products_on_delivery_challan)) !!}
                                </select>
                            </div>
                            
                            <div class="col-lg-4">
                                <label for="no-of-products-per-delivery-challan" class="col-form-label required">{{ __('No Of Products Per Delivery Challan') }}:</label>
                                <input type="text" name="no_of_products_per_delivery_challan" id="no_of_products_per_delivery_challan" class="form-control" placeholder="{{ __('No Of Products Per Delivery Challan') }}" value="{{ old('no_of_products_per_delivery_challan.' .$row->no_of_products_per_delivery_challan) }}" />
                            </div>
                        </div>
                            
                             <div class="clone_container_cycle">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $cycle_nos = json_decode($row->cycle_no ?? "[{}]");
                                    $cycle_times = json_decode($row->cycle_time);
                                    
                                @endphp

                                @foreach($cycle_nos as $index => $cycle_no)
                                    <div class="from-group row mb-3 clone">
                                        <select class="d-none" name="type[]">
                                    	    <option value="overtime" selected>overtime</option>
                                        </select>
                                        <div class="col-lg-5">
                                            <label for="cycle_no" class="col-form-label required">{{ __('Cycle No') }}:</label>
                                            <input type="text" name="cycle_no[]" class="form-control" placeholder="{{ __('Cycle No') }}" value="{{ old('cycle_no.' . $index, $cycle_no) }}" />
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="cycle_time" class="col-form-label">{{ __('Cycle Time') }}:</label>
                                            <input type="text" name="cycle_time[]" class="form-control" placeholder="{{ __('Cycle Time') }}" value="{{ old('cycle_time.' . $index, $cycle_times[$index]) }}" />
                                        </div>
                                        <div style="margin-top: 36px;">
                                            <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container_cycle" callback="add_more_cb_cycle"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container_cycle-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                             </div>
                            
                            <div class="from-group row mb-3">
                               <div class="col-lg-4">
                                    <label for="enable-product-barcode" class="col-form-label required">{{ __('Select Entities') }}:</label>
                                    <select class="m-select2 w-100 multiple-form" name="select_entities" id="select-entities">
                                        <option value="" selected>-- Select --</option>
                                        <option value="Delivery Challan No">Delivery Challan No</option>
                                        <option value="Delivery Challan Date">Delivery Challan Date</option>
                                        <option value="Purchase Order No">Purchase Order No</option>
                                        <option value="Purchase Order Date">Purchase Order Date</option>
                                        <option value="Part Name">Part Name</option>
                                        <option value="Part No">Part No</option>
                                        <option value="Supply Qty">Supply Qty</option>
                                        <option value="Model Name">Model Name</option>
                                        <option value="Model No">Model No</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4" style="margin-top:37px;">
                                    <button type="button" class="btn btn-success add-more-entity" clone-container=".clone_container_entity" callback="add_more_cb_entity"><i class="la la-plus"></i>Add more</button>
                                </div>
                                
                                <div class="col-lg-5 clone_container_entity" style="display: contents;">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $entity_names = json_decode($row->entity_name );
                                    $i = 1;
                                @endphp

                                @foreach($entity_names as $index => $entity_names)
                                    <div class="col-lg-6">
                                        <label for="entity_name" class="col-form-label">Entity No:<?php echo $i++; ?></label>
                                        <input type="text" name="entity_name[]" class="form-control" placeholder="entity_name"  value="{{ old('entity_name.' . $index, $entity_names) }}" readonly="">
                                        <button type="button" class="btn btn-danger delete-entity"><i class="la la-trash"></i>Delete</button>
                                    </div>
                                @endforeach
                                
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="alert alert-danger duplicate-error" style="display: none;">This entity already exists.</div>
                                </div>
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
        $(document).ready(function () {
            let addedValues = [];
        
            function updateColumnNumbers() {
                // Get all label elements for entity names
                const labelElements = $(".clone_container_entity .col-lg-6 label[for='entity_name']");
        
                // Update the label text with new numbers
                labelElements.each(function (index, element) {
                    $(element).text(`Entity No: ${index + 1}`);
                });
            }
        
            function addNewColumn(selectedValue) {
                if (selectedValue && !addedValues.includes(selectedValue)) {
                    const fieldCounter = addedValues.length; // Get the actual number of columns
                    const inputField = `
                        <div class="col-lg-6">
                            <label for="entity_name" class="col-form-label">Entity No: ${fieldCounter + 1}</label>
                            <input type="text" name="entity_name[]" class="form-control" placeholder="{{ __('entity_name') }}" value="${selectedValue}" readonly/>
                            <button type="button" class="btn btn-danger delete-entity"><i class="la la-trash"></i>Delete</button>
                        </div>
                    `;
        
                    $(".clone_container_entity").append(inputField);
                    addedValues.push(selectedValue);
                    $(".duplicate-error").hide();
        
                    updateColumnNumbers(); // Update column numbers
                } else if (selectedValue) {
                    $(".duplicate-error").show();
                }
            }
        
            $(".add-more-entity").click(function () {
                const selectedValue = $("#select-entities").val();
                addNewColumn(selectedValue);
            });
        
            $(".clone_container_entity").on("click", ".delete-entity", function () {
                const inputField = $(this).closest(".col-lg-6");
                const valueToDelete = inputField.find("input").val();
        
                inputField.remove();
        
                // Remove the deleted value from the list
                addedValues = addedValues.filter(value => value !== valueToDelete);
        
                updateColumnNumbers(); // Update column numbers after deletion
        
                $(".duplicate-error").hide();
            });
        
            // Populate addedValues with existing values when the page loads
            $(".clone_container_entity .col-lg-6 input").each(function () {
                addedValues.push($(this).val());
            });
        });

        //     $('[data-id="0"]').each(function () {
        //     $(this).find('.delete-btn').hide();
        // }); 
        function add_more_cb_cycle(clone, clone_container_cycle){ 
            const index = clone_container.find('.clone').length - 1;
            // $('select[multiple]', clone).attr('name', 'days['+ index +'][]');

            // $('.select2-container', clone).remove();
            // $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
            // $('.m-select2', clone).select2();
        }

        $("#btnSubmit").click(function () {
            const num = parseInt($('.no_of_station').val());
            const exist_block = $('.production-block').length;
        
            if (exist_block > num) {
                $('.production-block:gt(' + (num - 1) + ')').remove();
            }
        
            for (let i = exist_block; i < num; i++) {
                let last_el = $('.production-block').eq(0).clone(true);
                last_el.appendTo('.main-production-block');
                last_el.find('span.sn').html(i + 1);
                last_el.attr('data-id', i);
                last_el.find('input').val();
                last_el.find('select:gt(0)').remove();

                last_el.find('.delete-btn').click(function () {
                    const dataId = $(this).closest('.production-block').attr('data-id');
                    if (dataId !== "0") {
                        $(this).closest('.production-block').remove();
                    }
                });
            }
        }); 
        
        
        $('.delete-btn').click(function () {
            const dataId = $(this).closest('.production-block').attr('data-id');
            if (dataId !== "1" && $(this).closest('.production-block')) {
                $(this).closest('.production-block').remove();
            }
        });
       

        $("form#supply-settup").validate({
            // define validation rules
            rules: {
                have_delivery_station: {
                    required: true,
                },
                no_of_station: {
                    required: true,
                },
                station_name: {
                    required: true,
                },
                station_code: {
                    required: true,
                },
            },
            /*messages: {
        'name' : {required: 'Name is required',},'code' : {required: 'Code is required',},'category_id' : {required: 'Category ID is required',},'no_of_worker' : {required: 'No Of Worker is required',},    },*/
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
