@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="machine_maintanence">
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
                                <div class="col-lg-4">
                                    <label for="maintanence_source" class="col-form-label">{{ __('Maintenance Source') }}:</label>
                                        <select name="maintanence_source" id="maintanence_source" class="form-control m-select2">
                                        <option value="{{old('maintanence_source', $row->maintanence_source	)}}">Select Maintanence Source</option>
                                        {!! selectBox(DB_enumValues('machine_maintanence', 'maintanence_source'), old('maintanence_frequency', $row->maintanence_source)) !!}
                                    </select>                                                     
                                    </div>
                                <div class="col-lg-4">
                                    <label for="maintanence_frequency" class="col-form-label">{{ __('Maintenance Frequency') }}:</label>
                                        <select name="maintanence_frequency" id="maintanence_frequency" class="form-control m-select2">
                                        <option value="{{old('maintanence_frequency', $row->maintanence_frequency	)}}">Select Maintanence Frequency</option>
                                        {!! selectBox(DB_enumValues('machine_maintanence', 'maintanence_frequency'), old('maintanence_frequency', $row->maintanence_frequency)) !!}
                                    </select>                                         
                            </div>
                             <div class="col-lg-4">
                                    <label for="inspection_frequency" class="col-form-label">{{ __('Inspection Frequency') }}:</label>
                                        <select name="inspection_frequency" id="inspection_frequency" class="form-control m-select2">
                                        <option value="{{old('inspection_frequency', $row->inspection_frequency	)}}">Select Inspection Frequency</option>
                                        {!! selectBox(DB_enumValues('machine_maintanence', 'inspection_frequency'), old('inspection_frequency', $row->inspection_frequency)) !!}
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
        $("form#machine_maintenances").validate({
            // define validation rules
            rules: {
                machine_id: {
                    required: true,
                },
            },
            /*messages: {
        'machine_id' : {required: 'Machine is required',},    },*/
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
