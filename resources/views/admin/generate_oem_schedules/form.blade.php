@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="generate_oem_schedules">
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
                            <div class="form-group row">
                               <div class="col-lg-4">
                                    <label for="month" class="col-form-label required monthpicker">{{ __('Month') }}:</label>
                                    <input type="text" name="month" id="month" class="form-control month-picker-switch" placeholder="{{ __('Month') }}" value="{{ old('month', $row->month) }}" aria-invalid="false"min="2018-03" value="2018-05" >
                                </div>
                                  <div class="col-lg-4">
                                        <label for="year" class="col-form-label required month_selectpicker">{{ __('Year') }}:</label>
                                        <input type="text" name="year" id="year" class="form-control yearpicker" placeholder="Year" value="{{ old('year', $row->year) }}" aria-invalid="false"min="2018-03" value="2018-05" >
                                    </div>
                                    <div class="col-lg-4">
                                    <label for="product" class="col-form-label required">{{ __('Product') }}:</label>
                                       <input type="text" name="product" id="product" class="form-control product-picker" placeholder="{{ __('Product') }}" value="{{ old('product', $row->product) }}" >
                                    </div>
                                     <div class="col-lg-5">
                                    <label for="quantity" class="col-form-label required">{{ __('Quantity') }}:</label>
                                       <input type="text" name="quantity" id="quantity" class="form-control product-picker" placeholder="{{ __('Quantity') }}" value="{{ old('quantity', $row->quantity) }}" >
                                    </div>
                                    <div class="col-lg-4">
                                    <label for="oem_id" class="col-form-label required">{{ __('Oems') }}:</label>
                                    <select name="oem_id" id="oem_id" class="form-control m-select2">
                                        <option value="">Select Oems</option>
                                        {!! selectBox("SELECT id,title FROM departments", old('department_id', $row->department_id)) !!}
                                    </select>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            
                                        <!--<div class="col-lg-10">-->
                                        <!--    <div class="operation-block mb-2">-->
                                        <!--        <table class="table table-bordered">-->
                                        <!--            <tr>-->
                                        <!--                <th>S.No</th>-->
                                        <!--                <th>Product</th>-->
                                        <!--                <th>Quantity</th>-->
                                        <!--            </tr>-->
                                                   
                                        <!--        </table>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
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
    $("#month").datepicker( {
    format: "yyyy",
    viewMode: "months", 
    minViewMode: "months"
}).on('changeMonth', function(e){
    $(this).datepicker('hide');
});
     $("#year").datepicker( {
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
}).on('changeYear', function(e){
    $(this).datepicker('hide');
});
  
        $('.no_workers').on('blur', function (){
            const _this = $(this);
            const _parent = _this.closest('.production-block');
            const _parent_data = _parent.data();
            console.log(_parent_data, '_parent_data')
            const num = parseInt(_this.val());
            const exist_block = $('.worker-block', _parent).length;
            if(exist_block > num){
                $('.store-block:gt(' + (num - 1) + ')', _parent).remove();
            }
            for (let i = exist_block; i < num; i++) {
                let _clone = $('.worker-block', _parent).eq(0).clone(true);
                _clone.appendTo($('.main-workers-block', _parent));
            }

            // $('.worker-block', _parent).find('.select2-container').remove();
            // $('.worker-block', _parent).find('select').removeClass('select2-offscreen');
            // $('.worker-block', _parent).find('select').select2();
        })

        $('.no_line').on('blur', function (){
            const _this = $(this);
            const num = parseInt(_this.val());
            const exist_block = $('.production-block').length;
            if(exist_block > num){
                $('.production-block:gt(' + (num - 1) + ')').remove();
            }
            for (let i = exist_block; i < num; i++) {
                let last_el = $('.production-block').eq(0).clone(true)
                last_el.appendTo('.main-production-block');
                last_el.find('span.sn').html(i + 1);
                last_el.attr('data-id', i);
                last_el.find('input').val(1);
                last_el.find('select:gt(0)').remove();
                last_el.find('select').attr('name', 'workers[' + i + '][]');
            }
        })

        $("form#workstations").validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
                code: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                no_of_worker: {
                    required: true,
                },
            },
            /*messages: {
        'name' : {required: 'Name is required',},'code' : {required: 'Code is required',},'category_id' : {required: 'Category ID is required',},'no_of_worker' : {required: 'No Of Worker is required',},    },*/
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