@php
    $form_buttons = ['save', 'view', 'delete', 'back'];
@endphp
@extends('admin.layouts.admin')

@section('content')
    <form action="{{ admin_url('store', true) }}" method="post" enctype="multipart/form-data" id="user_types">
        @csrf
        @include('admin.layouts.inc.stickybar', compact('form_buttons'))
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <input type="hidden" name="id" value="{{ $row->id }}">
            <input type="hidden" name="id" class="form-control" placeholder="ID" value="{{ $row->id }}">
            <!-- begin:: Content -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                        <div class="kt-portlet__head">
                            @include('admin.layouts.inc.portlet_head')
                            @include('admin.layouts.inc.portlet_actions')
                        </div>

                        <div class="kt-portlet__body">
                            <div class="mt10"></div>


                            <div class="form-group row">
                                <label for="user_type" class="col-2 col-form-label text-right required"><?php echo __('User Type');?>:</label>
                                <div class="col-6">
                                    <input type="text" name="user_type" id="user_type" class="form-control" placeholder="<?php echo __('User Type');?>" value="<?php echo htmlentities($row->user_type);?>"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="for" class="col-2 col-form-label text-right"><?php echo __('Login For');?>:</label>
                                <div class="col-6">
                                    <select name="for" id="for" class="form-control m-select2">
                                        <option value="">- Select For -</option>
                                        <?php echo selectBox(DB_enumValues('user_types', 'for'), ($row->for));?>
                                    </select>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                            <div class="form-group row">
                                <label for="level" class="col-2 col-form-label text-right required"><?php echo __('Level');?>:</label>
                                <div class="col-6">
                                    <input type="number" name="level" max="{{ (env('SUPER_LEVEL') - (\Auth::user()->usertype->level == env('SUPER_LEVEL') ? 0 : 1)) }}" id="level" class="form-control" placeholder="<?php echo __('Level');?>" value="<?php echo($row->level ?? (env('SUPER_LEVEL') - 1));?>"/>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

                            <div class="form-group row">
                                <label for="level" class="col-2 col-form-label text-right required"><?php echo __('Modules');?>:</label>
                                <div class="col-6">
                                    <style>
                                        .tree-module input[type=checkbox] {
                                            margin-left: 200px;
                                            position: absolute;
                                            display: none;
                                        }

                                        .jstree-default .jstree-icon {
                                            color: #000000;
                                        }
                                    </style>
                                    <div id="tree-module" class="tree-module">
                                        <?php
                                        $m_rows = \App\Module::where(['status' => 'Active'])->orderBy('ordering');

                                        $super_user = true;
                                        $member_modules = [];
                                        if (\Auth::user()->usertype->level < env('SUPER_LEVEL', 1000001)) {
                                            $super_user = false;
                                            $member_modules = DB::select("SELECT modules.id, um.actions AS user_actions, modules.actions FROM users
                                                INNER JOIN user_type_module_rel AS um ON (users.user_type_id = um.user_type_id)
                                                INNER JOIN modules ON (modules.id = um.module_id)
                                            WHERE users.id = '" . \Auth::user()->id . "'");
                                            $member_modules = collect($member_modules)->mapWithKeys(function ($item) {
                                                return [$item->id => $item];
                                            })->toArray();
                                            $m_rows = $m_rows->whereIn('id', collect($member_modules)->pluck('id'));
                                        }

                                        $m_rows = $m_rows->get();

                                        $menu = array(
                                            'items' => array(),
                                            'parents' => array()
                                        );
                                        foreach (collect($m_rows)->toArray() as $items) {
                                            $menu['items'][$items['id']] = $items;
                                            $menu['parents'][$items['parent_id']][] = $items['id'];

                                        }

                                        function buildModuleCheckBox($parent, $menu, $modules, $selected_action, $super_user, $member_modules)
                                        {

                                            $html = "";
                                            if (isset($menu['parents'][$parent])) {
                                                $html .= "<ul>\n";

                                                foreach ($menu['parents'][$parent] as $itemId) {
                                                    if (!isset($menu['parents'][$itemId])) {
                                                        $actions = '';
                                                        if (!$super_user) {
                                                            $menu['items'][$itemId]['actions'] = $member_modules[$itemId]->user_actions;
                                                        }
                                                        $actions_ar = explode('|', str_replace(',', '|', ($menu['items'][$itemId]['actions'])));


                                                        if (count($actions_ar) > 0) {
                                                            $actions .= '<ul class="module_action">';
                                                            foreach ($actions_ar as $act) {

                                                                if ($act != '') {
                                                                    $actions .= '<li data-jstree=\'{ "icon" : "fa fa-folder kt-font-default" ' . (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ', "selected":true  ' : '') . '}\'>';
                                                                    $actions .= "<input class='' type='checkbox'
    " . (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ' checked ' : '') . "
    name='actions[" . $menu['items'][$itemId]['id'] . "][]' id='a' value='" . $act . "' title='" . ucwords(str_replace('_', ' ', $act)) . "'> " . ucwords(str_replace('_', ' ', $act)) . " </li>";
                                                                }
                                                            }
                                                            $actions .= '</ul>';

                                                        }
                                                        $html .= '<li data-jstree=\'{ ' . ((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '') . ' }\'>';
                                                        //$html .= '<li>';
                                                        $html .= "\n
                                            <input type='checkbox'
                                                                            " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
                                                                            name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
                                                                            " . $menu['items'][$itemId]['title'] . $actions . "
                                                                            </li>";
                                                    }
                                                    if (isset($menu['parents'][$itemId])) {


                                                        $html .= '<li data-jstree=\'{ ' . ((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '') . ' }\'>';
                                                        //$html .= '<li>';

                                                        $html .= "<input " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
    type='checkbox' name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
    " . $menu['items'][$itemId]['title'];


                                                        $html .= buildModuleCheckBox($itemId, $menu, $modules, $selected_action, $super_user, $member_modules);
                                                        $html .= "\n</li>";
                                                    }
                                                }
                                                $html .= "\n</ul>";
                                            }
                                            return $html;
                                        }


                                        echo buildModuleCheckBox(0, $menu, $modules, $selected_action, $super_user, $member_modules);

                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
@endsection

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        (function ($) {

            var tree = $("#tree-module").jstree({
                'plugins': ["checkbox"],
                'checkbox': {"three_state": false},
                types: {default: {icon: "fa fa-folder"}, file: {icon: "fa fa-file"}},
            });

            tree.on("changed.jstree", function (e, data) {
                console.log(data);
                if (data.node) {
                    $('#' + data.node.id + '_anchor').find('input:checkbox').prop('checked', data.node.state.selected);
                }
                if (data.action == 'deselect_node') {
                    tree.jstree("close_node", "#" + data.node.id);
                } else {
                    tree.jstree("open_node", "#" + data.node.id);
                }
            });

            /*$(document).ready(function () {
                $('.tree-form').on('submit', function (e) {
                    $('.jstree input[type=checkbox]', this).each(function () {
                        $(this).prop('checked', false).removeAttr('checked');
                    });
                    $('.jstree-undetermined', this).each(function () {
                        $(this).parent().find('input').prop('checked', true);
                    });
                    $('.jstree-clicked', this).each(function () {
                        $(this).find('input').prop('checked', true);
                    });
                });
            });*/
        })(jQuery)
    </script>
    <script>

        $("form#user_types").validate({
            // define validation rules
            rules: {
                'user_type': {
                    required: true,
                },
                'level': {
                    required: true, digits: true,
                },
            },
            /*messages: {
            'user_type' : {required: 'User Type is required',},'level' : {required: 'Level is required',integer: 'Level is valid integer',},    },*/
            //display error alert on form submit
            invalidHandler: function (event, validator) {
                validator.errorList[0].element.focus();

                /*var alert = $('#_msg');
                alert.removeClass('m--hide').show();
                mUtil.scrollTo(alert, -200);*/
                //mUtil.scrollTo(validator.errorList[0].element, -200);
            },

            submitHandler: function (form) {
                form.submit();
            }

        });
    </script>@endsection
