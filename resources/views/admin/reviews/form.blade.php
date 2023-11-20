@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="reviews">
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

                        <div class="kt-portlet__body">


                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="user_id" class="col-form-label">{{ __('User') }}:</label>
                                    <select name="user_id" id="user_id" class="form-control m-select2-ajax" data-data_ele="" data-url="<?php echo admin_url('profile/AJAX/users/?type=5')?>">
                                        <option value="">Select User</option>
                                        {!! selectBox("SELECT id, TRIM(CONCAT_WS(' ', first_name, last_name)) as name FROM users WHERE id='{$row->user_id}'", $row->user_id) !!}
                                    </select>
                                </div>

                                <div class="col-lg-5">
                                    <label for="nickname" class="col-form-label">{{ __('Nickname') }}:</label>
                                    <input type="text" name="nickname" id="nickname" class="form-control" placeholder="{{ __('Nickname') }}" value="{{ old('nickname', $row->nickname) }}"/>
                                </div>

                                <div class="col-lg-1">
                                    <label for="rating" class="col-form-label">{{ __('Rating') }}:</label>
                                    <input type="text" name="rating" id="rating" class="form-control"
                                        placeholder="{{ __('Rating') }}" value="{{ old('rating', $row->rating) }}"/>
                                </div>

                                <div class="col-lg-2">
                                    <label for="status" class="col-form-label">{{ __('Status') }}:</label>
                                    <select name="status" id="status" class="form-control m_selectpicker">
                                        <option value="">Select Status</option>
                                        {!! selectBox(DB_enumValues('reviews', 'status'), old('status', $row->status)) !!}
                                    </select>
                                </div>

                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="title" class="col-form-label">{{ __('Title') }}:</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title', $row->title) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="review" class="col-form-label required">{{ __('Review') }}:</label>
                                    <textarea name="review" id="review" class="form-control" placeholder="{{ __('Review') }}" cols="30" rows="5">{{ old('review', $row->review) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

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

        $("form#reviews").validate({
            // define validation rules
            rules: {
                'review': {
                    required: true,
                },
            },
            /*messages: {
            'review' : {required: 'Review is required',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                KTUtil.scrollTop();
                //validator.errorList[0].element.focus();
            },
            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>@endsection
