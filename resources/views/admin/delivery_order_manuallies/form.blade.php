@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="delivery_order_manuallies">
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
                             <div class="form-group row mb-3 clone">
                                <div class="col-lg-6">
                                    <label for="oem_id" class="col-form-label text-right">{{ __(' Oem') }}:</label>
                                    <select name="oem_id[]" id="oem_id" class="form-control m-select2">
                                        <option value="">Select Oems</option>
                                        {!! selectBox("SELECT id,title FROM oems", old('oem_id', $row->oem_id)) !!}
                                    </select>
                                </div>
                               
                                <div class="col-lg-6">
                                    <label for="date" class="col-form-label required">{{ __('Date') }}:</label>
                                    <input type="date" name="date[]" id="date" class="form-control datepicker" placeholder="{{ __('Date') }}" value="{{ old('date', $row->date) }}" />
                                </div>
                                 <div class="col-lg-6">
                                    <label for="oem_code" class="col-form-label required">{{ __('Oem Code') }}:</label>
                                    <input type="text" name="oem_code[]" id="oem_code" class="form-control codepicker" placeholder="{{ __('CODE FORMAT: AB-1234') }}" value="{{ old('oem_code', $row->oem_code) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="product" class="col-form-label required">{{ __('Product') }}:</label>
                                    <select name="product_id[]" id="product_id" class="form-control m-select2">
                                        <option value="">Select product</option>
                                        {!! selectBox("SELECT id, product_name FROM finished_product_profiles", old('product_id', $row->product_id)) !!}
                                    </select>  
                                </div>
                                <div class="col-lg-6">
                                    <label for="di_no" class="col-form-label required">{{ __('DI No') }}:</label>
                                    <input type="no" name="di_no[]" id="di_no" class="form-control nopicker" placeholder="{{ __('DI No') }}" value="{{ old('di_no', $row->di_no) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="quantity" class="col-form-label required">{{ __('Quantity') }}:</label>
                                    <input type="number" name="quantity[]" id="quantity" class="form-control nopicker" placeholder="{{ __('Quantity') }}" value="{{ old('quantity', $row->quantity) }}" />
                                </div>
                                @if(empty($row->id))
                                <div class="col-lg-6" style="margin-top: 35px;">
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
@endsection {{-- Scripts --}}
@section('scripts')
    <script>
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'sub_delivery_order_manuallies[]');
        }

        $("form#delivery_order_manuallies").validate({
            // define validation rules
            rules: {
                title: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},    },*/
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