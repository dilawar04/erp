@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="workstations">
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
                                <div class="col-lg-3">
                                    <label for="code" class="col-form-label required">{{ __('Code') }}:</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('CODE FORMAT: AB-1234') }}" value="{{ old('code', $row->code) }}" />
                                </div>
                                <div class="col-lg-5">
                                    <label for="name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label for="type_of_work" class="col-form-label">{{ __('Type Of Work') }}:</label>
                                    <select name="type_of_work" id="type_of_work" class="form-control m_selectpicker">
                                        <option value="">Select Type Of Work</option>
                                        {!! selectBox(DB_enumValues('workstations', 'type_of_work'), old('type_of_work', $row->type_of_work)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="category_id" class="col-form-label required">{{ __('Category') }}:</label>
                                    <select name="category_id" id="category_id" class="form-control m_selectpicker">
                                        <option value="">Select Category ID</option>
                                        {!! selectBox(DB_enumValues('workstation_categories', 'category_id'), old('category_id', $row->category_id)) !!}
                                    </select>
                                    @if(user_do_action('add', 'workstation_categories'))
                                        <span class="form-text text-muted">
                                        <a href="{{ admin_url('workstation_categories/form') }}" target="_blank" class="text-danger">Not available? Create New</a>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-2">
                                    <label for="no_line" class="col-form-label">{{ __('No of Production Line') }}:</label>
                                    <input type="text" name="no_line" id="no_line" class="no_line form-control" placeholder="{{ __('No Line') }}" value="{{ old('no_line', $row->no_line ?? 1) }}" />
                                </div>

                            </div>
                            {{--<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-3">
                                    <label for="no_of_worker" class="col-form-label required">{{ __('No Of Worker') }}:</label>
                                    <input type="text" name="no_of_worker" id="no_of_worker" class="form-control" placeholder="{{ __('No Of Worker') }}" value="{{ old('no_of_worker', $row->no_of_worker) }}" />
                                </div>
                            </div>--}}
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            <div class="main-production-block">
                                <div class="production-block -border -p-3 mb-2" data-id="0">
                                    <h5 class="kt-portlet__head-title">Production Line <span class="sn">1</span></h5>
                                    <div class="form-group row">
                                        <div class="col-lg-2 bg-secondary">
                                            <label for="mode_storages" class="col-form-label">{{ __('No of Worker') }}:</label>
                                            <input type="text" name="workers[]" id="no_workers" class="no_workers form-control" placeholder="{{ __('No of Worker') }}" value="{{ old('workers', $row->workers ?? 1) }}"/>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="operation-block mb-2">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Name</th>
                                                        <th>Workers</th>
                                                    </tr>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center"><span class="sn">1</span></td>
                                                        <td>
                                                            <input type="text" name="workers[]" id="no_workers" class="no_workers form-control" placeholder="{{ __('Operation') }}" value="{{ old('workers', $row->workers ?? 'Operation 1') }}"/>
                                                        </td>
                                                        <td class="main-workers-block d-flex flex-wrap">
                                                                <span class="worker-block">
                                                                    <select name="workers[0][]" id="category_id" class="form-control -m-select2 mr-1 mb-1" style="width: 220px;">
                                                                        <option value="">Select Worker</option>
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
