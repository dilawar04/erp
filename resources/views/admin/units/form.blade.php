@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="units_machines">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}"
                   value="{{ old('id', $row->id) }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>
                        <div class="col-lg-6" style="margin-top:37px;">
                            <select class="m-select2 w-100 multiple-form" name="days[]">
                            	<option value="Machine" selected>Machine</option>
                            	<option value="Material">Material</option>
                            </select>
                        </div>    
                        <div class="kt-portlet__body" id="showMachine">
                            <div class="clone_container">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $parameters = json_decode($row->parameter ?? "[{}]" );
                                    $types = json_decode($row->type );
                                    if(empty($types)){
                                        $types = 'Machine';
                                    }
                                    $units = json_decode($row->unit);
                                    $symbols = json_decode($row->symbol);
                                @endphp

                                @foreach($parameters as $index => $parameter)  
                                    @if($types[$index] == 'Machine' || $types == 'Machine')
                                    <div class="from-group row mb-3 clone" style="border-bottom: 1px dashed #151d31;padding-bottom: 40px;">
                                        <select class="d-none" name="type[]">
                                        	<option value="Machine" selected>Machine</option>
                                        </select>
                                        <div class="col-lg-3">
                                            <label for="parameter" class="col-form-label">{{ __('Parameter') }}:</label>
                                            <input type="text" name="parameter[]" id="parameter" class="form-control" placeholder="{{ __('Parameter') }}" value="{{ old('parameter.' . $index, $parameter) }}" />
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="unit" class="col-form-label required">{{ __('Unit') }}:</label>
                                            <input type="text" name="unit[]" id="unit" class="form-control" placeholder="{{ __('Unit') }}" value="{{ old('unit.' . $index, $units[$index]) }}" />
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="symbol" class="col-form-label">{{ __('Symbol') }}:</label>
                                            <input type="text" name="symbol[]" id="symbol" class="form-control" placeholder="{{ __('Symbol') }}" value="{{ old('symbol.' . $index, $symbols[$index]) }}" />
                                        </div>
                                        <div class="col-lg-2" style="margin-top:37px;">
                                            <button type="button" class="btn btn-success btn-icon add-more + "   clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                           </div>
                        </div>
                        
                        <div class="kt-portlet__body" id="showMaterial">
                            <div class="clone_container_as">
                                @php
                                    // Decode the JSON string into a PHP array
                                    $units = json_decode($row->unit ?? "[{}]" );
                                    $types = json_decode($row->type );
                                    $symbols = json_decode($row->symbol);
                                    if(empty($types)){
                                        $types = 'Material';
                                    }
                                @endphp

                                @foreach($units as $index => $unit) 
                                    @if($types[$index] == 'Material' || $types == 'Material')
                                    <div class="from-group row mb-3 clone" style="border-bottom: 1px dashed #151d31;padding-bottom: 40px;">
                                        <select class="d-none" name="type[]">
                                        	<option value="Material" selected>Material</option>
                                        </select>
                                        <div class="col-lg-5">
                                            <label for="unit" class="col-form-label required">{{ __('Unit') }}:</label>
                                            <input type="text" name="unit[]" id="unit" class="form-control" placeholder="{{ __('Unit') }}" value="{{ old('unit.' . $index, $units[$index]) }}" />
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="symbol" class="col-form-label">{{ __('Symbol') }}:</label>
                                            <input type="text" name="symbol[]" id="symbol" class="form-control" placeholder="{{ __('Symbol') }}" value="{{ old('symbol.' . $index, $symbols[$index]) }}" />
                                        </div>
                                        <div class="col-lg-2" style="margin-top:37px;">
                                            <button type="button" class="btn btn-success btn-icon add-more + "   clone-container=".clone_container_as" callback="add_more_cb_as"><i class="la la-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon Danger"  remove-limit="1" remove-el=".clone_container_as-.clone"><i class="la la-trash"></i></button>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                           </div>
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
        $(document).ready(function(){
			$("#showMaterial").hide();
    		$('.multiple-form').on('change', function(){
    			var demovalue = $(this).val(); 
    			$("div.kt-portlet__body").hide();
    			$("#show"+demovalue).show();
    		});
        });
        function add_more_cb_as(clone, clone_container_as){
            const index = clone_container.find('.clone').length - 1;
        }
        $("form#units_machines").validate({
            // define validation rules
            rules: {
                'unit': {
                    required: true,
                },
            },
            /*messages: {
            'unit' : {required: 'Unit is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>
@endsection
