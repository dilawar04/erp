<!-- begin:: breadcrumb -->
<div class="kt-subheader kt-grid__item" id="kt_subheader">

    <div class="kt-container  kt-container--fluid ">
        @include('admin.layouts.inc.breadcrumb')

        @if (user_do_action('status') && count($bulk_update) > 0)
        <div class="kt-subheader__toolbar form-btns">
            <div class="input-group grid-bluk-action selection-box">
                @foreach ($bulk_update as $b_field => $bulk_up)
                    <select name="{{ $b_field }}" id="{{ $b_field }}" class="form-control m-select2" {{ $bulk_up['attr'] }} title="{{ $bulk_up['title'] }}">
                        <option value="">- {{ ($bulk_up['title'] ?? ucfirst($b_field)) }} - </option>
                        {!! selectBox($bulk_up['data'], '') !!}
                    </select>
                @endforeach
                <div class="input-group-append">
                    <button data-toggle="kt-tooltip" data-skin="dark" data-original-title="Update"
                            action="update_grid"
                            href="{{ admin_url("status", true) }}"
                            class="btn btn-brand btn-icon" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {!! $html !!}

        <div class="kt-subheader__toolbar form-btns">
            <div class="btn-group">
                @php
                    $Form_btn = new Form_btn();
                    if(in_array(getUri(3), ['form']) && getUri(4) == 0){
                        if(array_search('view', $form_buttons, true)) unset($form_buttons[array_search('view', $form_buttons)]);
                        if(array_search('delete', $form_buttons, true)) unset($form_buttons[array_search('delete', $form_buttons)]);
                    }
                    echo $Form_btn->buttons($form_buttons);
                @endphp
            </div>
        </div>
    </div>
</div>
<!-- end:: breadcrumb -->
