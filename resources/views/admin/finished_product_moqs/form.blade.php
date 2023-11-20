@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="finished_product_moqs">
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
                            <div class="form-group row">
                               <div class="col-lg-6">
                                    <label for="date" class="col-form-label required">{{ __('Date') }}:</label>
                                    <input type="datetime-local" name="date" id="date" class="form-control" placeholder="{{ __('Date') }}" value="{{ old('date', $row->date) }}" />
                                </div>
                                      <div class="col-lg-2 text-center">
                                    <label for="schedule" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Schedule') }}:</label><br>
                                    <input disabled type="hidden" name="schedule--rm" value="{{ $row->schedule }}">
                                    @php
                                        $file_input = '<input type="file" accept="image/*"name="schedule" accept="pdf,doc,docx" name="schedule" id="upload_document" class="form-control custom-file-input" value="'.old('schedule', $row->schedule).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->schedule);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                </div>

                                {{--<div class="col-lg-12">
                                    <label for="schedule" class="col-form-label">{{ __('Schedule') }}:</label>
                                    <input type="file" accept="image/*" name="schedule" id="schedule" class="form-control" placeholder="{{ __('Schedule') }}" value="{{ old('schedule', $row->schedule) }}" />
                                </div>--}}
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
        $("form#finished_product_moqs").validate({
            // define validation rules
            rules: {
                schedule: {
                    required: true,
                },
                oem_id: {
                    required: true,
                },
            },
            /*messages: {
        'schedule' : {required: 'Schedule is required',},'oem_id' : {required: 'finished_product_moqs is required',},    },*/
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
