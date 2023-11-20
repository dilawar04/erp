@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
 <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="grades">
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
                                        <label for="leaves_id" class="col-form-label">{{ __('Grade') }}:</label><br>
                                        @php
                                            $grades = json_decode($row->grade_id);
                                            $leaves = json_decode($row->leaves_id);
                                        @endphp
                                        <select class="form-control m-select2 w-100" name="grade_id[]" multiple="multiple" style="width: 100%">
                                            <option value="">Select Grade</option>
                                            {!! selectBox("SELECT id, name FROM grades", old('grade_id', $grades)) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 col-lg-5">
                                    <div class="">
                                        <label for="leaves_id" class="col-form-label">{{ __('Leave') }}:</label>
                                        <select class="form-control m-select2 w-100" name="leaves_id[]" multiple="multiple">
                                            <option value="">Select Leave</option>
                                            {!! selectBox("SELECT id, name FROM leaves", old('leaves_id', $leaves)) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="clone_container">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $allowance_ids = json_decode($row->allowance_id ?? "[{}]" );
                                    $employee_contributions = json_decode($row->employee_contribution ?? "[{}]");
                                    $employers_contributions = json_decode($row->employers_contribution);
                                    $totals = json_decode($row->total);
                                @endphp

                                @foreach($employee_contributions as $index => $employee_contribution)
                                <div class="clone">
                                    <div class="form-group row justify-content-center">
                                        <div class="col-lg-4">
                                            <label for="allowance_id" class="col-form-label required">{{ __('Allowance') }}:</label><br>
                                            <select name="allowance_id[]" id="allowance_id" class="form-control allowance_id -m-select2" style="width: 100%">
                                                {!! selectBox("SELECT id, name, type FROM allowance_benefits ", old('allowance_id', $row->allowance_id), '<option {selected} value="{id}" data-type="{type}">{name} ({type})</option>') !!}
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="employee_contribution" class="col-form-label">{{ __('Employee Contribution') }}:</label>
                                            <div class="input-group">
                                                <input type="number" name="employee_contribution[]" id="employee_contribution" class="form-control employee_contribution" placeholder="{{ __('Employee Contribution') }}" value="{{ old('employee_contribution.' . $index, $employee_contributions[$index]) }}" />
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="employers_contribution" class="col-form-label">{{ __('Employers Contribution') }}:</label>
                                            <div class="input-group">
                                                <input type="number" name="employers_contribution[]" id="employers_contribution" class="form-control employers_contribution" placeholder="{{ __('Employers Contribution') }}" value="{{ old('employers_contribution.' . $index, $employers_contributions[$index]) }}" />
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="total" class="col-form-label">{{ __('Total') }}:<span style="padding-right:110px;"> &nbsp;</span></label>
                                            <div class="input-group">
                                                <input type="number" name="total[]" id="total" class="form-control total" placeholder="{{ __('Total') }}" value="{{ old('total.' . $index, $totals[$index]) }}" />
                                                <span class="input-group-text" id="basic-addon3">%</span>
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
            var $employeeContribution = $container.find('.employee_contribution');
            var $employersContribution = $container.find('.employers_contribution');
            var $totalField = $container.find('.total');

            // Calculate the total for the set
            var num1 = $employeeContribution.val() || 0;
            var num2 = $employersContribution.val() || 0;
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
            $('.grand-total').val(total);
        }

        // Event handler for the input fields
        $(document).on("keydown keyup", '.employee_contribution, .employers_contribution', function () {
            // Find the closest container (row) and calculate the total for that row
            calcVal($(this).closest('.form-group'));
        });

        // Function to update the grand total
        function updateGrandTotal() {
            var grandTotal = 0;

            // Update the grand total for all rows
            $('.total').each(function () {
                grandTotal += parseInt($(this).val()) || 0;
            });

            // Update the global grand total field
            $('.grand-total').val(grandTotal);
        }


        $("#basic-addon1, #basic-addon2, #basic-addon3").hide();

        // Event handler for the dropdown change
        $(document).on('change', '.allowance_id', function () {
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


        $("form#grades").validate({
            // define validation rules
            rules: {
                allowance_id: {
                    required: true,
                },
                employee_contribution: {
                    required: true,
                },
                employers_contribution: {
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
