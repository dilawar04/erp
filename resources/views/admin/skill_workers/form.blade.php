@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="skill_worker">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" id="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div> 
                        <div class="kt-portlet__body body_overtime" id="showovertime">
                            <div class="clone_container">
                                <div class="from-group row mb-3 clone border p-3 bg-light">
                                    <div class="col-lg-10">
                                        <label for="name" class="col-form-label">{{ __('Skill Worker Name') }}:</label>
                                        <input type="text" name="name[]" class="form-control name" placeholder="{{ __('Skill Worker Name') }}" value="{{ old('name', $row->name) }}" required/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="Workstation" class="col-form-label required">{{ __('Workstation') }}:</label>
                                        <select name="workstation_id[]" id="workstation" class="form-control -m-select2 w-100 workstation-selector" required>
                                            <option value="" selected>-- Select --</option>
                                            {!! selectBox("SELECT id, name FROM work_stations", old('workstation_id', $row->workstation_id)) !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="operation" class="col-form-label required">{{ __('Operation') }}:</label>
                                        <!-- <select name="operation_id[]" id="operation_id" class="form-control m-select2">
                                            {!! selectBox("SELECT id, name FROM workstation_operations", old('operation_id', $row->operation_id)) !!}
                                        </select> -->
                                        <select id="operation_id" name="operation_id[]" class="form-control -m-select2 w-100 operation-selector" required>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="operation_weightage" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Operation Weightage') }}:</label>
                                        <select class="form-control -m-select2 w-100" name="operation_weightage[]" required>
                                            <option value="" selected>-- Select --</option>
                                            @php
                                                $_Weightage = [
                                                        '1-Helper Work', 
                                                        '2- Low Skill Manual Work', 
                                                        '3- Low Skill Machine Work', 
                                                        '4- High Skill Manual Work',
                                                        '5- High Skill Machine Work'
                                                    ];
                                            @endphp
                                            {!! selectBox(array_combine($_Weightage, $_Weightage), $row->operation_weightage) !!}
                                        </select>
                                    </div>   
                                    @if(empty($row->id))
                                    <div style="margin-top: 36px;">
                                        <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container" callback="add_more_cb_overtime"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                    </div>
                                    @endif
                                </div>
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
        // Function to fetch operations based on selected workstation
        window.addEventListener("load", (event) => {
            function fetchOperations(workstationId, operationIdElement) {
                $.ajax({
                    url: "{{ url('admin/skill_workers/form') }}",
                    type: "POST",
                    data: {
                        workstation_id: workstationId,
                        type: 'workstation',
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        var savedOperationId = "{{ $row->operation_id }}"; // Get the saved operation ID
                        operationIdElement.html('<option value="">-- Select Operation --</option>');
                        $.each(result.workstation, function (key, value) {
                            var selected = (value.id == savedOperationId) ? 'selected' : '';
                            operationIdElement.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });


                    }
                });
            }

            // Function to bind change event handler for workstation dropdown
            function bindWorkstationChangeHandler() {
                $(document).on('change', '.workstation-selector', function () {
                    var workstationId = $(this).val();
                    var operationIdElement = $(this).closest('.clone').find('.operation-selector');

                    if (workstationId !== '') {
                        fetchOperations(workstationId, operationIdElement);
                    } else {
                        operationIdElement.html('<option value="">-- Select Operation --</option>');
                    }
                });
                $('#workstation').trigger('change');
            }

            // Document ready function
            $(document).ready(function () {
                // Initial binding of change handler
                bindWorkstationChangeHandler();

                // Function to add a new clone
                $('#add-clone-button').on('click', function () {
                    var cloneContainer = $('.clone_container');
                    var clone = cloneContainer.find('.clone').first().clone();

                    // Clear selected values and re-bind change handler for the new clone
                    clone.find('select').val('');
                    clone.find('.operation-selector').html('<option value="">-- Select Operation --</option>');

                    // Append the cloned element to the container
                    cloneContainer.append(clone);

                    // Re-bind the change handler for the new cloned elements
                    bindWorkstationChangeHandler();
                });

            });
        });
        $("form#skill_worker").validate({
            // define validation rules
            rules: {
                'name': {
                    required: true,
                },
                'workstation_id': {
                    required: true,
                },
                'operation_id': {
                    required: true,
                },
                'operation_weightage': {
                    required: true,
                },
            },
            /*messages: {
            'title' : {required: 'Title is required',},'identifier' : {required: 'Identifier is required',},    },*/
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
