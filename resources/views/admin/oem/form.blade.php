@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="oem">
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
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="name" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="address" class="col-form-label required">{{ __('Address') }}:</label>
                                    <input type="address" name="address" id="address" class="form-control" placeholder="{{ __('Address') }}" value="{{ old('address', $row->address) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="country" class="col-form-label required">{{ __('Country') }}:</label>
                                    <input type="text" name="country" id="country" class="form-control" placeholder="{{ __('Country') }}" value="{{ old('country', $row->country) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="city" class="col-form-label required">{{ __('City') }}:</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('City') }}" value="{{ old('city', $row->city) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="state" class="col-form-label required">{{ __('State') }}:</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('State') }}" value="{{ old('state', $row->state) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="postal_code" class="col-form-label required">{{ __('Postal Code') }}:</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="{{ __('Postal Code') }}" value="{{ old('postal_code', $row->postal_code) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="contact_no" class="col-form-label required">{{ __('Contact No') }}:</label>
                                    <input type="number" name="contact_no" id="contact_no" class="form-control" placeholder="{{ __('Contact No') }}" value="{{ old('contact_no', $row->contact_no) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="email" class="col-form-label required">{{ __('Email') }}:</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email', $row->email) }}" />
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
         $(form#oem).on('click', '.is_stations', function() {
                let is_stations = $(this).val();

                if (is_stations == 'true') {
                    $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
                    $('#is_stations-input-area').show();
                } else {
                    $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
                    $('#is_stations-input-area').hide();
                }
            });

            $(form#oem).on('click', '#modal-submit-button', function() {
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

        $("form#oem").validate({
            // define validation rules
            rules: {
                title: {
                    required: true,
                },
                email: {
                    required: true,
                },
                phone: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'title is required',},'email' : {required: 'email is required',},'contact_no' : {required: 'contact_no is required',},    },*/
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
