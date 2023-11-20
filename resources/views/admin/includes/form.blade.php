@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
<form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="includes">
    @csrf
    @include('admin.layouts.inc.stickybar', compact('form_buttons'))
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <input type="hidden" name="inc_id" class="form-control" placeholder="{{ __('Inc ID') }}" value="{{ old('inc_id', $row->inc_id) }}">
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
        <label for="include" class="col-lg-2 col-sm-12 col-form-label">{{ __('Include') }}:</label>
        <div class="col-lg-10">
                        <textarea name="include" id="include" placeholder="{{ __('Include') }}"  class="editor form-control" cols="30" rows="5">{{ old('include', $row->include) }}</textarea>
                                </div>
    </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    <div class="form-group row">
        <label for="not_include" class="col-lg-2 col-sm-12 col-form-label">{{ __('Not Include') }}:</label>
        <div class="col-lg-10">
                        <textarea name="not_include" id="not_include" placeholder="{{ __('Not Include') }}"  class="editor form-control" cols="30" rows="5">{{ old('not_include', $row->not_include) }}</textarea>
                                </div>
    </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="form-group row">
                        <label for="created" class="col-lg-2 col-sm-12 col-form-label">{{ __('Created') }}:</label>             <div class="col-lg-6">
                                                <input type="text" name="created" id="created" class="form-control" placeholder="{{ __('Created') }}" value="{{ old('created', $row->created) }}" />
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

    $( "form#includes" ).validate({
    // define validation rules
    rules: {
        },
    /*messages: {
        },*/
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
