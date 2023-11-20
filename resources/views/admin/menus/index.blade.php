@php
    $status_column_data = DB_enumValues('menus', 'status');

$form_buttons = [];//['new', 'delete', 'import', 'export'];
$_this->title = 'Menu';
@endphp
@extends('admin.layouts.admin')

@section('content')
    @include('admin.layouts.inc.stickybar', compact('form_buttons'))
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-3">
                @include('admin.menus.side_bar')
            </div>

            <div class="col-lg-9">
                <div class="kt-portlet kt-portlet--tabs" data-ktportlet="true" id="kt_portlet_menus">
                    <div class="kt-portlet__head">

                        @if (count($menu_types) > 0)
                            <div class="kt-portlet__head-toolbar">
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
                                    @foreach ($menu_types as $n => $m_type)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $n == 0 ? 'active' : '' }}" data-id="{{ $m_type->id }}" data-toggle="tab" href="#kt_m_tab_{{ $m_type->id }}" role="tab" aria-selected="true">
                                                <i class="-la -la-menu fa-2x flaticon2-menu-1" aria-hidden="true"></i>{{ $m_type->type_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{--@include('admin.layouts.inc.portlet_head')--}}
                        @include('admin.layouts.inc.portlet_actions')
                    </div>

                    <div class="kt-portlet__body -kt-padding-0">

                        @if (count($menu_types) > 0)
                            <div class="tab-content" id="nested">
                                @foreach ($menu_types as $n => $m_type)
                                    <div class="tab-pane {{ $n == 0 ? 'active' : '' }}" id="kt_m_tab_{{ $m_type->id }}" role="tabpanel">
                                        @if (count($menus[$m_type->id]) > 0)
                                            <div class="kt-input-icon  kt-input-icon--right">
                                                <input id="search" class="form-control kt-input kt-input--air search-input" type="text" placeholder="Search {{ __($menu_type['title']) }}..." find-block=".s-main-block-{{ $n }}" find-in="[class*=f-menu-item]" autocomplete="off">
                                                <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
                                            </div>
                                            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                                        @else
                                            <div id="menu-msg" class="alert alert-danger">{{ __('No items in this menu') }}</div>
                                        @endif

                                        <ol class="menu-items menu-group-link kt-padding-0 col-lg-12 list-inline s-main-block-{{ $n }}">
                                            @foreach ($menus[$m_type->id] as $n => $item)
                                                @include('admin.menus.menu_items')
                                            @endforeach
                                        </ol>

                                        <div class="text-center">
                                            <div class="kt-btn-group kt-btn-group--pill btn-group">
                                                @if (user_do_action('add'))
                                                    <button type="button" class="btn btn-success btn-elevate -btn-pill menu-save">Save Menu</button>
                                                @endif
                                                @if (user_do_action('delete'))
                                                    <button type="button" class="btn btn-danger btn-elevate -btn-pill menu-delete">Delete Menu</button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="demo-menus" style="display: none;">
        @include('admin.menus.menu_items', ['item' => ['menu_type' => 'cms', 'id' => 0]])
        @include('admin.menus.menu_items', ['item' => ['menu_type' => 'custom', 'id' => 0]])
    </div>
@endsection

{{-- Scripts --}}
@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset_url('js/jquery.mjs.nestedSortable.js', 1) }}"></script>

    <script type="text/javascript">
        $(function () {
            $(document).ready(function () {
                // Menu Sorting

                let _menus = $('.menu-items').nestedSortable({
                    forcePlaceholderSize: true,
                    items: 'li',
                    handle: '.sort-handle',
                    placeholder: 'placeholder',
                    maxLevels: 5,
                    opacity: .6,
                });


                $(document).on('input', '.menu-title', function () {
                    $(this).closest('.item').find('.menu-label').text($(this).val());
                });

                $(document).on('click', '.add-to-menu', function () {
                    let _this = $(this);
                    let ele_items = $('input:checked', _this.closest('.items-container'));
                    let menu_type_id = $('.nav-link.active').data('id');

                    ele_items.each(function (i, ele) {
                        let _ele = $(ele);
                        let _data = _ele.data();

                        let HTML_ele = $('#demo-menus .li-' + _data.li).clone(true);
                        HTML_ele.find('[name=menu_link]').val(_ele.val());
                        HTML_ele.find('[name=menu_type_id]').val(menu_type_id);

                        HTML_ele.find('[name=menu_type]').val(_data.type);
                        HTML_ele.find('.menu-type').html(_data.type);
                        HTML_ele.find('[name=menu_title]').val(_data.title);
                        HTML_ele.find('.menu-label').html(_data.title);

                        HTML_ele.appendTo('.tab-pane.active .menu-items');
                        _ele.prop('checked', false);
                    });
                });

                $(document).on('click', ' #menu-custom-add', function () {
                    let _this = $(this);
                    let _box = _this.closest('.kt-portlet');
                    let menu_type_id = $('.nav-link.active').data('id');

                    let HTML_ele = $('#demo-menus .li-custom').clone(true);
                    HTML_ele.find('[name=id]').val();
                    HTML_ele.find('[name=menu_type_id]').val(menu_type_id);
                    HTML_ele.find('[name=menu_type]').val('custom');
                    HTML_ele.find('.menu-type').html('Custom');
                    HTML_ele.find('[name=menu_title]').val(_box.find('#menu-custom-label').val());
                    HTML_ele.find('.menu-label').html((_box.find('#menu-custom-label').val()));
                    HTML_ele.find('[name=menu_link]').val(_box.find('#menu-custom-url').val());

                    HTML_ele.appendTo('.tab-pane.active .menu-items');

                    _box.find('input:text').val('');
                });

                $(document).on('click', '.menu-delete', function () {
                    swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to delete these!",
                        type: "danger",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function (e) {
                        if(e.value){
                            window.location='<?php echo admin_url("delete/1", 1) ?>';
                        }
                    })
                });

                //Save menu
                $(document).on('click', '.menu-save', function () {
                    let items = getMenuItems($('.menu-items > li'));
                    console.log(items);
                    $.post('<?php echo admin_url("store", 1); ?>?_token=' + CSRF_TOKEN, {items: items}, function () {
                        $('#menu-save').removeAttr('disbaled').text('Save Menu');
                        swal.fire('Menu saved successfully!');
                    });
                });

            });
        });

        function getMenuItems(obj) {
            let $menu_item,
                $sub_items,
                items = [];

            obj.each(function (i, ele) {

                $menu_item = $(ele).find('> .item');

                let item = {};
                item.id = $('[name="id"]', $menu_item).val();
                item.menu_type_id = $('[name="menu_type_id"]', $menu_item).val();
                item.menu_title = $('[name="menu_title"]', $menu_item).val();
                item.menu_type = $('[name="menu_type"]', $menu_item).val();
                item.menu_link = $('[name="menu_link"]', $menu_item).val();

                item.params = $('[name^=params]', $menu_item.find('div.params')).serialize();

                $sub_items = $('> ol > li', $menu_item.closest('li'));
                if ($sub_items.length > 0) {
                    item.sub_items = getMenuItems($sub_items);
                } else {
                    item.sub_items = [];
                }

                items.push(item);
            });

            return items;
        }
    </script>
@endsection
