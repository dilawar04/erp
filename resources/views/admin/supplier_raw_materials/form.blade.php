@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="workstation_operation">
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
                        <div class="kt-portlet__body body_overtime" id="showovertime">
                            <div class="clone_container">
                                <div class="from-group row mb-3 clone border p-3 bg-light">
                                    <div class="col-lg-6">
                                        <label for="supplier_id" class="col-form-label required">{{ __('Supplier') }}:</label>
                                        <select name="supplier_id[]" id="supplier_id" class="form-control m-select2">
                                            {!! selectBox("SELECT id, name FROM suppliers", old('supplier_id', $row->supplier_id)) !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="supplier_id" class="col-form-label required">{{ __('Material') }}:</label>
                                        <select name="material_id[]" id="material_id" class="form-control m-select2">
                                            {!! selectBox("SELECT id, name FROM raw_material_profiles", old('material_id', $row->material_id)) !!}
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="rate" class="col-form-label required">{{ __('Rate') }}:</label>
                                        <input type="number" name="rate[]" class="form-control rate" placeholder="{{ __('Rate') }}" value="{{ old('rate', $row->rate) }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="lead_time" class="col-form-label">{{ __('Lead Time') }}:</label>
                                        <input type="text" name="lead_time[]" class="form-control lead_time" placeholder="{{ __('Lead Time') }}" value="{{ old('lead_time', $row->lead_time) }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="moq" class="col-form-label">{{ __('Minimum Order Quantity') }}:</label>
                                        <input type="number" name="moq[]" class="form-control moq" placeholder="{{ __('Minimum Order Quantity') }}" value="{{ old('moq', $row->moq) }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="qty" class="col-form-label">{{ __('Quantity/PK') }}:</label>
                                        <input type="number" name="qty[]" class="form-control qty" placeholder="{{ __('Quantity/PK') }}" value="{{ old('moq', $row->moq) }}" />
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
        function add_more_cb(clone, clone_container){
            const index = clone_container.find('.clone').length - 1;
        }

        $("form#workstation_operation").validate({
            // define validation rules
            rules: {
                workstation_id: {
                    required: true,
                },
                code: {
                    required: true,
                },
                name: {
                    required: true,
                }
            },
            /*messages: {
        'shift_name' : {required: 'Shift Name is required',},'start_time' : {required: 'Start Time is required',},'end_time' : {required: 'End Time is required',},'brake_name' : {required: 'Braek Name is required',},    },*/
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
