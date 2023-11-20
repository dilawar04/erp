
@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="calendar_setup">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
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
                                    <label for="week_starts_form" class="col-form-label required">{{ __('Week Starts Form') }}</label>
                                    <select name="week_starts_form" id="week_starts_form" class="form-control select">
                                        <option value="">Select Week Starts Form</option>
                                        {!! selectBox(DB_enumValues('calendar_setup', 'week_starts_form'), old('week_starts_form', $row->week_starts_form)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    @php
                                        // Decode the JSON string into a PHP array
                                        $working_days = json_decode($row->working_days);
                                        $public_holiday_names = json_decode($row->public_holiday_name ?? "[{}]" );
                                        $public_holiday_dates = json_decode($row->public_holiday_date);
                                    @endphp
                                    <label for="days" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Days') }}:</label>
                                    <select class="m-select2 w-100" name="working_days[]" multiple="multiple">
                                            @php
                                                $_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                            @endphp
                                            {!! selectBox(array_combine($_days, $_days), $working_days) !!}
                                    </select>
                                </div>
                            </div>
                           
                            <h3 class="pt-3">Public Holiday</h3>
                            <div class="clone_container">
                                @foreach($public_holiday_names as $index => $public_holiday_name)
                                    <div class="form-group row mb-3 clone">
                                        <div class="col-lg-5">
                                            <label for="c" class="col-form-label">{{ ('Public Holiday Name') }}</label>
                                            <input type="text" name="public_holiday_name[]" class="sub-dep form-control" placeholder="{{('Public Holiday Name')}}" value="{{ old('public_holiday_name.' . $index, $public_holiday_name) }}" />
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="public_holiday_date" class="col-form-label">{{('Public Holiday Date')}}</label>
                                            <input type="date" name="public_holiday_date[]" class="sub-dep form-control" placeholder="{{ __('Public Holiday Date') }}" value="{{ old('public_holiday_name.' . $index, $public_holiday_dates[$index]) }}" />
                                        </div>
                                        <div class="col-lg-2" style="margin-top: 37px;">
                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                  </div>
                                @endforeach
                            
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
        $("form#calendar_setup").validate({
            // define validation rules
            rules: {
                public_holiday_name: {
                    required: true,
                },
                public_holiday_date: {
                    required: true,
                },
            },
            /*messages: {
        'public_holiday_name' : {required: 'public holiday name is required',},'public_holiday_date' : {required: 'public holiday date is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
        
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop(['name' => 'public_holiday_name[]','name' => 'public_holiday_date[]']);
        }
        
    </script>
@endsection
