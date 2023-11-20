@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="users">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ $row->id }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-9">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="first_name" class="col-form-label required">{{ __('First Name') }}:</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ old('first_name', $row->first_name) }}"/>
                                </div>
                                <div class="col-6">
                                    <label for="last_name" class="col-form-label">{{ __('Last Name') }}:</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ old('last_name', $row->last_name) }}"/>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="email" class="col-form-label required">{{ __('Email') }}:</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email', $row->email) }}"/>
                                </div>
                                <div class="col-6">
                                    <label for="phone" class="col-form-label">{{ __('Phone') }}:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Phone') }}" value="{{ old('phone', $row->phone) }}"/>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="address" class="col-form-label">{{ __('Address') }}:</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="{{ __('Address') }}" cols="30" rows="1">{{ $row->address }}</textarea>
                                </div>
                                <div class="col-3">
                                    <label for="city" class="col-form-label">{{ __('City') }}:</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('City') }}" value="{{ old('city', $row->city) }}"/>
                                </div>
                                <div class="col-3">
                                    <label for="city" class="col-form-label">{{ __('Country') }}:</label>
                                    <select name="country" id="country" class="form-control m-select2">
                                        <option value="">- Select -</option>
                                        {!! selectBox("SELECT name, name as _name FROM countries", old('country', $row->country ?? 'Pakistan')) !!}
                                    </select>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-2">
                                    <label for="filer" class="col-form-label">{{ __('Filer') }}:</label>
                                    <select name="filer" id="filer" class="form-control m-select2">
                                        {!! selectBox(DB_enumValues('supplier_rel', 'filer'), old('filer', $row->filer)) !!}
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="NTN" class="col-form-label">{{ __('NTN') }}:</label>
                                    <input type="text" name="NTN" id="NTN" class="form-control" placeholder="{{ __('NTN') }}" value="{{ old('NTN', $row->NTN) }}"/>
                                </div>

                                <div class="col-4">
                                    <label for="CNIC" class="col-form-label">{{ __('CNIC') }}:</label>
                                    <input type="text" name="CNIC" id="CNIC" class="form-control" placeholder="{{ __('CNIC') }}" value="{{ old('CNIC', $row->CNIC) }}"/>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-3">
                                    <label for="type_id" class="col-form-label">{{ __('Supplier Type') }}:</label>
                                    <select name="type_id" id="type_id" class="form-control m-select2">
                                        {!! selectBox("SELECT id, title FROM supplier_types", old('type_id', $row->type_id)) !!}
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="organization_type" class="col-form-label">{{ __('Organization Type') }}:</label>
                                    <select name="organization_type" id="organization_type" class="form-control m-select2">
                                        {!! selectBox(DB_enumValues('supplier_rel', 'organization_type'), old('organization_type', $row->organization_type)) !!}
                                    </select>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <h5 class="">Contact Person</h5>
                            {{ $row->contact_persons = json_decode($row->contact_persons) }}
                            <div class="form-group row justify-content-center">
                                <div class="col-4">
                                    <label for="name_c" class="col-form-label">{{ __('Name') }}:</label>
                                    <input type="text" name="contact_persons[name]" id="NTN" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('contact_persons.name', $row->contact_persons->name) }}"/>
                                </div>
                                <div class="col-4">
                                    <label for="contact_persons_phone" class="col-form-label">{{ __('Phone') }}:</label>
                                    <input type="text" name="contact_persons[phone]" id="contact_persons_phone" class="form-control" placeholder="{{ __('Phone') }}" value="{{ old('contact_persons.phone', $row->contact_persons->NTN) }}"/>
                                </div>
                                <div class="col-4">
                                    <label for="contact_persons_CNIC" class="col-form-label">{{ __('CNIC') }}:</label>
                                    <input type="text" name="contact_persons[CNIC]" id="contact_persons_CNIC" class="form-control" placeholder="{{ __('CNIC') }}" value="{{ old('contact_persons.CNIC', $row->contact_persons->CNIC) }}"/>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="terms" class="col-form-label">{{ __('Terms & Conditions') }}:</label>
                                    <textarea name="terms" id="terms" class="form-control" placeholder="{{ __('Terms & Conditions') }}" cols="30" rows="6">{{ $row->terms }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>


                    {{--<div class="kt-portlet" data-ktportlet="true">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"> <i class="flaticon2-lock"></i> </span>
                                    <h3 class="kt-portlet__head-title"> {{ __('User Credential') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="username" class="col-form-label -text-right required">{{ __('Username') }}:</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="{{ __('Username') }}" value="{{ old('username', $row->username) }}"/>
                                </div>
                                <div class="col-6">
                                    <label for="password" class="col-form-label required">{{ __('Password') }}:</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>--}}

                </div>

                <div class="col-lg-3">
                    <div class="kt-portlet" data-ktportlet="true">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"> <i class="flaticon2-image-file"></i> </span>
                                    <h3 class="kt-portlet__head-title"> {{ __('Photo') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <input disabled type="hidden" name="photo--rm" value="{{ $row->photo }}">
                                    @php
                                        $file_input = '<input type="file" name="image" accept="gif,jpg,jpeg,png" name="photo" id="photo" class="form-control custom-file-input" placeholder="'.__('Photo').'" value="'.($row->photo).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->photo);
                                        $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/photo', true);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"jpg, png, bmp, gif" file extension's</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="kt-portlet" data-ktportlet="true">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon"> <i class="flaticon2-image-file"></i> </span>
                                    <h3 class="kt-portlet__head-title"> {{ __('Contract') }} </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <input disabled type="hidden" name="contract--rm" value="{{ $row->contract }}">
                                    @php
                                        $file_input = '<input type="file" name="image" accept="pdf,doc,docx" name="contract" id="contract" class="form-control custom-file-input" placeholder="'.__('contract').'" value="'.($row->contract).'" >';
                                        $thumb_url = asset_url("{$_this->module}/" . $row->contract);
                                        $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/contract', true);
                                        echo thumb_box($file_input, $thumb_url, $delete_img_url);
                                    @endphp
                                    <span class="form-text text-muted">"pdf, doc, docx" file extension's</span>
                                </div>
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

        $("form#users").validate({
            // define validation rules
            rules: {
                //'user_type_id': {required: true,},
                'first_name': {required: true,},
                'email': {required: true, email: true,},
                //'username': {required: true,},
                //'password': {required: true, minlength: 8, maxlength: 8,},
            },
            /*messages: {
            'user_type_id' : {required: 'User Type is required',},'first_name' : {required: 'First Name is required',},'email' : {required: 'Email is required',email: 'Email is not valid',},'username' : {required: 'Username is required',},'password' : {required: 'Password is required',minlength: 'Password must be at least 8 character\'s',maxlength: 'Password maximum 8 character\'s',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });

        @if($row->id > 0)
        $('#password').rules('remove');
        @endif
    </script>
@endsection
