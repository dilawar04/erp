<?php
function ___tree_menu_list($rows, $level, $m_cat){
    $html = '';
    foreach($rows as $item){
        $html .= '<li>
                <div class="-form-group kt-form__group menu-group-link f-item-'.$m_cat.'">
                    <label class="kt-checkbox kt-checkbox--square fields-data">
                        <input type="checkbox" class="id-field range-checkboxes" value="'.$item['id'].'" data-li="cms" data-title="'.$item['title'].'" data-type="'.$m_cat.'"> '.$item['title'].'
                        <span></span>
                    </label>
                </div>
            </li>';

        if(count($item['children']) > 0 && is_array($item['children'])){
            $html .= '<ul class="tree-menu-level-'.($level+1).'">';
            $html .= ___tree_menu_list($item['children'], ($level+1), $m_cat);
            $html .= '</ul>';
        }
    }
    return $html;
}
if(count($menu_cats)) {
    $n = -1;
    foreach ($menu_cats as $m_cat => $menu_cat) {
        if(count($menu_cat['rows']) == 0) continue;
        $n++;
    ?>
    <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_menus">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="la la-list-ul"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">{{ __($menu_cat['title']) }}</h3>
                </div>
            </div>
            @include('admin.layouts.inc.portlet_actions')
        </div>
        <div class="kt-portlet__body kt-padding-15 items-container">


            <div class="kt-input-icon  kt-input-icon--right">
                <input id="search" class="form-control kt-input kt-input--air search-input" type="text" placeholder="Search {{ __($menu_cat['title']) }}..." find-block=".s-m-block-{{ $n }}" find-in="[class*=f-item-{{ $m_cat }}]" autocomplete="off">
                <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
            </div>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

            <div class="kt-accordion__item-content s-m-block-{{ $n }}">
                @if ($menu_cat['tree'])
                    <ul class="tree-menu-level-1">
                        @php
                            echo ___tree_menu_list($menu_cat['rows'], 1, $m_cat);
                        @endphp
                    </ul>
                @else
                    @foreach($menu_cat['rows'] as $item)
                        <div class="-form-group kt-form__group menu-group-link f-item-{{ $m_cat }}">
                            <label class="kt-checkbox kt-checkbox--square fields-data">
                                <input type="checkbox" class="id-field range-checkboxes" value="{{ $item->id }}" data-li="cms" data-title="{{ $item->title }}" data-type="{{ $m_cat }}"> {{ $item->title }}
                                <span></span>
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
            <div class="text-center">
                <div class="kt-btn-group kt-btn-group--pill btn-group ">
                    <button type="button" class="btn btn-warning btn-elevate btn-pill add-to-menu">{{ __('Add to Menu') }}</button>
                    <a class="select-all btn btn-brand btn-elevate btn-pill" data-check="false" href="javascript:void(0);">{{ __('Select All') }}</a>
                </div>
            </div>

        </div>
    </div>
    <?php
    }
}
?>
