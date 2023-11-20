@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="message_template">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="msg_id" class="form-control" placeholder="{{ __('Msg ID') }}" value="{{ old('msg_id', $row->msg_id) }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-9">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="name" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control" {{ ($row->id > 0 ? 'readonly' : '') }} placeholder="{{ __('Name') }}" value="{{ old('name', $row->name) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="subject" class="-col-lg-2 -col-sm-12 -col-form-label required">{{ __('Subject') }}:</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="{{ __('Subject') }}" value="{{ old('subject', $row->subject) }}"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="message" class="-col-lg-2 -col-sm-12 -col-form-label">{{ __('Message') }}:</label>
                                    <br>
                                    <textarea  name="message" id="message" placeholder="{{ __('Message') }}" class="editor form-control" cols="200" rows="5">{{ old('message', $row->message) }}</textarea>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                        </div>

                        {{--<div class="kt-portlet__foot">
                            <div class="btn-group">
                                @php
                                    $Form_btn = new Form_btn();
                                    echo $Form_btn->buttons($form_buttons);
                                @endphp
                            </div>
                        </div>--}}

                    </div>
                </div>

                <div class="col-lg-3">

                    <?php
                    $_tags['Basic Tags'] = [
                        'config' => ['title' => 'Basic Tags', 'icon' => 'la la-home la-2x'],

                        'site_title' => 'site_title',
                        'phone_number' => 'phone_number',
                        'contact_email' => 'contact_email',
                        'copyright' => 'copyright',
                        'site_url' => 'site_url',
                        'base_url' => 'base_url',
                        'admin_url' => 'admin_url',
                    ];

                    $_tags['Member Tags'] = [
                            'config' => ['title' => 'Member Tags', 'icon' => 'la la-user la-2x'],

                            'id' => 'id',
                            'username' => 'username',
                            'password' => 'password (Use only signup)',
                            'reset_link' => 'reset_link (Use only Password Reset)',
                            'first_name' => 'first_name',
                            'last_name' => 'last_name',
                            //'photo' => 'photo',
                            //'cnic' => 'cnic',
                            'email' => 'email',
                            'phone' => 'phone',
                            'address' => 'address',
                            //'city' => 'city',
                            'country' => 'country',
                            //'zip_code' => 'zip_code',
                            'created' => 'created',
                            'status' => 'status',
                    ];

                    ?>

                    <div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">
                        <?php
                        $t = 0;
                        foreach ($_tags as $tags) {
                        $t++;
                        $config = $tags['config'];
                        unset($tags['config']);
                        ?>
                            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_menus-{{ $t }}">
                                <div class="kt-portlet__head kt-padding-l-15">
                                    <div class="kt-portlet__head-label">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon"><i class="{{ $config['icon'] }}"></i></span>
                                            <h3 class="kt-portlet__head-title menu-label">{{ $config['title'] }}</h3>
                                        </div>
                                    </div>
                                    @include('admin.layouts.inc.portlet_actions')
                                </div>

                                <div class="kt-portlet__body bg-light kt-padding-10">
                                    <?php
                                    foreach($tags as $tag => $tag_value){
                                        echo '<p class="field-'.$tag.'"><a href="javascript: void(0);" onclick="tinymce.activeEditor.execCommand(\'mceInsertContent\', false, \'{$'.$tag.'}\');">{$'.$tag_value.'}</a></p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
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

        $("form#message_template").validate({
            // define validation rules
            rules: {
                'name': {
                    required: true,
                },
                'subject': {
                    required: true,
                },
            },
            /*messages: {
            'name' : {required: 'name is required',},'subject' : {required: 'Subject is required',},    },*/
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
