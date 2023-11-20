<div class="row">
    <div class="col-lg-10">

        <div class="form-group row">
            <div class="col-4">
                <label for="first_name" class="col-form-label required">{{ __('First Name') }}:</label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ old('first_name', $row->first_name) }}"/>
            </div>
            <div class="col-4">
                <label for="last_name" class="col-form-label">{{ __('Middle Name') }}:</label>
                <input type="text" name="rel[middle_name]" id="middle_name" class="form-control" placeholder="{{ __('Middle Name') }}" value="{{ old('middle_name', $row->middle_name) }}"/>
            </div>
            <div class="col-4">
                <label for="last_name" class="col-form-label">{{ __('Last Name') }}:</label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ old('last_name', $row->last_name) }}"/>
            </div>
        </div>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
        <div class="form-group row">
            <div class="col-4">
                <label for="dob" class="col-form-label">{{ __('DOB') }}:</label>
                <input type="text" name="dob" id="dob" class="form-control datepicker" autocomplete="off" placeholder="{{ __('DOB') }}" value="{{ old('dob', $row->dob) }}"/>
            </div>
            <div class="col-4">
                <label for="gender" class="col-form-label">{{ __('Gender') }}:</label>
                <select name="gender" id="gender" class="form-control m-select2">
                    {!! selectBox(DB_enumValues('users', 'gender'), old('gender', $row->gender)) !!}
                </select>
            </div>
            <div class="col-4">
                <label for="CNIC" class="col-form-label required">{{ __('CNIC') }}:</label>
                <input type="text" name="rel[CNIC]" id="CNIC" class="form-control" placeholder="{{ __('CNIC') }}" value="{{ old('CNIC', $row->CNIC) }}" data-inputmask="'mask': '99999-9999999-9'" required/>
                <span class="form-text text-muted">eg:<code>10001-1000001-1</code></span>
            </div>
        </div>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
            <div class="col-12">
                <label for="address" class="col-form-label">{{ __('Address') }}:</label>
                <textarea name="address" id="address" class="form-control" placeholder="{{ __('Address') }}" cols="30" rows="1">{{ $row->address }}</textarea>
            </div>
        </div>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
        <div class="form-group row">
            <div class="col-3">
                <label for="city" class="col-form-label">{{ __('City') }}:</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('City') }}" value="{{ old('city', $row->city) }}"/>
            </div>
            <div class="col-3">
                <label for="state" class="col-form-label">{{ __('State') }}:</label>
                <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('State') }}" value="{{ old('state', $row->state) }}"/>
            </div>
            <div class="col-3">
                <label for="city" class="col-form-label">{{ __('Country') }}:</label>
                <select name="country" id="country" class="form-control m-select2">
                    <option value="">- Select -</option>
                    {!! selectBox("SELECT name, name as _name FROM countries", old('country', $row->country ?? 'Pakistan')) !!}
                </select>
            </div>
            <div class="col-3">
                <label for="zip_code" class="col-form-label">{{ __('Postal code') }}:</label>
                <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="{{ __('Postal code') }}" value="{{ old('zip_code', $row->zip_code) }}"/>
            </div>
        </div>


        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
            <div class="col-6">
                <label for="email" class="col-form-label required">{{ __('Email') }}:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email', $row->email) }}"/>
            </div>
            <div class="col-6">
                <label for="phone" class="col-form-label">{{ __('Phone') }}:</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Phone') }}" value="{{ old('phone', $row->phone) }}"/>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
            <div class="col-4">
                <label for="contact" class="col-form-label required">{{ __('Contact #') }}:</label>
                <input type="text" name="rel[contact]" id="contact" class="form-control" placeholder="{{ __('Contact #') }}" value="{{ old('rel.contact', $row->contact) }}"/>
            </div>
            <div class="col-lg-4">
                <label for="rel_martial_status" class="col-form-label">{{ __('Martial Status') }}:</label>
                <select name="rel[martial_status]" id="rel_martial_status" class="form-control m-select2">
                    {!! selectBox(DB_enumValues('employee_rel', 'martial_status'), old('rel.martial_status', $row->martial_status)) !!}
                </select>
            </div>
            <div class="col-lg-4">
                <label for="dependents" class="col-form-label">{{ __('No. of Dependents') }}:</label>
                <input type="number" name="rel[dependents]" id="dependents" class="form-control" placeholder="{{ __('# of Dependents') }}" value="{{ old('rel.dependents', $row->dependents) }}"/>
            </div>
        </div>

        {{--<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
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
        </div>--}}

        {{--<div class="kt-portlet mt-3" data-ktportlet="true">
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

    <div class="col-lg-2">

        <div class="form-group row">
            <div class="col-12 text-center">
                <label for="photo" class="col-form-label">{{ __('Photo') }}:</label><br>
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
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
            <div class="col-12 text-center">
                <label for="CNIC_image" class="col-form-label">{{ __('CNIC image') }}:</label><br>

                <input disabled type="hidden" name="CNIC_image--rm" value="{{ $row->CNIC_image }}">
                @php
                    $file_input = '<input type="file" name="CNIC_image" accept="gif,jpg,jpeg,png" name="contract" id="contract" class="form-control custom-file-input" placeholder="'.__('CNIC image').'" value="'.($row->CNIC_image).'" >';
                    $thumb_url = asset_url("{$_this->module}/" . $row->CNIC_image);
                    $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/CNIC_image', true);
                    echo thumb_box($file_input, $thumb_url, $delete_img_url);
                @endphp
                <span class="form-text text-muted">"jpg, png, bmp, gif" file extension's</span>
            </div>
        </div>

    </div>
</div>
