<div class="kt-portlet__head-label">
    <div class="kt-portlet__head-label">
        <span class="kt-portlet__head-icon">
            @if(!empty($_this->_info->image))
                <img src="{{ _img(asset_url('media/icons/' . $_this->_info->image, 1), 28, 28) }}" alt="{{ $_this->_info->title }}">
            @else
                <i class="{{ (!empty($_this->_info->icon) ? $_this->_info->icon : 'flaticon-list-2') }}"></i>
            @endif
        </span>
        <h3 class="kt-portlet__head-title"> {{ $_this->_info->title }}</h3>
    </div>
</div>
