
<!-- begin:: Footer -->
<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
    <div class="kt-container  kt-container--fluid text-center">
        <div class="kt-footer__copyright">
            {!! opt('copyright_admin') !!}
        </div>
        {{--<div class="kt-footer__menu">
            <a href="javascript:" target="_blank" class="kt-footer__menu-link kt-link">About</a>
            <a href="javascript:" target="_blank" class="kt-footer__menu-link kt-link">Support</a>
            <a href="javascript:" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>
        </div>--}}
    </div>
</div>
<!-- end:: Footer -->
</div>
</div>
</div>

<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5D78FF",
                "dark": "#282A3C",
                "light": "#FFFFFF",
                "primary": "#5867DD",
                "success": "#34BFA3",
                "info": "#36A3F7",
                "warning": "#FFB822",
                "danger": "#FD3995"
            },
            "base": {
                "label": ["#C5CBE3", "#A1A8C3", "#3D4465", "#3E4466"],
                "shape": ["#F0F3FF", "#D9DFFA", "#AFB4D4", "#646C9A"]
            }
        }
    };
</script>
<!-- end::Global Config -->

<script src="{{ asset_url('vendors/global/vendors.bundle.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('js/scripts.bundle.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('libs/jstree.bundle.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('vendors/custom/fullcalendar/fullcalendar.bundle.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('libs/jquery.fancybox.min.js', true) }}" type="text/javascript"></script>

<script src="{{ asset_url('vendors/custom/datatables/datatables.bundle.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('vendors/custom/tinymce/tinymce.bundle.js', true) }}" type="text/javascript"></script>

<script src="{{ asset_url('js/numeral.min.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('js/print.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('js/jquery.checkboxes.js', true) }}" type="text/javascript"></script>
<script src="{{ asset_url('js/custom.js', true) }}" type="text/javascript"></script>

@yield('scripts')

</body>
</html>
