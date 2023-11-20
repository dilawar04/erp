@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="enquiry">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}"
                   value="{{ old('id', $row->id) }}">
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
                                <label for="name" class="col-lg-2 col-sm-12 col-form-label">{{ __('Name') }}:</label>
                                <div class="col-lg-6">
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="email" class="col-lg-2 col-sm-12 col-form-label">{{ __('Email') }}:</label>
                                <div class="col-lg-6">
                                    <input type="text" name="email" id="email" class="form-control"
                                           placeholder="{{ __('Email') }}" value="{{ old('email', $row->email) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="message" class="col-lg-2 col-sm-12 col-form-label">{{ __('Message') }}
                                    :</label>
                                <div class="col-lg-10">
                                    <textarea name="message" id="message" class="form-control"
                                              placeholder="{{ __('Message') }}" cols="30"
                                              rows="5">{{ old('message', $row->message) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="status" class="col-lg-2 col-sm-12 col-form-label">{{ __('Status') }}
                                    :</label>
                                <div class="col-lg-6">
                                    <select name="status" id="status" class="form-control m_selectpicker">
                                        <option value="">Select Status</option>
                                        {!! selectBox(DB_enumValues('enquiry', 'status'), old('status', $row->status)) !!}
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

        $("form#enquiry").validate({
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
