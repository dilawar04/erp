@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="semi_finished_product_drawings_model">
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
                                    <label for="upload_date" class="col-form-label required">Upload Date:</label>
                                    <input type="datetime-local" name="upload_date" id="upload_date" class="form-control" placeholder="Upload Date" value="{{ old('upload_date', $row->upload_date) }}" />
                                </div>
                             <div class="col-lg-2 text-center">
                                    <label for="upload_document" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Upload Document') }}:</label><br>
                                    <input disabled type="hidden" name="upload_document--rm" value="{{ $row->upload_document }}">
                                    @php
                                        $file_input = '<input type="file" accept="image/*"name="upload_document" accept="pdf,doc,docx" name="upload_document" id="upload_document" class="form-control custom-file-input" value="'.old('upload_document', $row->upload_document).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->schedule);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                </div>

                                {{--<div class="col-lg-12">
                                    <label for="upload_document" class="col-form-label">{{ __('Upload Document') }}:</label>
                                    <input type="file" accept="image/*" name="upload_document" id="upload_document" class="form-control" placeholder="{{ __('Upload Document') }}" value="{{ old('upload_document', $row->upload_document) }}" />
                                </div>--}}
                            </div>
                                 
                                <div class="col-lg-6" style="margin-top: 10px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
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
     $(form#semi_finished_product_profiles).on('click', '.is_stations', function() {
                let is_stations = $(this).val();

                if (is_stations == 'true') {
                    $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
                    $('#is_stations-input-area').show();
                } else {
                    $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
                    $('#is_stations-input-area').hide();
                }
            });

            $(form#semi_finished_product_profiles).on('click', '#modal-submit-button', function() {
                if (!checkRequiredInputs()) {
                    notify(2, 'Please fill required inputs.');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('admin') }}",
                    type: 'POST',
                    data: $('#modal-form').serialize(),
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        notify(response.status, response.message);
                    }
                });
            });
            $(document).on('click', '.edit-button', function() {
                let url = "{{ url('admin', ":id") }}";
                var id = $(this).data('id');
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            $('#modal-heading').text('Edit Semi Finished Product Profile');
                            $('#modal-body').html(response.data);
                            if ($('#station_checked').val() == 'true') {
                                $('#stations-input-area').show();
                            } else {
                                $('#stations-input-area').hide();
                            }
                            $('#modal').show();
                        } else {
                            notify(response.status, response.message);
                        }
                    }
                });
            });
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'model_name[]');
        }

        $("form#semi_finished_product_profiles_model").validate({
            // define validation rules
            rules: {
                model_name: {
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
