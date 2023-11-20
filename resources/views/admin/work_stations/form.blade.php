
text/x-generic form.blade.php ( HTML document, ASCII text, with very long lines )
@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
 <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="work_stations">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
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
                                <div class="mb-2 col-lg-5">
                                    <div class="">
                                        <label for="id" class="col-form-label">{{ __('WorkStation') }}:</label><br>
                                        @php
                                            $ids = json_decode($row->id);
                                        @endphp
                                        <select class="form-control m-select2 w-100" name="id[]" multiple="multiple" style="width: 100%">
                                            <option value="">Select ID</option>
                                            {!! selectBox("SELECT id, name FROM work_stations", old('id', $work_stations)) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 col-lg-5">
                                    <div class="">
                                        <label for="id" class="col-form-label">{{ __('Work Station') }}:</label>
                                        <select class="form-control m-select2 w-100" name="id[]" multiple="multiple">
                                            <option value="">Select Leave</option>
                                            {!! selectBox("SELECT id, name FROM work_stations", old('id', $work_stations)) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="clone_container">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $ids = json_decode($row->id ?? "[{}]" );
                                    $names = json_decode($row->name ?? "[{}]");
                                    $codes = json_decode($row->code);
                                   
                                @endphp

                                @foreach($codes as $index => $code)
                                <div class="clone">
                                    <div class="form-group row justify-content-center">
                                        <div class="col-lg-3">
                                            <label for="id" class="col-form-label required">{{ __('Work Station') }}:</label><br>
                                            <select name="id[]" id="id" class="form-control id -m-select2" style="width: 100%">
                                                {!! selectBox("SELECT id, name, type FROM work_stations ", old('id', $row->id), '<option {selected} value="{id}" data-type="{type}">{name} ({type})</option>') !!}
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="work_station_name" class="col-form-label">{{ __('Work Station Name') }}:</label>
                                            <div class="input-group">
                                                <input type="text" name="name[]" id="name" class="form-control work_station_name" placeholder="{{ __('Work Station Name') }}" value="{{ old('name.' . $index, $names[$index]) }}" />
                                                <span class="input-group-text" id="basic-addon1"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="work_station_code" class="col-form-label">{{ __('Work Station Code') }}:</label>
                                            <div class="input-group">
                                                <input type="text" name="code[]" id="code" class="form-control work_station_code" placeholder="{{ __('Work Station Code') }}" value="{{ old('code.' . $index, $codes[$index]) }}" />
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                      
                                        <div class="col-lg-2">
                                            <label class="col-form-label">&nbsp;</label><br>
                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                </div>
                                @endforeach
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

        // var $oneTimeCostField = $('.employee_contribution');
        // var $recurringTotalCostField = $('.employers_contribution');
        // var $totalRetailAmountField = $('.total');

        // function calcVal() {
        //   var num1 = $oneTimeCostField.val();
        //   var num2 = $recurringTotalCostField.val();
        //   var result = parseInt(num1) + parseInt(num2);
        //   if (!isNaN(result)) {
        //     $totalRetailAmountField.val(result);
        //   }
        // }

        // $($recurringTotalCostField,$oneTimeCostField).on("keydown keyup", function() {

        //   calcVal();
        // });


        function calcVal($container) {
            var total = 0;

            // Find input fields within the specified container
            var $name = $container.find('.name');
            var $code = $container.find('.code');
            var $totalField = $container.find('.total');

            // Calculate the total for the set
            var num1 = $name.val() || 0;
            var num2 = $code.val() || 0;
            var result = parseInt(num1) + parseInt(num2);

            // Update the total field
            if (!isNaN(result)) {
                $totalField.val(result);
            }

            // Update the total for all sets
            $('.total').each(function () {
                total += parseInt($(this).val()) || 0;
            });

            // Update the global total field outside the loop
            $('.work_station-total').val(total);
        }

        // Event handler for the input fields
        $(document).on("keydown keyup", '.name, .code', function () {
            // Find the closest container (row) and calculate the total for that row
            calcVal($(this).closest('.form-group'));
        });

        // Function to update the grand total
        function updateWorkStationTotal() {
            var WorkStationTotal = 0;

            // Update the grand total for all rows
            $('.total').each(function () {
                work_stationTotal += parseInt($(this).val()) || 0;
            });

            // Update the global grand total field
            $('. work_station-total').val( work_stationTotal);
        }


        $("#basic-addon1, #basic-addon2, #basic-addon3").hide();

        // Event handler for the dropdown change
        $(document).on('change', '. work_station_id', function () {
            const selectedOption = $(':selected', this);
            const data = selectedOption.data();
            const container = $(this).closest('.form-group');

            // Hide or show based on the selected option's type
            if (data.type === 'Fixed') {
                container.find("#basic-addon1, #basic-addon2, #basic-addon3").hide();
            } else {
                container.find("#basic-addon1, #basic-addon2, #basic-addon3").show();
            }
        });


        $("form# work_stations").validate({
            // define validation rules
            rules: {
                 work_station_id: {
                    required: true,
                },
                 name: {
                    required: true,
                },
                 code: {
                    required: true,
                },

            },
            /*messages: {
        'name' : {required: 'Name is required',},'salary_range_from' : {required: 'Salary Range From is required',},'salary_range_to' : {required: 'Salary Range To is required',},'allowance_id' : {required: 'Allowance ID is required',},    },*/
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