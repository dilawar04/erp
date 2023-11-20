<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>{{ $_this->_info->title }} - Backend || {{ opt('site_title') }}</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">

    <?php
    $fm_access_key =  md5(\Str::random());
    setcookie("fm_access_key", $fm_access_key, 0, "/");
    ?>
    <script !src="">
        let site_url, url = '{{ url("") }}/';
        let asset_url = '{{ asset_url("", null) }}/';
        let media_url = '{{ media_url("") }}/';
        let fm_access_key = '{{ $fm_access_key }}';
    </script>

    <link rel="shortcut icon" href="{{ asset_url('images/' . opt('favicon'), 1) }}"/>
    <!--begin::Fonts -->
    <script src="{{ asset('assets/admin/js/webfont.js') }}" type="text/javascript"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="{{ asset_url('vendors/custom/fullcalendar/fullcalendar.bundle.css', true) }}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles -->


    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset_url('vendors/global/vendors.bundle.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/style.bundle.css', true) }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset_url('css/skins/header/base/light.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/skins/header/menu/light.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/skins/brand/dark.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/skins/aside/dark.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/jquery.fancybox.min.css', true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset_url('css/jstree.bundle.css', true) }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset_url('css/custom.css', true) }}" rel="stylesheet" type="text/css"/>
    <!--end::Layout Skins -->

    <script src="{{ asset_url('js/jquery-3.3.1.min.js', true) }}"></script>
    <script src="{{ asset_url('js/jquery.cookie.js', true) }}"></script>

    <script>
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });
    </script>

@yield('head')
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
