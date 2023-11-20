@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="skills">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}"/>
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-3">
                                    <label for="type" class="col-form-label required">{{ __('Type') }}:</label>
                                    <select name="type" id="type" class="form-control m_selectpicker">
                                        {!! selectBox(DB_enumValues('skills', 'type'), old('type', $row->type)) !!}
                                    </select>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-5">
                                    <label for="skill" class="col-form-label required">{{ __('Skill') }}:</label>
                                    <input type="text" name="skill" id="skill" class="form-control" placeholder="{{ __('Skill') }}" value="{{ old('skill', $row->skill) }}"/>
                                </div>

                                <div class="col-lg-3 worker-block">
                                    <label for="workstation_id" class="col-form-label">{{ __('Workstation') }}:</label><br>
                                    <select name="workstation_id" id="workstation_id" class="form-control m-select2" style="width: 100%">
                                        <option value="">- Select -</option>
                                        {!! selectBox("SELECT id, name FROM workstations", old('workstation_id', $row->workstation_id)) !!}
                                    </select>
                                </div>
                                <div class="col-lg-4 worker-block">
                                    <label for="weightage" class="col-form-label">{{ __('Weightage') }}:</label>
                                    <select name="weightage" id="weightage" class="form-control m-select2" style="width: 100%">
                                        {!! selectBox([1 => '1 - Helper Work',
                                        2 => '2 - Low Skill Manual Work',
                                        3 => '3 - Low Skill Machine Work',
                                        4 => '4 - High Skill Manual Work',
                                        5 => '5 - High Skill Machine Work',
                                        ], old('weightage', $row->weightage)) !!}
                                    </select>

                                    {{--<input type="text" name="weightage" id="weightage" class="form-control" placeholder="{{ __('Weightage') }}" value="{{ old('weightage', $row->weightage) }}"/>--}}
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
@endsection {{-- Scripts --}}
@section('scripts')
    <script>
        $('#type').on('change', function (){
            const _this = $(this);
            if(_this.val() == 'Workers')
                $('.worker-block').show().find('select').attr('disabled', false)
            else
                $('.worker-block').hide().find('select').attr('disabled', true)
        });
        $('#type').trigger('change');

        $("form#skills").validate({
            // define validation rules
            rules: {
                skill: {
                    required: true,
                },
                type: {
                    required: true,
                },
            },
            /*messages: {
                'skill' : {required: 'Skill is required',},'type' : {required: 'Type is required',},    },*/
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
