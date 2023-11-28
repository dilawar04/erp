@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="raw_material_images">
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
                                <div class="col-lg-4">
                                    <label for="document_name" class="col-form-label required">Document Name:</label>
                                    <input type="text" name="document_name[]" id="document_name" class="form-control" placeholder="Document Name" value="{{ old('document_name', $row->document_name) }}" />
                                </div>    
                                <div class="col-lg-6">
                                    <label for="upload_date" class="col-form-label required">Upload Date:</label>
                                    <input type="datetime-local" name="upload_date[]" id="upload_date" class="form-control" placeholder="Upload Date" value="{{ old('upload_date', $row->upload_date) }}" />
                                </div>
                              <div class="col-lg-2 text-center style="margin-top: 10px;">
                                    <label for="upload_document" class="-col-lg-2 -col-sm-12 -col-form-label required">Upload Document:</label><br>
                                    <input disabled="" type="hidden" name="upload_document[]--rm" value="">
                                        <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_apps_user_add_avatar fImg">
                                        <a href="https://erp.businessfuelprovider.com/assets/front/raw_material_images" data-fancybox="image">
                                        <div class="kt-avatar__holder del-img" style="background-image: url(https://erp.businessfuelprovider.com/assets/cache/d/2/f/a/4/d2fa4f54525d7a4633a1117741f28396c36a1a07-noimage.png);"></div>
                                            </a>
                                         <label class="kt-avatar__upload" data-skin="dark" data-toggle="kt-tooltip" title="" data-original-title="choose image">
                                             <i class="fa fa-pen"></i>
                                                  <input type="file" accept="image/*" name="upload_document" id="upload_document" class="form-control custom-file-input" value="">        </label>
                                        <span class="kt-avatar__cancel" data-skin="dark" data-toggle="kt-tooltip" title="" data-original-title="remove image" href="">
                                                 <i class="fa fa-times"></i>
                                                    </span>
                                                        </div>
                                        <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                 </div>

                                    @if(empty($row->id))
                                    <div class="col-lg-6" style="margin-top: 10px;">
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
@endsection {{-- Scripts --}} @section('scripts')
    <script>
         $(form#raw_material_stocks).on('click', '.is_stations', function() {
                let is_stations = $(this).val();

                if (is_stations == 'true') {
                    $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
                    $('#is_stations-input-area').show();
                } else {
                    $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
                    $('#is_stations-input-area').hide();
                }
            });

            $(form#raw_material_stocks).on('click', '#modal-submit-button', function() {
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
                            $('#modal-heading').text('Edit OEM');
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

        $("form#raw_material_stocks").validate({
            // define validation rules
            rules: {
                opening_quantity: {
                    required: true,
                },
                opening_date: {
                    required: true,
                },
                stock_value: {
                    required: true,
                },
            },
            /*messages: {
        'opening_quantity' : {required: 'opening_quantity is required',},'opening_date' : {required: 'opening_date is required',},'stock_value' : {required: 'stock_value is required',},    },*/
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
