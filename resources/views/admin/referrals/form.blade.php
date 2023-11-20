@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
<form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="referrals">
    @csrf
    @include('admin.layouts.inc.stickybar', compact('form_buttons'))
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}">
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
            <div class="col-lg-6">
                                <label for="referral_user_id" class="col-form-label required">{{ __('Referral User') }}:</label>
                                                <select name="referral_user_id" id="referral_user_id" class="form-control m-select2" >
                    <option value="">Select Referral User</option>
                    {!! selectBox("SELECT id, first_name FROM users", old('referral_user_id', $row->referral_user_id)) !!}
                </select>
                                            </div>
        </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
            <div class="col-lg-6">
                                <label for="user_id" class="col-form-label">{{ __('User') }}:</label>
                                                <select name="user_id" id="user_id" class="form-control m-select2" >
                    <option value="">Select User</option>
                    {!! selectBox("SELECT id, first_name FROM users", old('user_id', $row->user_id)) !!}
                </select>
                                            </div>
        </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
                        <div class="col-lg-6">
                                <label for="code" class="col-form-label required">{{ __('Code') }}:</label>                                 <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('Code') }}" value="{{ old('code', $row->code) }}" />
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

    $( "form#referrals" ).validate({
    // define validation rules
    rules: {
            'referral_user_id': {
            required: true,
        },
            'code': {
            required: true,remote: '<?php echo admin_url('ajax/validate/' . $row->id, true)?>',
        },
        },
    /*messages: {
    'referral_user_id' : {required: 'Referral User is required',},'code' : {required: 'Code is required',remote: 'This Code is already exist',},    },*/
    //display error alert on form submit
    invalidHandler: function(event, validator) {
        KTUtil.scrollTop();
        //validator.errorList[0].element.focus();
    },
    submitHandler: function(form) {
        form.submit();
    }

});
</script>@endsection
