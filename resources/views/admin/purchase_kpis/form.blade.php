
@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="purchase_kpis">
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
                            <div class="clone_container">
                            <div class="form-group row mb-3 clone">
                                 <div class="col-lg-6">
                                        <label for="purchase_proposal_approval_lead_time" class="col-form-label">{{ ('Purchase Proposal Approval Lead Time') }}</label>
                                        <input type="datetime-local" name="purchase_proposal_approval_lead_time[]" id="purchase_proposal_approval_lead_time" class="sub-dep form-control" placeholder="{{('Purchase Proposal Approval Lead Time') }}" value="{{ old('purchase_proposal_approval_lead_time', $row->purchase_proposal_approval_lead_time) }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="purchase_order_approval_lead_time" class="col-form-label">{{ ('Purchase Order Approval Lead Time') }}</label>
                                        <input type="datetime-local" name="purchase_order_approval_lead_time[]" id="purchase_order_approval_lead_time" class="sub-dep form-control" placeholder="{{('Purchase Order Approval Lead Time') }}" value="{{ old('purchase_order_approval_lead_time', $row->purchase_order_approval_lead_time) }}" />
                                    </div>
                                     <div class="col-lg-6">
                                        <label for="purchase_order_issue_lead_time" class="col-form-label">{{ ('Purchase Order Issue Lead Time') }}</label>
                                        <input type="datetime-local" name="purchase_order_issue_lead_time[]" id="purchase_order_issue_lead_time" class="sub-dep form-control" placeholder="{{('Purchase Order Issue Lead Time') }}" value="{{ old('purchase_order_issue_lead_time', $row->purchase_order_issue_lead_time) }}" />
                                    </div>
                                   <div class="col-lg-4"style="margin-top: 37px;">
                                        <button type="button" class="btn btn-success btn-icon add-more" clone-container=".clone_container" callback="add_more_cb"><i class="la la-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".clone_container-.clone"><i class="la la-trash"></i></button>
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
