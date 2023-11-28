@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="raw_material_appearances">
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
                            <div class="form-group row mb-3 clone">
                                   <div class="col-lg-6">
                                    <label for="item" class="col-form-label required">Item:</label>
                                    <input type="text" name="item[]" id="item" class="form-control" placeholder="Item" value="{{ old('item', $row->item) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="criteria" class="col-form-label required">Criteria:</label>
                                    <input type="text" name="criteria[]" id="criteria" class="form-control" placeholder="Criteria" value="{{ old('criteria', $row->criteria) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="method" class="col-form-label required">Method:</label>
                                    <input type="text" name="method[]" id="method" class="form-control" placeholder="Method" value="{{ old('method', $row->method) }}" />
                                </div>
                            
                                <div class="col-lg-6">
                                    <label for="inspection_tool" class="col-form-label required">Inspection Tool:</label>
                                    <select name="inspection_tool[]" id="inspection_tool" class="form-control m-select2">
                                        {!! selectBox("SELECT id, name FROM inspection_methods", old('inspection_tool', $row->inspection_tool)) !!}
                                    </select>  
                                </div>

                                <div class="col-lg-6">
                                    <label for="sampling_criteria" class="col-form-label required">Sampling Criteria:</label>
                                    <select name="sampling_criteria[]" id="sampling_criteria" class="form-control">
                                        {!! selectBox(DB_enumValues('raw_material_appearances', 'sampling_criteria'), old('sampling_criteria', $row->sampling_criteria)) !!}
                                    </select>
                                </div>

                                <div class="col-lg-6">
                                    <label for="sample_size" class="col-form-label required">Sample Size:</label>
                                    <input type="text" name="sample_size[]" id="cnic" class="form-control" placeholder="Sample Size" value="{{ old('sample_size', $row->sample_size) }}" />
                                </div>
                                @if(empty($row->id))
                                <div class="col-lg-6" style="margin-top: 10px;">
                                    <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                </div>
                                @endif
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
        $("form#raw_material_appearances").validate({
            // define validation rules
            rules: {
                item: {
                    required: true,
                },
                criteria: {
                    required: true,
                },
                method: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'title is required',},'email' : {required: 'email is required',},'phone' : {required: 'phone is required',},    },*/
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
