@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="shift_overtimes">
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
                        <div class="col-lg-6" style="margin-top:37px;">
                            <select class="m-select2 w-100 multiple-form">
                            	<option value="shift" selected>Shift</option>
                            	<option value="overtime">Overtime</option>
                            </select>
                        </div>  
                        @php
                            $shift_names = json_decode($row->shift_name);
                            $start_times = json_decode($row->start_time);
                            $end_times = json_decode($row->end_time);
                        @endphp
                        <div class="kt-portlet__body body_shift" id="showshift">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="shift_name" class="col-form-label required">{{ __('Shift Name') }}:</label>
                                    <input type="text" name="shift_name[0][]" id="shift_name" class="form-control" placeholder="{{ __('Shift Name') }}" value="{{ old('shift_name', $shift_names[0][0]) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="start_time" class="col-form-label required">{{ __('Start Time') }}:</label>
                                    <input type="time" name="start_time[0][]" id="start_time" class="form-control" placeholder="{{ __('Start Time') }}" value="{{ old('start_time', $start_times[0][0]) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="end_time" class="col-form-label required">{{ __('End Time') }}:</label>
                                    <input type="time" name="end_time[0][]" id="end_time" class="form-control" placeholder="{{ __('End Time') }}" value="{{ old('end_time', $end_times[0][0]) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="late_till" class="col-form-label">{{ __('Late Till') }}:</label>
                                    <input type="time" name="late_till" id="late_till" class="form-control" placeholder="{{ __('Late Till') }}" value="{{ old('late_till', $row->late_till) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="half_day_from" class="col-form-label">{{ __('Half Day From') }}:</label>
                                    <input type="time" name="half_day_from" id="half_day_from" class="form-control" placeholder="{{ __('Half Day From') }}" value="{{ old('half_day_from', $row->half_day_from) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="clone_container">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $b_names = json_decode($row->b_name ?? "[{}]" );
                                    $b_froms = json_decode($row->b_from);
                                    $b_tills = json_decode($row->b_till);
                                    $days = json_decode($row->days);
                                    $types = json_decode($row->type );
                                    if(empty($types)){
                                        $types = 'shift';
                                    }
                                @endphp

                                @foreach($b_names as $index => $b_name)
                                 @if($types[$index] == 'shift' || $types == 'shift')
                                    <div class="from-group row mb-3 clone">
                                        <select class="d-none" name="type[]">
                                    	    <option value="shift" selected>shift</option>
                                        </select>
                                        <div class="col-lg-4">
                                            <label for="b_name" class="col-form-label required">{{ __('Break Name') }}:</label>
                                            <input type="text" name="b_name[]" class="form-control" placeholder="{{ __('Break Name') }}" value="{{ old('b_name.' . $index, $b_name) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="b_from" class="col-form-label">{{ __('Break From') }}:</label>
                                            <input type="time" name="b_from[]" class="form-control" placeholder="{{ __('Break From') }}" value="{{ old('b_from.' . $index, $b_froms[$index]) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="b_till" class="col-form-label">{{ __('Break Till') }}:</label>
                                            <input type="time" name="b_till[]" class="form-control" placeholder="{{ __('Break Till') }}" value="{{ old('b_till.' . $index, $b_tills[$index]) }}" />
                                        </div>
                                        <div style="margin-top: 36px;">
                                            <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                 @endif
                                @endforeach
                             </div>
                         </div>
                        <div class="kt-portlet__body body_shift" id="showshift">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="days" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Days') }}:</label>
                                    <select class="m-select2 w-100" name="days[0][]" multiple="multiple">
                                        @php
                                            $_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                        @endphp
                                        {!! selectBox(array_combine($_days, $_days), $days[0]) !!}
                                    </select>
                                </div>     
                            </div>
                        </div> 

                        <div class="kt-portlet__body body_overtime" id="showovertime">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="shift_name" class="col-form-label required">{{ __('Overtime Name') }}:</label>
                                    <input type="text" name="shift_name[1][]" id="shift_name" class="form-control" placeholder="{{ __('Shift Name') }}" value="{{ old('shift_name', $shift_names[1][0]) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="start_time" class="col-form-label required">{{ __('Start Time') }}:</label>
                                    <input type="time" name="start_time[1][]" id="start_time" class="form-control" placeholder="{{ __('Start Time') }}" value="{{ old('start_time', $start_times[1][0]) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="end_time" class="col-form-label required">{{ __('End Time') }}:</label>
                                    <input type="time" name="end_time[1][]" id="end_time" class="form-control" placeholder="{{ __('End Time') }}" value="{{ old('end_time', $end_times[1][0]) }}" />
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="clone_container_overtime">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $b_names = json_decode($row->b_name ?? "[{}]" );
                                    $b_froms = json_decode($row->b_from);
                                    $b_tills = json_decode($row->b_till);
                                    $days = json_decode($row->days ?? "[{}]");
                                    $types = json_decode($row->type );
                                    if(empty($types)){
                                        $types = 'overtime';
                                    }
                                @endphp

                                @foreach($b_names as $index => $b_name)
                                 @if($types[$index] == 'overtime' || $types == 'overtime')
                                    <div class="from-group row mb-3 clone">
                                        <select class="d-none" name="type[]">
                                    	    <option value="overtime" selected>overtime</option>
                                        </select>
                                        <div class="col-lg-4">
                                            <label for="b_name" class="col-form-label required">{{ __('Break Name') }}:</label>
                                            <input type="text" name="b_name[]" class="form-control b_name" placeholder="{{ __('Break Name') }}" value="{{ old('b_name.' . $index, $b_name) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="b_from" class="col-form-label">{{ __('Break From') }}:</label>
                                            <input type="time" name="b_from[]" class="form-control b_from" placeholder="{{ __('Break From') }}" value="{{ old('b_from.' . $index, $b_froms[$index]) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="b_till" class="col-form-label">{{ __('Break Till') }}:</label>
                                            <input type="time" name="b_till[]" class="form-control b_till" placeholder="{{ __('Break Till') }}" value="{{ old('b_till.' . $index, $b_tills[$index]) }}" />
                                        </div>
                                        <div style="margin-top: 36px;">
                                            <button type="button" class="btn btn-success btn-icon add-more"   clone-container=".clone_container_overtime" callback="add_more_cb_overtime"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container_overtime-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                 @endif
                                @endforeach
                             </div>
                         </div>
                        <div class="kt-portlet__body body_overtime" id="showovertime">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="days" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Days') }}:</label>
                                    <select class="m-select2 w-100" name="days[1][]" multiple="multiple">
                                        @php
                                            $_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                        @endphp
                                        {!! selectBox(array_combine($_days, $_days), $days[1]) !!}
                                    </select>
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
       $(document).ready(function(){
// 			$("#overtime").hide();
    			$("div.body_overtime").hide();

    		$('.multiple-form').on('change', function(){
    			var value = $(this).val(); 
    // 			console.log(value);
    // 			$("div.body_shift").hide();
    			if(value == 'shift'){
        			$("div.body_shift").show();
        			$("div.body_overtime").hide();
    			}
    			else if(value == 'overtime'){
        			$("div.body_overtime").show();
                    $("div.body_shift").hide();
    			}
    // 			$("#show"+demovalue).show();
    		});
        });
        // function add_more_cb(){
        //     $('.clone').last().find('.b_name').prop('name', 'b_name[]');
        //     $('.clone').last().find('.b_from').prop('name', 'b_from[]');
        //     $('.clone').last().find('.b_till').prop('name', 'b_till[]');
        // } 
        function add_more_cb_overtime(clone, clone_container_overtime){ 
            const index = clone_container.find('.clone').length - 1;
            // $('select[multiple]', clone).attr('name', 'days['+ index +'][]');

            // $('.select2-container', clone).remove();
            // $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
            // $('.m-select2', clone).select2();
        }
        function add_more_cb(clone, clone_container){
            const index = clone_container.find('.clone').length - 1;
            // $('select[multiple]', clone).attr('name', 'days['+ index +'][]');

            // $('.select2-container', clone).remove();
            // $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
            // $('.m-select2', clone).select2();
        }

        $("form#shift_overtimes").validate({
            // define validation rules
            rules: {
                shift_name: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },
                brake_name: {
                    required: true,
                },
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
