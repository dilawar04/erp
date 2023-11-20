@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="departments">
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
                                    {{--<label for="sub_department_name" class="col-form-label">{{ __('Sub Department Name') }}:</label>
                                    <input type="text" name="sub_department_name" id="sub_department_name" class="form-control" placeholder="{{ __('Sub Department Name') }}" value="{{ old('sub_department_name', $row->sub_department_name) }}" />--}}
                                    <label for="parent_id" class="col-form-label text-right">{{ __('Parent Type') }}:</label>
                                    <select class="form-control kt-select2" name="parent_id" id="parent_id">
                                        <option value="0">- Select -</option>
                                        @php
                                            $_M = new Multilevel();
                                            $_M->type = 'select';
                                            $_M->id_Column = 'id';
                                            $_M->title_Column = 'title';
                                            $_M->link_Column = 'title';
                                            $_M->option_html = '<option {selected} value="{id}">{level}{title}</option>';
                                            $_M->level_spacing = 6;
                                            $_M->selected = old('parent_id', $row->parent_id);
                                            $_M->query = "SELECT * FROM `departments` WHERE `status`='Active'";
                                            echo $_M->build();
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="title" class="col-form-label required">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}" />
                                </div>
                            </div>


                            @php
                                $clones = \App\Department::where('parent_id', $row->id)->get();
                                $clones = $clones->count() > 0 ? $clones : [null];
                            @endphp
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <h3>Add Sub Departments</h3>
                            <div class="clone_container">
                                @foreach($clones as $key => $clone)
                                <div class="form-group row mb-3 clone">
                                    <div class="col-lg-6">
                                        {{--<label for="title" class="col-form-label">{{ __('Sub Department Name') }}:</label>--}}
                                        <input type="hidden" name="ids[]" value="{{ $clone->id }}">
                                        <input type="text" name="sub_departments[{{ $clone->id }}]" id="sub_departments" class="sub-dep form-control" placeholder="{{ __('Department Name') }}" value="{{ old('sub_departments.' . $key, $clone->title) }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
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
@endsection {{-- Scripts --}}
@section('scripts')
    <script>
        function add_more_cb(){
            $('.clone').last().find('.sub-dep').prop('name', 'sub_departments[]');
        }

        $("form#departments").validate({
            // define validation rules
            rules: {
                title: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},    },*/
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
