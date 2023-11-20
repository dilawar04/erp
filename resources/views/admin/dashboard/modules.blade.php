<style>

    .dashboard-components {
        list-style: none;
        padding: 0;
        margin: 0 auto;
        text-align: center;
    }

    .dashboard-components li {
        list-style: none;
        display: inline-block;
        width: 160px;
        height: 130px;
        text-align: center;
    }

    .dashboard-components li a {
        color: #575962;
        outline: none;
        text-align: center;
        width: 100%;
        display: inline-block;

        /*float: left;*/
        padding: 10px;
        margin: 2px 2px 8px 2px;
        /*border: 1px solid #ededed;*/
        border-radius: 2px;

    }

    .dashboard-components li a:hover div {
        background: #005C97; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #363795, #005C97); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #363795, #005C97); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .dashboard-components li a:hover {
        color: #ffffff;
        text-decoration: none;
        -webkit-box-shadow: 0 1px 15px 1px rgba(69, 65, 78, .1);
        box-shadow: 0 1px 15px 1px rgba(69, 65, 78, .1);
    }

    .dashboard-components li a div {
        margin-top: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 140px;
        -webkit-line-clamp: 2;
        padding: 4px;

        border-radius: 2px;
        box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);
        background-color: #ffffff;
    }
</style>

<div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
    <div class="kt-portlet__head">
        @include('admin.layouts.inc.portlet_head')
        @include('admin.layouts.inc.portlet_actions')
    </div>
    <div class="kt-portlet__body search-container">

        <div class="kt-input-icon  kt-input-icon--right">
            <input id="search" class="form-control kt-input kt-input--air search-input" type="text" placeholder="Search module..." find-block=".dashboard-components" find-in="[class*=module-li]" autocomplete="off">
            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
        </div>
        <br>
        <div class="clearfix"></div>
        <ul class="dashboard-components">
            <?php
            $_user_type_id = (\Auth::user()->user_type_id);
            $modules = \App\Module::where(['status' => 'Active', 'show_in_menu' => 1])
                ->whereRaw("id IN(SELECT `module_id` FROM `user_type_module_rel` WHERE user_type_id='{$_user_type_id}')")->orderBy('ordering', 'ASC')->get();
            foreach ($modules as $module) {
            if (!in_array($module->module, array('#', 'javascript:;', 'javascript: void(0);'))) {
            ?>
            <li class="module-li">
                <a href="{{ admin_url($module->module) }}">
                    <img src="{{ _img("assets/admin/media/icons/{$module->image}", 64, 64) }}" alt="{{ $module->title }}">
                    <div class="module-title" title="{{ $module->title }}">{{ $module->title }}</div>
                </a>
            </li>
            <?php
            }
            } ?>

            <li>
                <a href="{{ admin_url('login/logout') }}">
                    <img src="{{ _img('assets/admin/media/icons/locked.png', 64,64) }}" alt="Logout">
                    <div class="module-title">Logout</div>
                </a>
            </li>
        </ul>
    </div>
</div>

