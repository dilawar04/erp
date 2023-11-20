@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
 <style>
        .select2-container--default{
            width: 100% !important;
        }
    </style>
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="grades">
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
                                <div class="col-lg-3">
                                    <label for="salary_range_from" class="col-form-label required">{{ __('Salary Range From') }}:</label>
                                    <input type="text" name="salary_range_from" id="salary_range_from" class="form-control" placeholder="{{ __('Salary Range From') }}" value="{{ old('salary_range_from', $row->salary_range_from) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="salary_range_to" class="col-form-label required">{{ __('Salary Range To') }}:</label>
                                    <input type="text" name="salary_range_to" id="salary_range_to" class="form-control" placeholder="{{ __('Salary Range To') }}" value="{{ old('salary_range_to', $row->salary_range_to) }}" />
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="clone_container">
                                <div class="clone">
                                    <div class="form-group row justify-content-center">
                                        <div class="col-lg-4">
                                            <label for="allowance_id" class="col-form-label required">{{ __('Allowance') }}:</label>
                                            <select name="allowance_id" id="allowance_id" class="form-control -m-select2">
                                                {!! selectBox("SELECT id, name, type FROM allowance_benefits", old('allowance_id', $row->allowance_id), '<option {selected} value="{id}" data-type="{type}">{name} ({type})</option>') !!}
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="employers_contribution" class="col-form-label">{{ __('Employers Contribution') }}:</label>
                                            <input type="text" name="employers_contribution" id="employers_contribution" class="form-control" placeholder="{{ __('Employers Contribution') }}" value="{{ old('employers_contribution', $row->employers_contribution) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="employers_contribution" class="col-form-label">{{ __('Employers Contribution') }}:</label><br>
                                            <input type="text" name="employers_contribution" id="employers_contribution" class="form-control" placeholder="{{ __('Employers Contribution') }}" value="{{ old('employers_contribution', $row->employers_contribution) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="total" class="col-form-label">{{ __('Total') }}:</label><br>
                                            <input type="text" name="total" id="total" class="form-control" placeholder="{{ __('Total') }}" value="{{ old('total', $row->total) }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="col-form-label">&nbsp;</label><br>
                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                </div>
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="clone_container_leaves form-group row">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $leaves_ids = json_decode($row->leaves_id ?? "[{}]");
                                @endphp

                                 @foreach($leaves_ids as $index => $leaves_id)
                                    <div class="clone mb-2 col-lg-3">
                                        <div class="">
                                            <label for="leaves_id" class="col-form-label">{{ __('Leave') }}:</label>
                                            <select class="form-control m-select2 w-100" name="leaves_id[{{ $index }}][]" >
                                                <option value="">Select Leave</option>
                                                {!! selectBox("SELECT id, name FROM leaves", old('leaves_id', $leaves_ids[$index])) !!}
                                            </select>
                                        </div>
                                        <div class="col-lg-6" style="margin-top:37px;">
                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_leaves" callback="leaves_btn"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_leaves-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
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

        $('#allowance_id').on('change', function (){
            const _this = $(':selected',this);
            const _data = _this.data();
            alert(_data.type)
            if(_data.type == 'Fixed'){

            } else {

            }
        })

        function leaves_btn(clone, clone_container_leaves){
            const index = clone_container_leaves.find('.clone').length - 1;
            $('select[multiple]', clone).attr('name', 'leaves_id['+ index +'][]');
            $('.select2-container', clone).remove();
            $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
            $('.m-select2', clone).select2();
        }
        $("form#grades").validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
                salary_range_from: {
                    required: true,
                },
                salary_range_to: {
                    required: true,
                },

            },
            /*messages: {
        'name' : {required: 'Name is required',},'salary_range_from' : {required: 'Salary Range From is required',},'salary_range_to' : {required: 'Salary Range To is required',},'allowance_id' : {required: 'Allowance ID is required',},    },*/
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
