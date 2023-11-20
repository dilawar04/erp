@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="quality_setups">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}">
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
                                    <label for="product_id" class="col-form-label">{{ __('Product') }}:</label>
                                    <select name="product_id" id="product_id" class="form-control m-select2">
                                        <option value="">Select Product</option>
                                        {{--{!! selectBox("SELECT id, name FROM products", old('product_id', $row->product_id)) !!}--}}
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="workstation_id" class="col-form-label">{{ __('Workstation') }}:</label>
                                    <select name="workstation_id" id="workstation_id" class="form-control m-select2">
                                        <option value="">Select Workstation</option>
                                        {!! selectBox("SELECT id, name FROM workstations", old('workstation_id', $row->workstation_id)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="operation_id" class="col-form-label">{{ __('Operation') }}:</label>
                                    <select name="operation_id" id="operation_id" class="form-control m-select2">
                                        <option value="">Select Operation</option>
                                        {{--{!! selectBox("SELECT id, name FROM operations", old('operation_id', $row->operation_id)) !!}--}}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="quality_defect_id" class="col-form-label">{{ __('Quality Defect') }}:</label>
                                    <select name="quality_defect_id" id="quality_defect_id" class="form-control m-select2">
                                        <option value="">Select Quality Defect</option>
                                        {!! selectBox("SELECT id, name FROM quality_defects", old('quality_defect_id', $row->quality_defect_id)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="material_id" class="col-form-label">{{ __('Material') }}:</label>
                                    <select name="material_id" id="material_id" class="form-control m-select2">
                                        <option value="">Select Material</option>
                                        {!! selectBox("SELECT id, name FROM raw_material_categories", old('material_id', $row->material_id)) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        </div>

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php
                                    $Form_btn = new Form_btn();
                                    echo $Form_btn->buttons($form_buttons);
                                @endphp
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection

{{-- Scripts --}}
@section('scripts')
    <script>

        $("form#quality_setups").validate({
            // define validation rules
            rules: {},
            /*messages: {
                },*/
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
