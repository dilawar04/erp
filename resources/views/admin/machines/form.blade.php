@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="machines">
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
                                <div class="col-lg-3">
                                    <label for="name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="code" class="col-form-label">{{ __('Code') }}:</label> <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('Code') }}" value="{{ old('code', $row->code) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="serial_no" class="col-form-label">{{ __('Serial No') }}:</label>
                                    <input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="{{ __('Serial No') }}" value="{{ old('serial_no', $row->serial_no) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="make" class="col-form-label">{{ __('Make') }}:</label>
                                    <input type="text" name="make" id="make" class="form-control" placeholder="{{ __('Make') }}" value="{{ old('make', $row->make) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="model" class="col-form-label">{{ __('Model') }}:</label> 
                                    <input type="text" name="model" id="model" class="form-control" placeholder="{{ __('Model') }}" value="{{ old('model', $row->model) }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label for="year" class="col-form-label">{{ __('Year') }}:</label> 
                                    <input type="text" name="year" id="year" class="form-control yearpicker" placeholder="{{ __('Year') }}" value="{{ old('year', $row->year) }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label for="purchase_date" class="col-form-label">{{ __('Purchase Date') }}:</label>
                                    <input type="text" name="purchase_date" id="purchase_date" class="form-control datepicker" placeholder="{{ __('Purchase Date') }}" value="{{ old('purchase_date', $row->purchase_date) }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label for="installation_date" class="col-form-label">{{ __('Installation Date') }}:</label>
                                    <input type="text" name="installation_date" id="installation_date" class="form-control datepicker" placeholder="{{ __('Installation Date') }}" value="{{ old('installation_date', $row->installation_date) }}"/>
                                </div>
                                 <div class="col-lg-4">
                                    <label for="workstation_id" class="col-form-label">{{ __('Workstation') }}:</label>
                                    <select name="workstation_id" id="workstation_id" class="form-control m-select2">
                                        <option value="{{old('workstation_id', $row->workstation_id)}}">Select Workstation</option>
                                        {!! selectBox("SELECT id, name FROM workstations", old('workstation_id', $row->workstation_id)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label for="warranty_type" class="col-form-label">{{ __('Warranty Period') }}:</label>
                                    <input type="text" name="warranty_type" id="warranty_type datepicker" class="form-control datepicker" placeholder="{{ __('Warranty Type') }}" value="{{ old('warranty_type', $row->warranty_type) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="warranty_expiry" class="col-form-label">{{ __('Warranty Expiry') }}:</label>
                                    <input type="text" name="warranty_expiry" id="warranty_expiry" class="form-control datepicker" placeholder="{{ __('Warranty Expiry') }}" value="{{ old('warranty_expiry', $row->warranty_expiry) }}" />
                                </div>

                                 <div class="col-lg-3">
                                    <label for="warranty_status" class="col-form-label">{{ __('Warranty Status') }}:</label>
                                    <input type="text" name="warranty_status" id="warranty_status" class="form-control datepicker" placeholder="{{ __('Warranty Status') }}" value="{{ old('warranty_status', $row->warranty_status) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="energy_consumption" class="col-form-label">{{ __('Energy Consumption / KWh') }}:</label>
                                    <input type="text" name="energy_consumption" id="energy_consumption" class="form-control" placeholder="{{ __('Energy Consumption') }}" value="{{ old('energy_consumption', $row->energy_consumption) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="machine_status" class="col-form-label">{{ __(' Machine Status') }}:</label>
                                        <select name="machine_status" id="machine_status" class="form-control m-select2">
                                        <option value="{{old('machine_status', $row->machine_status)}}">Select Workstation</option>
                                        {!! selectBox(DB_enumValues('machines', 'machine_status'), old('machine_status', $row->machine_status)) !!}
                                    </select>                                
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
        $("form#machines").validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
            },
            /*messages: {
        'name' : {required: 'Name is required',},    },*/
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
