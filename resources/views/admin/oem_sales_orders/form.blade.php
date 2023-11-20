@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
<style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="sales_order">
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
                            <div class="clone_container">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $pos = json_decode($row->po ?? "[{}]" );
                                    $products = json_decode($row->finished_product_id);
                                    $froms = json_decode($row->from);
                                    $tills = json_decode($row->till);
                                    $p_froms = json_decode($row->p_from);
                                    $p_tills = json_decode($row->p_till);
                                @endphp
                                @foreach($pos as $index => $po)
                                <div class="from-group row mb-3 clone">
                                    <div class="col-lg-3">
                                        <label for="PO" class="col-form-label required">{{ __('PO#/LOI#') }}:</label>
                                        <input type="text" name="po[]" id="po" class="form-control" placeholder="{{ __('PO#/LOI#') }}" value="{{ old('po.' . $index, $po) }}" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="finished_product_id" class="col-form-label required">{{ __('Product') }}:</label>
                                        <select class="form-control m-select2 w-100" name="finished_product_id[{{ $index }}][]">
                                            <option value="">-- Select Product --</option>
                                            {!! selectBox("SELECT id, product_name FROM finished_product_profiles", old('finished_product_id', $products[$index])) !!}
                                        </select>
                                        <!--<input type="text" name="finished_product_id[]" id="finished_product_id" class="form-control" placeholder="{{ __('Product Name') }}" value="{{ old('b_from.' . $index, $products[$index]) }}" />-->
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="from" class="col-form-label required">{{ __('From') }}:</label>
                                        <input type="time" name="from[]" id="from" class="form-control" placeholder="{{ __('From') }}" value="{{ old('b_from.' . $index, $froms[$index]) }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="till" class="col-form-label required">{{ __('Till') }}:</label>
                                        <input type="time" name="till[]" id="till" class="form-control" placeholder="{{ __('Till') }}" value="{{ old('b_from.' . $index, $tills[$index]) }}" />
                                    </div>
                                    <div style="margin-top: 36px;">
                                        <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                    </div>
                                </div>  
                                @endforeach
                            </div>
                            
                            
                                <div class="from-group row mb-3 clone">
                                    <div class="col-lg-4">
                                        <label for="from" class="col-form-label required">{{ __('File Upload') }}:</label>
                                        <input class="form-control" type="file" id="formFile" name="file" value="{{ old('file.' . $row->file) }}">
                                        <span class="form-text text-muted">"pdf, xls, xlsx, doc, docx" file extension's</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="from" class="col-form-label required">{{ __('From') }}:</label>
                                        <input type="time" name="p_from[]" id="p-from" class="form-control" placeholder="{{ __('From') }}" value="{{ old('p_from.' . $index, $p_froms[$index]) }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="till" class="col-form-label required">{{ __('Till') }}:</label>
                                        <input type="time" name="p_till[]" id="p-till" class="form-control" placeholder="{{ __('Till') }}" value="{{ old('p_till.' . $index, $p_tills[$index]) }}" />
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
        function add_more_cb(clone, clone_container){
            const index = clone_container.find('.clone').length - 1;
            $('select[multiple]', clone).attr('name', 'finished_product_id['+ index +'][]');

            $('.select2-container', clone).remove();
            $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
            $('.m-select2', clone).select2();
        }
        $("form#sales_order").validate({
            // define validation rules
            rules: {
                po: {
                    required: true,
                },
                from: {
                    required: true,
                },
                till: {
                    required: true,
                },
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
