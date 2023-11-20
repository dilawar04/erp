@php
$params = json_decode($item->params);
@endphp
<div class="form-group row">
    <div class="col-lg-6">
        <label>{{ __('Alt Tag') }}</label>
        <input type="text" class="form-control params" name="params[alt]" placeholder="{{ __('Alt tag') }}" value="{{ $params->alt }}">
    </div>
    <div class="col-lg-6">
        <label>{{ __('Icon') }}</label>
        <div class="input-group kt-input-group">
            <input type="text" name="params[icon]" id="icon" class="form-control icon-class" placeholder="{{ __('Icon') }}" value="{{ $params->icon }}" />
            <div class="input-group-append">
                <a class="input-group-text" data-toggle="modal" role="button"  data-toggle="modal" data-target="#icon_modal">
                    <span class="icon-show">{{ __('Pick') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
