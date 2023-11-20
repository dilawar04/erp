@extends('admin.layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    {{-- Content --}}
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Dashboard</h3>
                {{--<span class="kt-subheader__separator kt-subheader__separator--v"></span>--}}
            </div>

        </div>
    </div>

    {{--@if(user_do_action('counter_cards', 'dashboard'))
        <div class="col-lg-12">@include('admin.dashboard.blocks')</div>
    @endif--}}

    {{--<div class="col-lg-12">
        @include('admin.dashboard.charts')
    </div>--}}

    @if(user_do_action('modules', 'dashboard'))
        <div class="col-lg-12">@include('admin.dashboard.modules')</div>
    @endif


@endsection

{{-- Scripts --}}
@section('scripts')

@endsection
