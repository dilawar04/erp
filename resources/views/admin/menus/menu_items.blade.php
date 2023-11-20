<li class="menu-li-{{ $item['menu_type'] }} li-{{ $item['menu_type'] }} f-menu-item" id="menu-item-{{ $item['id'] . "-" . $n }}">
    <div class="item">
        <input type="hidden" name="id" value="{{ $item['id'] }}">
        <input type="hidden" name="menu_type_id" value="{{ $item['menu_type_id'] }}">
        <input type="hidden" name="menu_type" value="{{ $item['menu_type'] }}">

        <div class="kt-portlet kt-portlet--collapse" data-ktportlet="true" id="kt_portlet_menus-{{ $item['id'] }}">
            <div class="kt-portlet__head sort-handle kt-padding-l-15">
                <div class="kt-portlet__head-label">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon"><i class="la la-arrows-alt la-2x"></i></span>
                        <h3 class="kt-portlet__head-title menu-label">{{ $item['menu_title'] }}</h3>
                        {!! str_repeat('&nbsp;', 3) !!}
                        <span class="kt-badge  kt-badge--info kt-badge--inline menu-type">{{ ucfirst($item['menu_type']) }}</span>
                    </div>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-group">
                        <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-angle-down"></i></a>
                        <a href="#" data-ktportlet-remove="li" class="btn btn-sm btn-icon btn-default btn-pill btn-icon-md"><i class="la la-close"></i></a>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body bg-light kt-padding-10" style="display: none;">
                @switch($item['menu_type'])
                    @case('type')
                        {{-- todo:: new type here --}}
                    @break

                    @case('custom')
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>{{ __('Navigation Label') }}</label>
                            <input type="text" name="menu_title" class="form-control menu-title" placeholder="{{ __('Menu item') }}" value="{{ $item['menu_title'] }}">
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>{{ __('URL') }}</label>
                            <input type="text" name="menu_link" class="form-control menu-link" placeholder="{{ __('URL') }}" value="{{ $item['url'] }}">
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                    <div class="params">
                        @include('admin.menus.menu_params')
                    </div>

                    <p class="link-wrapper">Page: <a href="{{ $item['menu_link'] }}" target="_blank" class="menu-link">{{ $item['menu_title'] }}</a></p>
                    @break

                    @default
                    <input type="hidden" name="menu_link" value="{{ $item['menu_link'] }}">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>{{ __('Navigation Label') }}</label>
                            <input type="text" name="menu_title" class="form-control menu-title" placeholder="{{ __('Menu item') }}" value="{{ $item['menu_title'] }}">
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                    <div class="params">
                        @include('admin.menus.menu_params')
                    </div>

                    <p class="link-wrapper">Page: <a href="{{ /*$menu_cats[$item['menu_type']]['url_base'] . */$item['url'] }}" target="_blank" class="menu-link">{{ $item['menu_title'] }}</a></p>
                    @break
                @endswitch
            </div>
        </div>
    </div>
    {{--
    | Submenu
    --}}
    @if (count($item['sub_items']) > 0)
        <ol class="menu-group-link -col-lg-12 -list-inline">
            @foreach ($item['sub_items'] as $sub_item)
                @include('admin.menus.menu_items', ['item' => $sub_item])
            @endforeach
        </ol>
    @endif
</li>
