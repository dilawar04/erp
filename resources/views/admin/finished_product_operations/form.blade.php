@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="finished_product_operations">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ $row->id }}">
            <!-- begin:: Content -->


           <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head') @include('admin.layouts.inc.portlet_actions')
                        </div>

                            <div class="kt-portlet__body">
                             <div class="clone_container">
                                <div class="from-group row mb-3 clone"> 
                                <div class="col-6">
                                    <label for="opening_quantity" class="col-form-label required">{{ __('Opening Quantity') }}:</label>
                                    <input type="text" name="opening_quantity" id="opening_quantity" class="form-control" placeholder="{{ __(' Opening Quantity') }}" value="{{ old('opening_quantity', $row->opening_quantity) }}"/>
                                </div>

                                 <div class="col-6">
                                    <label for="line" class="col-form-label">{{ __('Line') }}:</label>
                                    <input type="text" name="line" id="line" class="form-control" placeholder="{{ __('Line') }}" value="{{ old('line', $row->line) }}"/>
                                </div>
                                 <div class="col-lg-2 text-center">
                                    <label for="type_id" class="col-form-label">{{ __(' Type') }}:</label>
                                    <select name="type_id" id="type_id" class="form-control m-select2">
                                         {!! selectBox(DB_enumValues('finished_product_operations', 'type_id'), old('type_id', $row->type_id)) !!}
                                    </select>
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
