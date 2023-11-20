@include('admin.layouts.inc.header')

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor view-{{ getUri(3) }}" id="kt_content">
    {{--@includeWhen(!$is_form, 'admin.layouts.inc.stickybar')--}}

    {{--@include('admin.layouts.inc.stickybar', compact('form_buttons'))--}}
    <div class="kt-container  kt-container--fluid kt-grid__item--fluid">
        @include('admin.layouts.inc.alerts')
    </div>
    @yield('content')

</div>


@include('admin.layouts.inc.footer')
@include('admin.layouts.inc.modal')
