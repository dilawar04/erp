@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="leaves">
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
                                    <label for="name" class="col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="number_of_day" class="col-form-label required">{{ __('Number Of Day') }}:</label>
                                    <input type="text" name="number_of_day" id="number_of_day" class="form-control" placeholder="{{ __('Number Of Day') }}" value="{{ old('number_of_day', $row->number_of_day) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-2">
                                    <label for="earned_leave" class="col-form-label">{{ __('Earned Leave') }}:</label>
                                    <select name="earned_leave" id="earned_leave" class="form-control m_selectpicker">
                                        <option value="">Select Earned Leave</option>
                                        {!! selectBox(DB_enumValues('leaves', 'earned_leave'), old('earned_leave', $row->earned_leave)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="carry_forward" class="col-form-label">{{ __('Carry Forward') }}:</label>
                                    <select name="carry_forward" id="carry_forward" class="form-control m_selectpicker">
                                        <option value="">Select Carry Forward</option>
                                        {!! selectBox(DB_enumValues('leaves', 'carry_forward'), old('carry_forward', $row->carry_forward)) !!}
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
    </form>
    <!--end::Form-->
@endsection {{-- Scripts --}} @section('scripts')
    <script>
        $("form#leaves").validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
                number_of_day: {
                    required: true,
                },
            },
            /*messages: {
        'name' : {required: 'Name is required',},'number_of_day' : {required: 'Number Of Day is required',},    },*/
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
