@include('admin.layouts.inc.head')
@php
    $user = Auth::user();
    $full_name = trim($user->first_name . ' ', $user->last_name);
@endphp
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{ admin_url('') }}">
            <img alt="{{ opt('site_title') }}" src="{{ _img(asset_url('images/' . opt('admin_logo'), 1), 180, 50) }}"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

            @include('admin.layouts.inc.left_side')
            <!-- begin:: Header Menu -->
                <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

                </div>


                <!-- begin:: user top right -->
                <div class="kt-header__topbar" data-skin="dark" data-toggle="kt-tooltip" title="Front View" data-placement="left">
                    <div class="kt-header__topbar-item kt-header__topbar-item--quick-panel" data-skin="dark" data-toggle="kt-tooltip" title="Front View" data-placement="left">
                    	<span class="kt-header__topbar-icon" id="kt_quick_panel_toggler_btn">
                            <a href="{{ url('') }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"/><path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/></g></svg>
                            </a>
                        </span>
                    </div>
                    <!--begin: My Cart -->
                    {{--@include('admin.layouts.inc.task_bar')--}}
                    <!--end: My Cart -->

                    <!--begin: User Bar -->
                    <div class="kt-header__topbar-item kt-header__topbar-item--user">
                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                            <div class="kt-header__topbar-user">
                                <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                                <span class="kt-header__topbar-username kt-hidden-mobile">{{ $full_name }}</span>
                                <img class="kt-hidden" alt="Pic" src="{{ asset_url('media/users/300_25.jpg', true) }}"/>
                                <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">{{ substr($full_name, 0,1) }}</span>
                            </div>
                        </div>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                            <!--begin: Head -->
                            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                 style="background-image: url({{ asset('assets/admin/media/misc/bg-1.jpg') }})">
                                <div class="kt-user-card__avatar">
                                    <img class="kt-hidden" alt="Pic" src="assets/media/users/300_25.jpg"/>
                                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ substr($full_name, 0,1) }}</span>
                                </div>
                                <div class="kt-user-card__name">{{ $full_name }}</div>
                            </div>
                            <!--end: Head -->

                            <!--begin: Navigation -->
                            <div class="kt-notification">
                                <a href="{{ admin_url('users/profile') }}" class="kt-notification__item">
                                    <div class="kt-notification__item-icon">
                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold">My Profile</div>
                                        <div class="kt-notification__item-time">Account settings and more</div>
                                    </div>
                                </a>

                                @if (\Schema::hasTable('tasks'))
                                <a href="{{ admin_url('users/messages') }}" class="kt-notification__item">
                                    <div class="kt-notification__item-icon">
                                        <i class="flaticon2-mail kt-font-warning"></i>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold">My Messages</div>
                                        <div class="kt-notification__item-time">Inbox and tasks</div>
                                    </div>
                                </a>
                                @endif

                                <div class="kt-notification__custom kt-space-between">
                                    <a class="btn btn-label btn-label-brand btn-sm btn-bold" href="{{ admin_url('login/logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Sign Out') }}
                                    </a>
                                    <form id="logout-form" action="{{ admin_url('login/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <!--end: Navigation -->

                        </div>
                    </div>
                    <!--end: User Bar -->
                </div>
                <!-- end:: user top right -->
            </div>
