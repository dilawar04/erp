<!-- begin:: breadcrumb -->
<div class="kt-subheader__main">
    <h3 class="kt-subheader__title">{{ getModuleDetail()->title }}</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    @php
        $items = Breadcrumb::get_items();
    @endphp
    @if(count($items) > 0)
    <div class="kt-subheader__breadcrumbs">
        @foreach($items as $i => $item)
            <a href="{{ $item['link'] }}" class="kt-subheader__breadcrumbs-home">
                <i class="flaticon2-shelter"></i>
                {{ $item['text'] }}
            </a>
            @if($i < count($items))
                <span class="kt-subheader__breadcrumbs-separator"></span>
            @endif
        @endforeach
    </div>
    @endif
</div>
<!-- end:: breadcrumb -->
