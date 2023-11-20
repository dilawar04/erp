@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')
@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="finished_product_stocks">
        @csrf @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" class="form-control" placeholder="{{ __('ID') }}" value="{{ old('id', $row->id) }}" />
            <!-- begin:: Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head') @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                   <div class="col-lg-6">
                                    <label for="opening_quantity" class="col-form-label required">Opening Quantity:</label>
                                    <input type="text" name="opening_quantity" id="opening_quantity" class="form-control" placeholder="Opening Quantity" value="{{ old('opening_quantity', $row->opening_quantity) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="stock_rate" class="col-form-label required">Stock Rate:</label>
                                    <input type="text" name="stock_rate" id="stock_rate" class="form-control" placeholder="Stock Rate" value="{{ old('stock_rate', $row->stock_rate) }}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="stock_value" class="col-form-label required">Stock Value:</label>
                                    <input type="text" name="stock_value" id="stock_value" class="form-control" placeholder="Stock Value" value="{{old('stock_value', $row->stock_value)}}" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="opening_date" class="col-form-label required">Opening Date:</label>
                                    <input type="datetime-local" name="opening_date" id="opening_date" class="form-control" placeholder="Opening Date" value="{{old('opening_date', $row->opening_date)}}" />
                                </div>

                                 <div class="col-lg-6">
                                      <label for="unit_id" class="col-form-label required">Unit Id:</label>
                                                <select name="unit_id" id="unit_id" class="form-control m_selectpicker" >
                                               <option value="">Select Unit Id</option>
                                         {!! selectBox(DB_enumValues('units', 'unit_id'), old('unit_id', $row->unit_id)) !!}
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
         $(form#finished_product_stocks).on('click', '.is_stations', function() {
                let is_stations = $(this).val();

                if (is_stations == 'true') {
                    $('#is_stations-input-area').find('input[name="is_stations"]').addClass('input-required');
                    $('#is_stations-input-area').show();
                } else {
                    $('#is_stations-input-area').find('input[name="is_stations"]').removeClass('input-required');
                    $('#is_stations-input-area').hide();
                }
            });

            $(form#finished_product_stocks).on('click', '#modal-submit-button', function() {
                if (!checkRequiredInputs()) {
                    notify(2, 'Please fill required inputs.');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: "{{ url('admin') }}",
                    type: 'POST',
                    data: $('#modal-form').serialize(),
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        notify(response.status, response.message);
                    }
                });
            });
            $(document).on('click', '.edit-button', function() {
                let url = "{{ url('admin', ":id") }}";
                var id = $(this).data('id');
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'Json',
                    success: function(response) {
                        if (response.status) {
                            $('#modal-heading').text('Edit OEM');
                            $('#modal-body').html(response.data);
                            if ($('#station_checked').val() == 'true') {
                                $('#stations-input-area').show();
                            } else {
                                $('#stations-input-area').hide();
                            }
                            $('#modal').show();
                        } else {
                            notify(response.status, response.message);
                        }
                    }
                });
            });

        $("form#finished_product_stocks").validate({
            // define validation rules
            rules: {
                opening_quantity: {
                    required: true,
                },
                opening_date: {
                    required: true,
                },
                stock_value: {
                    required: true,
                },
            },
            /*messages: {
        'opening_quantity' : {required: 'opening_quantity is required',},'opening_date' : {required: 'opening_date is required',},'stock_value' : {required: 'stock_value is required',},    },*/
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
