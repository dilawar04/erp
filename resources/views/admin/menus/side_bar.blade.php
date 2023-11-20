@if (user_do_action('add_type'))
<div class="kt-portlet" data-ktportlet="true" id="kt_portlet_menus">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="la la-list-ul"></i>
                </span>
                <h3 class="kt-portlet__head-title">{{ __('Menu type') }}</h3>
            </div>
        </div>
        @include('admin.layouts.inc.portlet_actions')
    </div>
    <div class="kt-portlet__body kt-padding-15">

        <form action="" method="post">
            <div class="form-group">
                <input type="text" placeholder="Menu Name" name="type_name" id="menu_name" class="form-control" value="{{ old('type_name') }}" />
            </div>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

            <div class="form-group">
                <button type="submit" name="create" class="btn btn-brand btn-elevate btn-pill btn-block">{{ __('Create') }}</button>
            </div>
        </form>

    </div>
</div>
@endif
{{-- --------------------------------------------------------------------------------------------
| Dynamic menu_list
-------------------------------------------------------------------------------------------- --}}
@include('admin.menus.menu_list')

<div class="kt-portlet" data-ktportlet="true" id="kt_portlet_menus">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon"><i class="la la-list-ul"></i></span>
                <h3 class="kt-portlet__head-title">{{ __('Custom link') }}</h3>
            </div>
        </div>
        @include('admin.layouts.inc.portlet_actions')
    </div>
    <div class="kt-portlet__body kt-padding-15">


        <div class="form-group m-form__group">
            <label for="menu-custom-label" class="control-label">{{ __('Label') }}</label>
            <input type="text" id="menu-custom-label" class="form-control" placeholder="{{ __('Menu item') }}">
        </div>
        <br>
        <div class="form-group m-form__group">
            <label for="menu-custom-url" class="control-label">{{ __('URL') }}</label>
            <input type="text" id="menu-custom-url" class="form-control" placeholder="{{ __('Enter url here') }}">
        </div>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
        <div class="text-right">
            <button type="button" id="menu-custom-add" class="btn btn-brand btn-elevate btn-pill btn-block">{{ __('Add to Menu') }}</button>
        </div>

    </div>
</div>
