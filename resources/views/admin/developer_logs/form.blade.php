@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="developer_logs">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __(ID) }}" value="{{ old('id', $row->id) }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="mt10"></div>


                            <div class="form-group row">
                                <label for="type" class="col-2 col-form-label">{{ __('Type') }}:</label>
                                <div class="col-6">
                                    <input type="text" name="type" id="type" class="form-control" placeholder="{{ __('Type') }}" value="{{ old('type', $row->type) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="description" class="col-2 col-form-label">{{ __('Description') }}:</label>
                                <div class="col-10">
                                    <textarea name="description" id="description" class="form-control" placeholder="{{ __('Description') }}" cols="30" rows="5">{{ old('description', $row->description) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="table" class="col-2 col-form-label">{{ __('Table') }}:</label>
                                <div class="col-6">
                                    <input type="text" name="table" id="table" class="form-control" placeholder="{{ __('Table') }}" value="{{ old('table', $row->table) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="table_id" class="col-2 col-form-label">{{ __('Table ID') }}:</label>
                                <div class="col-6">
                                    <input type="text" name="table_id" id="table_id" class="form-control" placeholder="{{ __('Table ID') }}" value="{{ old('table_id', $row->table_id) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="user_id" class="col-2 col-form-label">{{ __('User') }}:</label>
                                <div class="col-6">
                                    <select name="user_id" id="user_id" class="form-control m-select2">
                                        <option value="">Select User</option>
                                        {!! selectBox("SELECT id, username FROM users", old('user_id', $row->user_id)) !!}
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

        $("form#developer_logs").validate({
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
    </script>@endsection
