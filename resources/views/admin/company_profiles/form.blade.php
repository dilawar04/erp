@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="static_blocks">
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
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-2">
                                    <label for="name" class="col-form-label required">Type:</label>
                                    <select class="form-control select" name="type" id="type">
                                        {!! selectBox(DB_enumValues($_this->table, 'type'), old('type', $row->type)) !!}
                                    </select>
                                </div>

                                <div class="col-lg-6 type-office">
                                    <label for="name" class="col-form-label required">Company:</label> <br>
                                    <select class="form-control select2 w-100" name="company_id" style="width: 100%">
                                        <option>- Select -</option>
                                        {!! selectBox("SELECT id, name FROM {$_this->table} WHERE type='Company'", old('company_id', $row->company_id)) !!}
                                    </select>
                                </div>
                            </div>

                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="name" class="col-form-label required">Company Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="company name" value="{{ old('name' ,$row->name) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="address" class="col-form-label required">Address:</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="address" value="{{ old('address', $row->address) }}" />
                                </div>
                            </div>

                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="form-group row">
                                <div class="col-lg-3">
                                    <label for="country" class="col-form-label required">Country:</label>
                                    <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="{{ old('country' ,$row->country) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="city" class="col-form-label required">City:</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ old('city' ,$row->city) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="state" class="col-form-label required">State:</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ old('state' ,$row->state) }}" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="postal_code" class="col-form-label required">Postal Code:</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" value="{{ old('postal_code' ,$row->postal_code) }}" />
                                </div>
                            </div>

                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="clone_container_email">
                                 @php
                                     $emails = json_decode($row->email ?? '[""]');
                                     $contact_numbers = json_decode($row->contact_number ?? '[""]');
                                 @endphp
                                 @foreach($emails as $index => $email)
                                        <div class="form-group row clone mb-2">
                                         <div class="col-lg-10">
                                             <label for="email" class="col-form-label required">Email:</label>
                                             <input type="text" name="email[]" id="email" class="form-control email" placeholder="Email" value="{{ old('email.' . $index, $emails[$index]) }}" />
                                         </div>
                                         <div class="col-lg-2" style="margin-top:37px;">
                                             <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_email" callback="add_more_cb_email"><i class="la la-plus"></i></button>
                                             <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_email-.clone"><i class="la la-trash"></i></button>
                                         </div>
                                        </div>
                                 @endforeach
                                </div> 
                                 <div class="clone_container_contact">
                                 @foreach($contact_numbers as $index => $contact_number)
                                        <div class="form-group row clone mb-2">
                                         <div class="col-lg-10">
                                             <label for="contact_number" class="col-form-label required">Contact Number:</label>
                                             <input type="text" name="contact_number[]" id="contact_number" class="form-control contact_number" placeholder="Contact Number" value="{{ old('contact_number.' . $index, $contact_numbers[$index]) }}" />
                                         </div>

                                         <div class="col-lg-2" style="margin-top:37px;">
                                             <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container_contact" callback="add_more_cb_contact"><i class="la la-plus"></i></button>
                                             <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container_contact-.clone"><i class="la la-trash"></i></button>
                                         </div>
                                        </div>
                                 @endforeach
                             </div>

                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="form-group row">
                                 <div class="col-lg-4">
                                    <label for="website" class="col-form-label required">Website:</label>
                                    <input type="text" name="website" id="website" class="form-control" placeholder="Website" value="{{ old('website' ,$row->website) }}" />
                                 </div>
                                 <div class="col-lg-4">
                                    <label for="map_location" class="col-form-label required">Map Location:</label>
                                    <input type="text" name="map_location" id="map_location" class="form-control" placeholder="Map Location" value="{{ old('map_location' ,$row->map_location) }}" />
                                 </div>
                                 <div class="col-lg-4">
                                    <label for="ntn" class="col-form-label required">NTN:</label>
                                    <input type="text" name="ntn" id="ntn" class="form-control" placeholder="NTN" value="{{ old('ntn' ,$row->ntn) }}" />
                                 </div>
                             </div>

                             <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                             <div class="form-group row">
                                 <div class="col-lg-6">
                                    <label for="sales_tax_number" class="col-form-label required">Sales Tax Number:</label>
                                    <input type="text" name="sales_tax_number" id="sales_tax_number" class="form-control" placeholder="Sales Tax Number" value="{{ old('sales_tax_number' ,$row->sales_tax_number) }}" />
                                 </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                             @php
                                $clones = \App\CompanyProfile::where('company_id', $row->id)->get();
                                $clones = $clones->count() > 0 ? $clones : json_decode('[{"email":"[\"\"]"}]');
                                if($row->type == 'Office')
                                    $clones = [];
                            @endphp

                            <div class="type-company">
                                @if(count($clones) > 0)
                                    <h1>Office Information</h1>
                                    <div class="clone_container_main_of">
                                        @foreach($clones as $index => $office)
                                            <div class="clone">
                                                <div class="border p-3 bg-light">
                                                    <div class="form-group row">
                                                        <div class="col-lg-6">
                                                            <label for="company_name" class="col-form-label required">Office Name:</label>
                                                            <input type="text" name="office[name][]" id="office_name" class="form-control office_name" placeholder="Office Name" value="{{ old('office_name.' . $index, $office->name) }}" />
                                                            <input type="hidden" name="office[id][]" value="{{ old('office.id.', $office->id) }}" />
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="address" class="col-form-label required">Address:</label>
                                                            <input type="text" name="office[address][]" id="office_address" class="form-control office_address" placeholder="Office Address" value="{{ old('office_address.' . $index, $office->address) }}" />
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label for="country" class="col-form-label required">Country:</label>
                                                            <input type="text" name="office[country][]" id="office_country" class="form-control office_country" placeholder="Office Country" value="{{ old('office_country.' . $index, $office->country) }}" />
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label for="city" class="col-form-label required">City:</label>
                                                            <input type="text" name="office[city][]" id="office_city" class="form-control office_city" placeholder="Office City" value="{{ old('office_city.' . $index, $office->city) }}" />
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label for="state" class="col-form-label required">State:</label>
                                                            <input type="text" name="office[state][]" id="office_state" class="form-control office_state" placeholder="Office State" value="{{ old('office_state.' . $index, $office->state) }}" />
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label for="postal_code" class="col-form-label required">Postal Code:</label>
                                                            <input type="text" name="office[postal_code][]" id="office_postal_code" class="form-control office_postal_code" placeholder="Office Postal Code" value="{{ old('office_postal_code.' . $index, $office->postal_code) }}" />
                                                        </div>
                                                    </div>
                                                    @foreach(json_decode($office->email) as $e_i => $email)
                                                        <div class="clone_container_offices">
                                                            <div class="clone_container_office form-group row">
                                                                <div class="col-lg-5">
                                                                    <label for="email" class="col-form-label required">Email(s):</label>
                                                                    <input type="text" name="office[email][{{ $index }}][]" class="form-control office_email" placeholder="Office Email" value="{{ old('office.email.' . $index . '.' . $emailIndex, $email) }}" />
                                                                </div>

                                                                <div class="col-lg-5">
                                                                    <label for="contact_number" class="col-form-label required">Contact Number:</label>
                                                                    <input type="text" name="office[contact_number][{{ $index }}][]" class="form-control office_contact_number" placeholder="Office Contact Number" value="{{ old('office.contact_number.' . $index, json_decode($office->contact_number)[$e_i]) }}" />
                                                                </div>

                                                                <div class="col-lg-2" style="margin-top:37px;">
                                                                    <button type="button" class="btn btn-success btn-icon add-office-container"><i class="la la-plus"></i></button>
                                                                    <button type="button" class="btn btn-danger btn-icon remove-office-container" remove-limit="1"><i class="la la-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="form-group row">
                                                        <div class="col-lg-4">
                                                            <label for="map_location" class="col-form-label required">Map Location:</label>
                                                            <input type="text" name="office[map_location][]" id="office_map_location" class="form-control office_map_location" placeholder="Office Map Location" value="{{ old('office_map_location.' . $index, $office->map_location) }}" />
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label for="sales_tax_number" class="col-form-label required">Sales Tax Number:</label>
                                                            <input type="text" name="office[sales_tax_number][]" id="office_sales_tax_number" class="form-control" placeholder="Office Sales Tax Number" value="{{ old('office_sales_tax_number.' . $index, $office->sales_tax_number) }}" />
                                                        </div>
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

                        <div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php $form_btn = new form_btn(); echo $form_btn->buttons($form_buttons); @endphp
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
        function add_more_cb_email(clone, clone_container_email){ 
            const index = clone_container_email.find('.clone').length - 1;
        }
        function add_more_cb_contact(clone, clone_container_contact){ 
            const index = clone_container_contact.find('.clone').length - 1;
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
            $('.email', clone).prop('name', 'email[]');
            $('.contact_number', clone).prop('name', 'contact_number[]');
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
