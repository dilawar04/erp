@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
     <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="suppliers">
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
                            <div class="form-group row justify-content-center">
                                <div class="col-4">
                                    <label for="name" class="col-form-label required">{{ __(' Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __(' Name') }}" value="{{ old('name', $row->name) }}"/>
                                </div>

                                 <div class="col-4">
                                    <label for="contact" class="col-form-label required">{{ __(' Contact No') }}:</label>
                                    <input type="text" name="contact" id="contact" class="form-control" placeholder="{{ __('Contact No') }}" value="{{ old('contact', $row->contact) }}"/>
                                </div>
                                <div class="col-4">
                                    <label for="email" class="col-form-label required">{{ __('Email') }}:</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email', $row->email) }}"/>
                                </div>
                                
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                
                                <div class="col-3">
                                    <label for="address" class="col-form-label required">{{ __('Address') }}:</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="{{ __('Address') }}" cols="30" rows="1">{{ $row->address }}</textarea>
                                </div>
                                
                                 <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                 <div class="col-3">
                                    <label for="city" class="col-form-label required">{{ __('Country') }}:</label>
                                    <select name="country" id="country" class="form-control m-select2">
                                        <option value="">- Select -</option>
                                        {!! selectBox("SELECT name, name as _name FROM countries", old('country', $row->country ?? 'Pakistan')) !!}
                                    </select>
                                </div>
                                
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                               <div class="col-3">
                                    <label for="city" class="col-form-label required">{{ __('City') }}:</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('City') }}" value="{{ old('city', $row->state) }}"/>
                                </div>
                                
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                               <div class="col-3">
                                    <label for="state" class="col-form-label required">{{ __('State') }}:</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('State') }}" value="{{ old('state', $row->state) }}"/>
                                </div>
                                
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                <div class="col-4">
                                    <label for="postal_code" class="col-form-label required">{{ __('Postal Code') }}:</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="{{ __('Postal Code') }}" value="{{ old('postal_code', $row->postal_code) }}"/>
                                </div>
                                
                                <div class="col-4">
                                    <label for="filter" class="col-form-label required">{{ __('Filter') }}:</label>
                                    <select name="filter" id="filter" class="form-control m-select2 multiple-form">
                                        {!! selectBox(DB_enumValues('suppliers', 'filter'), old('filter', $row->filter)) !!}
                                    </select>
                                </div>
                                
                                <div class="col-4" id="ntn">
                                    <label for="ntn" class="col-form-label required">{{ __('NTN') }}:</label>
                                    <input type="text" name="ntn" id="ntn" class="form-control" placeholder="{{ __('NTN') }}" value="{{ old('ntn', $row->ntn) }}"/>
                                </div>

                                <div class="col-4" id="sales_tax">
                                    <label for="sales-tax" class="col-form-label required">{{ __('Sales Tax') }}:</label>
                                    <input type="text" name="sales_tax" id="sales_tax" class="form-control" placeholder="{{ __('Sales Tax') }}" value="{{ old('sales_tax', $row->sales_tax) }}"/>
                                </div>
        
                                <div class="col-3">
                                    <label for="type_id" class="col-form-label required">{{ __('Supplier Type') }}:</label>
                                    <select name="type_id" id="type_id" class="form-control m-select2">
                                        {!! selectBox("SELECT id, title FROM supplier_types", old('type_id', $row->type_id)) !!}
                                    </select>
                                </div>
                                
                                <div class="col-3">
                                    <label for="organization" class="col-form-label required">{{ __('Organization') }}:</label>
                                    <select name="organization" id="organization" class="form-control m-select2">
                                     {!! selectBox(DB_enumValues('suppliers', 'organization'), old('organization', $row->organization)) !!}
                                    </select>
                                </div>
                                
                                <div class="col-3">
                                    <label for="payment_terms" class="col-form-label required">{{ __('Payment Terms') }}:</label>
                                    <input type="text" name="payment_terms" id="payment_terms" class="form-control" placeholder="{{ __('Payment Terms') }}" value="{{ old('payment_terms', $row->payment_terms) }}"/>
                                </div>
                                
                                <div class="col-lg-3">
                                    <label for="from" class="col-form-label required">{{ __('Contract Document') }}:</label>
                                    <input class="form-control" type="file" id="contract_document" name="contract_document" value="">
                                    <span class="form-text text-muted">"pdf, xls, xlsx, doc, docx" file extension's</span>
                                </div>
                          </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <h5 class="">Contact Person</h5>
                            {{ $row->contact_persons = json_decode($row->contact_persons) }}
                            
                            <div class="form-group row justify-content-center">
                                <div class="col-4">
                                    <label for="person_name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="person_name" id="person_name" class="form-control" placeholder="{{ __(' Name') }}" value="{{ old('person_name', $row->person_name) }}"/>
                                </div>
                                <div class="col-4">
                                    <label for="person_contact" class="col-form-label required">{{ __('Contact') }}:</label>
                                    <input type="text" name="person_contact" id="person_contact" class="form-control" placeholder="{{ __('Contact') }}" value="{{ old('person_contact', $row->person_contact) }}"/>
                                </div>
                                <div class="col-4">
                                    <label for="person_cnic" class="col-form-label required">{{ __('CNIC') }}:</label>
                                    <input type="text" name="person_cnic" id="person_cnic" class="form-control" placeholder="{{ __('CNIC') }}" value="{{ old('person_cnic', $row->person_cnic) }}" data-inputmask="'mask': '99999-9999999-9'" required/>
                                    <span class="form-text text-muted">eg:<code>10001-1000001-1</code></span>
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
@endsection

{{-- Scripts --}}
@section('scripts')
<script>
    $("#suppliers").validate({
        rules: {
            field: {
            required: true,
            accept: "xls|csv"
            }
        }
    });

        $(document).ready(function() {
            $('.multiple-form').on('change', function() {
                var value = $(this).val();
                if (value === 'no') {
                    $("#ntn").hide();
                } else if (value === 'yes') {
                    $("#ntn").show();
                }
            });
            // Trigger the change event on page load for editing
            $('.multiple-form').trigger('change');
        });

    $("form#suppliers").validate({
        rules: {
            'name': {required: true,},
            'contact': {required: true, contact: true,},
            'email': {required: true, email: true,},
            'address': {required: true, address: true,},
        },
       
        invalidHandler: function (event, validator) {
            KTUtil.scrollTop();
        },
        submitHandler: function (form) {
            form.submit();
        }

    });
</script>
@endsection
