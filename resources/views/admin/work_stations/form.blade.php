@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="workstation">
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
                        <div class="kt-portlet__body body_overtime" id="showovertime">
                            <div class="clone_container">
                                <div class="from-group row mb-3 clone">
                                    <div class="col-lg-6">
                                        <label for="Code" class="col-form-label required">{{ __('Workstation Code') }}:</label>
                                        <input type="text" name="code[]" class="form-control code" placeholder="{{ __('Workstation Code') }}" value="{{ old('title', $row->code) }}" />
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="name" class="col-form-label">{{ __('Workstation Name') }}:</label>
                                        <input type="text" name="name[]" class="form-control name" placeholder="{{ __('Workstation Name') }}" value="{{ old('title', $row->name) }}" />
                                    </div>
                                    @if(empty($row->id))
                                    <div style="margin-top: 36px;">
                                        <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container" callback="add_more_cb_overtime"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                    </div>
                                    @endif
                                </div>
                             </div>
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
        function add_more_cb(clone, clone_container){
            const index = clone_container.find('.clone').length - 1;
        }

        $("form#workstation").validate({
            // define validation rules
            rules: {
                code: {
                    required: true,
                },
                name: {
                    required: true,
                }
            },
            /*messages: {
        'shift_name' : {required: 'Shift Name is required',},'start_time' : {required: 'Start Time is required',},'end_time' : {required: 'End Time is required',},'brake_name' : {required: 'Braek Name is required',},    },*/
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
