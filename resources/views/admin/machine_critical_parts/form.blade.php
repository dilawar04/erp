@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="machine_critical_parts">
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
                                 <div class="col-lg-4">
                                    <label for="part_name" class="col-form-label required">{{ __('Part Name') }}:</label>
                                    <input type="text" name="part_name" id="part_name" class="form-control" placeholder="{{ __('Part Name') }}" value="{{ old('part_name', $row->part_name) }}" />
                                </div>
                                <div class="col-lg-4">
                                    <label for="part_type" class="col-form-label">{{ __('Part Type') }}:</label>
                                        <select name="part_type" id="part_type" class="form-control m-select2 w-100">
                                        <option value="{{old('part_type', $row->part_type	)}}">Select Part Type</option>
                                        {!! selectBox(DB_enumValues('machine_critical_parts', 'part_type'), old('part_type', $row->part_type)) !!}
                                    </select>                               
                                    </div>
                                   
                                <div class="col-lg-4">
                                    <label for="part_life" class="col-form-label">{{ __('Part Life') }}:</label>
                                        <select name="part_life" id="part_life" class="form-control m-select2 w-100">
                                        <option value="{{old('part_life', $row->part_life	)}}">Select Part Life</option>
                                        {!! selectBox(DB_enumValues('machine_critical_parts', 'part_life'), old('part_life', $row->part_life)) !!}
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
        $("form#machine_manuals").validate({
            // define validation rules
            rules: {
                manual_type: {
                    required: true,
                },
            },
            /*messages: {
        'machine_id' : {required: 'Machine is required',},'name' : {required: 'Name is required',},    },*/
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
