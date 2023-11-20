@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="generate_wo_manuallies">
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
                                 <div class="col-lg-2">
                                    <label for="type_of_worker" class="col-form-label">{{ __('Type Of Worker') }}:</label>
                                    <select name="type_of_worker" id="type_of_worker" class="form-control m_selectpicker">
                                        <option value="">Select Type Of Worker</option>
                                        {!! selectBox(DB_enumValues('generate_wo_manuallies', 'type_of_worker'), old('type_of_worker', $row->type_of_worker)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="product_id" class="col-form-label required">{{ __('Product') }}:</label>
                                    <select name="product_id" id="product_id" class="form-control m-select2">
                                        <option value="">Select Product ID</option>
                                          {!! selectBox(DB_enumValues('generate_wo_manuallies', 'product_id'), old('product_id', $row->product_id)) !!}
                                        
                                    </select>
                                    @if(user_do_action('add', 'generate_wo_manuallies'))
                                        <span class="form-text text-muted">
                                        <a href="{{ admin_url('generate_wo_manuallies/form') }}" target="_blank" class="text-danger">Not available? Create New</a>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3">
                                    <label for="workstation" class="col-form-label required">{{ __('Workstation') }}:</label>
                                    <input type="text" name="workstation" id="workstation" class="form-control" placeholder="{{ __('Workstation') }}" value="{{ old('workstation', $row->workstation) }}" />
                                </div>
                                </div>
                                 <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-2">
                                    <label for="production_date" class="col-form-label required">{{ __('Production Date') }}:</label>
                                     <input type="text" name="production_date" id="production_date" class="form-control datepicker" placeholder="{{ __('Production Date') }}" value="{{ old('production_date', $row->production_date) }}" />
                                </div>
                               
                            </div>

                            {{--<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-3">
                                   <label for="no_hour" class="col-form-label">{{ __('No of Working Hours') }}:</label>
                                     <input type="text" name="no_hour" id="no_hour" class="no_hour form-control" placeholder="{{ __('No Hour') }}" value="{{ old('no_hour', $row->no_hour ?? 1) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="no_of_worker" class="col-form-label required">{{ __('No Of Worker') }}:</label>
                                    <input type="text" name="no_of_worker" id="no_of_worker" class="form-control" placeholder="{{ __('No Of Worker') }}" value="{{ old('no_of_worker', $row->no_of_worker) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="production_qty" class="col-form-label required">{{ __('Production QTY') }}:</label>
                                    <input type="text" name="production_qty" id="production_qty" class="form-control" placeholder="{{ __('Production QTY') }}" value="{{ old('production_qty', $row->production_qty) }}" />
                                </div>
                            </div>--}}
                              <div class="main-production-block">
                                <div class="production-block -border -p-3 mb-2" data-id="0">
                                    <h5 class="kt-portlet__head-title">Production Date <span class="sn">1</span></h5>
                                    <div class="form-group row">
                                        <div class="col-lg-2 bg-secondary">
                                            <label for="mode_storages" class="col-form-label">{{ __('No of Working Hour') }}:</label>
                                            <input type="text" name="no_hour[]" id="no_hour" class="no_hour form-control" placeholder="{{ __('No of Working Hour') }}" value="{{ old('no_hour', $row->no_hour ?? 1) }}"/>
                                        </div>
                                         <div class="col-lg-2 bg-secondary">
                                            <label for="mode_storages" class="col-form-label">{{ __('No of Worker') }}:</label>
                                            <input type="text" name="workers[]" id="no_workers" class="no_workers form-control" placeholder="{{ __('No of Worker') }}" value="{{ old('workers', $row->workers ?? 1) }}"/>
                                        </div>
                                        <div class="col-lg-2 bg-secondary">
                                            <label for="mode_storages" class="col-form-label">{{ __('Production QTY') }}:</label>
                                            <input type="text" name="productions[]" id="production_qty" class="production_qty form-control" placeholder="{{ __('Production QTY') }}" value="{{ old('productions', $row->productions ?? 1) }}"/>
                                        </div>
                                         <div class="col-lg-10">
                                            <div class="operation-block mb-2">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Workstations</th>
                                                        <th>Workers</th>
                                                    </tr>
                                                    <tbody>
                                         <tr>
                                                        <td class="text-center"><span class="sn">1</span></td>
                                                        <td>Operation <span class="sn">1</span></td>
                                                        <td class="main-workers-block d-flex flex-wrap">
                                                                <span class="worker-block">
                                                                    <select name="workers[0][]" id="product_id" class="form-control -m-select2 mr-1 mb-1" style="width: 220px;">
                                                                        <option value="">Select Worker</option>
                                                                                           {!! selectBox(DB_enumValues('generate_wo_manuallies', 'worker'), old('worker', $row->worker)) !!}

                                                                    </select>
                                                                </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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

        $("form#generate_wo_manuallies").validate({
            // define validation rules
            rules: {
                workstation: {
                    required: true,
                },
                product_id: {
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
