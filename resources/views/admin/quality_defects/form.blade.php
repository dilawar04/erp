@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
<form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="quality_defects">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
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
                                    <label for="defect" class="col-form-label required">{{ __('Defect English') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Defect English') }}" value="{{ old('defect', $row->name) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="urdu" class="col-form-label">{{ __('Defect Urdu') }}:</label>
                                    <input dir="rtl" type="text" name="urdu" id="urdu" class="form-control"  placeholder="{{ __('نقس اردو زبان میں') }}" value="{{ old('urdu', $row->urdu) }}" />
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
        $("form#quality_defects").validate({
            // define validation rules
            rules: {
                defect: {
                    required: true,
                },
            },
            /*messages: {
        'defect' : {required: 'Defect English is required',},    },*/
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
