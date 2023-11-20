@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="operations">
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
                            
                            
                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                             @php
                                $clones = \App\Operation::where('id', $row->id)->get();
                                $clones = $clones->count() > 0 ? $clones : json_decode('[{"operation_code":"[\"\"]"}]');
                                if($row->type == 'Operation')
                                    $clones = [];
                            @endphp

                            <div class="type-operation">
                                @if(count($clones) > 0)
                                    <h1>Operation</h1>
                                    <div class="clone_container_main_of">
                                        @foreach($clones as $index => $id)
                                            <div class="clone">
                                                <div class="border p-3 bg-light">
                                                    @foreach(json_decode($id->operation_code) as $c_i => $id_code)
                                                        <div class="clone_container_operations">
                                                            <div class="clone_container_operation form-group row">
                                                                <div class="col-lg-6">
                                                            <label for="id" class="col-form-label required">Operation:</label>
                                                            <input type="text" name="id[id][]" id="id" class="form-control operation_id" placeholder="ID" value="{{ old('id.' . $index, $operation->id) }}" />
                                                            <input type="hidden" name="id[id][]" value="{{ old('operation.id.', $operation->id) }}" />
                                                        </div>
                                                        <div class="col-lg-5">
                                             <label for="operation_code" class="col-form-label required">Operation Code(s):</label>
                                             <input type="text" name="operation_code[]" id="operation_code" class="form-control operation_code" placeholder="operation_code" value="{{ old('$operation->operation_code.' . $index, $operation->operation_code[$index]) }}" />
                                         </div>
                                        <div class="col-lg-5">
                                             <label for="operation_name" class="col-form-label required">Operation Name(s):</label>
                                             <input type="text" name="operation_name[]" id="operation_name" class="form-control operation_name" placeholder="operation_name" value="{{ old('$operation->operation_name.' . $index, $operation->operation_name[$index]) }}" />
                                         </div>

                                                                <div class="col-lg-2" style="margin-top:37px;">
                                                                    <button type="button" class="btn btn-success btn-icon add-office-container"><i class="la la-plus"></i></button>
                                                                    <button type="button" class="btn btn-danger btn-icon remove-office-container" remove-limit="1"><i class="la la-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="form-group row">
                                                        <div class="col-lg-4" style="margin-top:37px;text-align:end;">
                                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_main_of" callback="add_more_cb_main_of" style="width:30%;"><i class="la la-plus"></i>Add Office</button>
                                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_main_of-.clone"><i class="la la-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md" style="border-bottom: 2px dashed #ebedf2;"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                            
                           <!--  <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="clone_container_operat">
                                 @php
                                     $operation_codes = json_decode($row->operation_code ?? '[""]');
                                     $operation_names = json_decode($row->operation_name ?? '[""]');
                                 @endphp
                                 @foreach($operation_codes as $index => $operation_code)
                                        <div class="form-group row clone mb-2">
                                         <div class="col-lg-5">
                                             <label for="operation_code" class="col-form-label required">Operation Code:</label>
                                             <input type="text" name="operation_code[]" id="operation_code[]" class="form-control operation_code" placeholder="OperationCode" value="{{ old('operation_code.' . $index, $operation_codes[$index]) }}" />
                                         </div>
                                         <div class="col-lg-5">
                                             <label for="operation_name" class="col-form-label required">Operation Name:</label>
                                             <input type="text" name="operation_name[]" id="operation_name" class="form-control operation_name" placeholder="Operation Name" value="{{ old('operation_name.' . $index, $operation_names[$index]) }}" />
                                         </div 
                                         <div class="col-lg-2" style="margin-top:37px;">
                                             <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_operat" callback="add_more_cb_operat"><i class="la la-plus"></i></button>
                                             <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_operat-.clone"><i class="la la-trash"></i></button>
                                         </div>
                                        </div>
                                 @endforeach
                                </div> 
                                
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                             @php
                                $clones = \App\Operation::where($row->id)->get();
                                $clones = $clones->count() > 0 ? $clones : json_decode('[{"code":"[\"\"]"}]');
                                if($row->type == 'Operation')
                                    $clones = [];
                            @endphp

                            <div class="type-operation">
                               @if(count($clones) > 0)
                                    <div class="clone_container_main_operation">
                                        @foreach($clones as $index => $operation)    
                                         <div class="clone">
                                            <h1>Operation </h1>
                                            <div class="border p-3 bg-light">
                                                    <div class="form-group row clone mb-2">
                                                                <div class="col-lg-5">
                                                                    <label for="operation_code" class="col-form-label required">Operation Code:</label>
                                                                    <input type="text" name="operation[operation_code][{{ $index }}][]" class="form-control operation_code" placeholder="Operation Code" value="{{ old('operation.operation_code.' . $index . '.' . $operation_codeIndex, $operation_code) }}" />
                                                                </div>
                                                                
                                                                <div class="col-lg-5">
                                                                    <label for="operation_name" class="col-form-label required">Operation Name:</label>
                                                                    <input type="text" name="operation[operation_name][{{ $index }}][]" class="form-control operation_name" placeholder="Operation Name" value="{{ old('operation.operation_name.' . $index, json_decode($operation->operation_name)[$e_i]) }}" />
                                                                </div>
                                                                
                                                                <div class="col-lg-2" style="margin-top:37px;">
                                                                    <button type="button" class="btn btn-success btn-icon add-operation"><i class="la la-plus"></i></button>
                                                                    <button type="button" class="btn btn-danger btn-icon remove-operation" remove-limit="1"><i class="la la-trash"></i></button>
                                                                </div>
                                                            </div>

                                                    
                                                        <div class="col-lg-4" style="margin-top:37px;text-align:end;">
                                                            <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_main_operation" callback="add_more_cb_main_operation" style="width:30%;"><i class="la la-plus"></i>Add Office</button>
                                                            <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_main_operation-.clone"><i class="la la-trash"></i></button>
                                                        </div>
                                                    </div>
                                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md" style="border-bottom: 2px dashed #ebedf2;"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
  
                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php $form_btn = new form_btn(); echo $form_btn->buttons($form_buttons); @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>-->
    <!--end::Form-->
@endsection {{-- Scripts --}} @section('scripts')
    <script>
        function add_more_cb(clone, clone_container_email){ 
            const index = clone_container.find('.clone').length - 1;
        }
       
        
        $('#type').on('change', function () {
            if ($(this).val() == 'Office') {
                $('.type-office').show()
                $('.type-company').hide()
            } else {
                $('.type-office').hide()
                $('.type-company').show()
            }
        })
        $('#type').trigger('change');

        var cardCount = 1;
        var name = 0;

        function add_more_cb(clone){
            $('.operation_code', clone).prop('name', 'operation_code[]');
            $('.operation_name', clone).prop('name', 'operation_name[]');
        }

        $(".add-more-office").on("click",function(){
            $('.clone_container_main_of').addClass('d-block').removeClass('d-none');
            // $(".clone_container_main_of").css("display","block")
            $(".add-more-office").css("display","none")
        });

        $(document).on("click", ".add-office-container", function(){
          cardCount++;
          var card = $(this).closest('.clone_container_office').parent().html();
          $(this).closest('.clone_container_offices').after('<div class="clone_container_offices">' + card + '</div>');
        });

        // Remove a card based on the "delete" button class
        // $(document).on("click", ".remove-office-container", function(){
        //   var card = $(this).closest('.clone_container_office').parent();
        //   card.remove();
        // });

        $(document).on("click", ".remove-office-container", function(){
          if (cardCount > 1) {
          var card = $(this).closest('.clone_container_office').parent();
            card.remove();
            cardCount--;
          }
        });
        // function add_more_cb_of(){
            // alert(2);
            // $('.clone').last().find('.office_email').prop('name', 'office_email[]');
            // $('.clone').last().find('.office_contact_number').prop('name', 'office_contact_number[]');
        // }
        function add_more_cb_main_of(clone){
            name++;
            $('.clone_container_office:gt(0)', clone).remove();

            $('.office_name', clone).prop('name', 'office[name][]');
            $('.office_address', clone).prop('name', 'office[address][]');
            $('.office_country', clone).prop('name', 'office[country][]');
            $('.office_city', clone).prop('name', 'office[city][]');
            $('.office_state', clone).prop('name', 'office[state][]');
            $('.office_postal_code', clone).prop('name', 'office[postal_code][]');
            $('.office_email', clone).prop('name', 'office[email][' + name + '][]');
            $('.office_contact_number', clone).prop('name', 'office[contact_number][' + name + '][]');
            $('.office_map_location', clone).prop('name', 'office[map_location][]');
            $('.office_sales_tax_number', clone).prop('name', 'office[sales_tax_number][]');
        }


        $("form#company_profiles").validate({
            // define validation rules
            rules: {
                company_name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                 country: {
                    required: true,
                },
                email: {
                    required: true,
                },
                contact_number: {
                    required: true,
                },
            },
            /*messages: {
        'title' : {required: 'Title is required',},'code' : {required: 'Code is required',},    },*/
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