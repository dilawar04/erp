@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="purchase_order_manualies">
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
                                    {{--<label for="sub_department_name" class="col-form-label">{{ __('Sub Department Name') }}:</label>
                                    <input type="text" name="sub_department_name" id="sub_department_name" class="form-control" placeholder="{{ __('Sub Department Name') }}" value="{{ old('sub_department_name', $row->sub_department_name) }}" />--}}
                                    <label for="parent_id" class="col-form-label text-right">{{ __('Parent Department') }}:</label>
                                    <select class="form-control kt-select2" name="parent_id" id="parent_id">
                                        <option value="0">- Select -</option>
                                        @php
                                            $_M = new Multilevel();
                                            $_M->type = 'select';
                                            $_M->id_Column = 'id';
                                            $_M->title_Column = 'title';
                                            $_M->link_Column = 'title';
                                            $_M->option_html = '<option {selected} value="{id}">{level}{title}</option>';
                                            $_M->level_spacing = 6;
                                            $_M->selected = old('parent_id', $row->parent_id);
                                            $_M->query = "SELECT * FROM `purchase_order_manualies` WHERE `status`='Active'";
                                            echo $_M->build();
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="date" class="col-form-label required">{{ __('Date') }}:</label>
                                    <input type="date" name="date" id="date" class="form-control datepicker" placeholder="{{ __('Date') }}" value="{{ old('date', $row->date) }}" />
                                </div>
                                 <div class="col-lg-6" style="margin-top: 35px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                    </div>
                                </div>
                                </div>
                                   <div class="col-lg-5">
                                            <div class="operation-block mb-1">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Material</th>
                                                        <th>Unit</th>
                                                        <th>Quantity Per Pack</th>
                                                        <th>MOQ</th>
                                                        <th>Rate</th>
                                                        <th>Order Quantity</th>
                                                        <th>Total Amount</th>
                                                        <th>Lead Time</th>
                                                        <th>Expected Delivery Date</th>
                                                        
                                                    </tr>
                                                    <tbody>
                                                    <tr>
                                                        <th class="materials">
                                                          <input type="text" name="material" id="material[]" class="form-control" style="width: 120px;" placeholder="{{ __('Material') }}" value="{{ old('material', $row->material) }}" />
                                                        </th>
                                                         <td class="unit-block">
                                                          <input type="text" name="unit" id="unit[]" class="form-control" style="width: 80px;" placeholder="{{ __('Unit') }}" value="{{ old('unit', $row->unit) }}" />
                                                        </td>
                                                         <td class="main-quantity_per_pack-block">
                                                          <input type="text" name="quantity_per_pack" id="quantity_per_pack[]" class="form-control" style="width: 80px;" placeholder="{{ __('Quantity Per Pack') }}" value="{{ old('quantity_per_pack', $row->quantity_per_pack) }}" />
                                                        </td>
                                                         <td class="main-moq-block">
                                                          <input type="text" name="moq" id="moqs[]" class="form-control" style="width: 80px;" placeholder="{{ __('MOQ') }}" value="{{ old('moq', $row->moq) }}" />
                                                        </td>
                                                         <td class="main-rate-block">
                                                          <input type="text" name="rate" id="rate[]" class="form-control" style="width: 80px;" placeholder="{{ __('Rate') }}" value="{{ old('rate', $row->rate) }}" />
                                                        </td>
                                                         <td class="order_quantity-block">
                                                          <input type="text" name="order_quantity" id="order_quantity[]" class="form-control" style="width: 90px;" placeholder="{{ __('Order Quantity') }}" value="{{ old('order_quantity', $row->order_quantity) }}" />
                                                        </td>
                                                        <td class="total_amount-block">
                                                          <input type="text" name="total_amount" id="total_amount[]" class="form-control" style="width: 80px;" placeholder="{{ __('Total Amount') }}" value="{{ old('total_amount', $row->total_amount) }}" />
                                                        </td>
                                                        <td class="lead_time-block">
                                                          <input type="time-local" name="lead_time" id="lead_time[]" class="form-control timepicker" style="width: 90px;" placeholder="{{ __('Lead Time') }}" value="{{ old('lead_time', $row->lead_time) }}" />
                                                        </td>
                                                         <td class="expected_delivery_date-block">
                                                          <input type="date-local" name="expected_delivery_date" id="expected_delivery_date[]" class="form-control" style="width: 90px;" placeholder="{{ __('Expected Delivery Time') }}" value="{{ old('expected_delivery_date', $row->expected_delivery_date) }}" />
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                 <div class="form-group row justify-content-center">
                                                    <div class="col-lg-5">
                                                         <label for="grand_total" class="col-form-label required">{{ __('Grand Total') }}:</label>
                                                        <input type="total" name="grand_total" id="grand_total" class="form-control" placeholder="{{ __('Grand Total') }}" value="{{ old('grand_total', $row->grand_total) }}" />

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
@endsection {{-- Scripts --}}
@section('scripts')
    <script>
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'sub_purchase_order_manualies[]');
        }

        $("form#purchase_order_manualies").validate({
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