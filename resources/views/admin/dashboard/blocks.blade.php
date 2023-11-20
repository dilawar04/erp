<style>
    @media (min-width: 1025px) {

        .kt-portlet.kt-portlet--half-height {
            height: 100%;
        }
    }

    .kt-portlet.kt-portlet--height-fluid-half {
        height: 100%;
    }
    .kt-portlet.kt-portlet--height-fluid-half .kt-portlet__body {
        padding: 0;
    }
    .kt-widget26__number {
        text-align: center;
        margin-bottom: 8px;
    }
    .kt-widget26 .kt-widget26__content{
        padding: 0;
    }
    .dashboard-box .kt-widget26 i {
        font-size: 4rem;
    }
</style>
<?php

if(Schema::hasTable('tours')){
    $dashboard_boxs[] = [
        'box_cls' => 'brand',
        'icon' => 'flaticon-map-location',
        'number' => \DB::table('tours')->count('id'),
        'title' => "Total Tours",
    ];
}

if(Schema::hasTable('booked_tours')){
    $total = \DB::table('booked_tours')->count('id');
    $dashboard_boxs[] = [
        'box_cls' => 'danger',
        'icon' => 'flaticon-alert-2',
        'number' => $total,
        'title' => "Booked tours",
        'link' => admin_url('booked_tours'),
    ];
}

/*$dashboard_boxs[] = [
    'box_cls' => 'danger',
    'icon' => 'flaticon-avatar',
    'number' => _count_users(get_option('teacher_type_id'))->total,
    'title' => "Total Teacher's",
];*/


//$other_types = _count_users(0, 0, "AND user_type_id NOT IN(".join(',', _reserve_types()).")");
$agent_type_id = opt('agent_type_id');
$total = \DB::table('users')->where(['user_type_id' => $agent_type_id])->count('id');

$dashboard_boxs[] = [
    'box_cls' => 'warning',
    'icon' => 'flaticon-user-add',
    'number' => $total,
    'title' => "Total Agent's",
];


?>
<!--begin:: Widgets/Quick Stats-->
<div class="row dashboard-box -m-row--full-height justify-content-center">
    <?php
    if (count($dashboard_boxs) > 0) {
    foreach ($dashboard_boxs as $dashboard_box) {
    ?>
    <div class="col-sm-6 col-md-4 col-lg-2 p-1">

        <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-{{ $dashboard_box['box_cls'] }}">
            <div class="kt-portlet__body kt-portlet__body--fluid">
                <div class="kt-widget26">
                    <div class="kt-widget26__content text-center">
                                <span class="kt-widget26__number">
                                    @if(!empty($dashboard_box['link']))
                                        <a href="{{ $dashboard_box['link'] }}">
                                @endif
                                <i class="kt--font-{{ $dashboard_box['box_cls'] }} {{ $dashboard_box['icon'] }}"></i>
                                @if(!empty($dashboard_box['link']))
                                    </a>
                                    @endif
                                    <br>
                                    {{ number_format($dashboard_box['number']) }}</span>
                        <span class="kt-widget26__desc">{{ $dashboard_box['title'] }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
    }
    }
    ?>


</div>
<!--end:: Widgets/Quick Stats-->

