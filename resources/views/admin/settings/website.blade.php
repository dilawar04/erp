<div class="mt-3"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Title Prefix:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[title_prefix]" class="form-control" value="<?php echo opt('title_prefix'); ?>">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Title Suffix:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[title_suffix]" class="form-control" value="<?php echo opt('title_suffix'); ?>">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>


<div class="form-group row">
    <label for="meta_title" class="col-lg-2 col-sm-12 col-form-label">Header Logo:</label>
    <div class="col-lg-6">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="logo" name="opt[logo]">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <span class="form-text text-muted">jpg, png only allow & max 1mb size</span>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="img44">
            <a href="{{ asset_url('images/' . opt('logo'), 1) }}" data-fancybox="footer_logo">
                <img src="{{ _img(asset_url('images/' . opt('logo'), 1), 200, 200) }}" width="60" class="img-fluid img-thumbnail img_center" alt="img">
            </a>
            <button type="button" class="setting_img_delete btn-danger" data-skin="dark" data-toggle="kt-tooltip" title="remove image">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="meta_title" class="col-lg-2 col-sm-12 col-form-label">Footer Logo:</label>
    <div class="col-lg-6">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="footer_logo" name="opt[footer_logo]">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <span class="form-text text-muted">jpg, png only allow & max 1mb size</span>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="img44">
            <a href="{{ asset_url('images/' . opt('footer_logo'), 1) }}" data-fancybox="footer_logo">
                <img src="{{ _img(asset_url('images/' . opt('footer_logo'), 1), 200, 200) }}" width="60" class="img-fluid img-thumbnail img_center" alt="img">
            </a>
            <button type="button" class="setting_img_delete btn-danger" data-skin="dark" data-toggle="kt-tooltip" title="remove image">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="mt-3"></div>
<div class="form-group row">
    <label for="meta_title" class="col-lg-2 col-sm-12 col-form-label">Favicon:</label>
    <div class="col-lg-6">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="favicon" name="opt[favicon]">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <span class="form-text text-muted">jpg, png only allow & max 1mb size</span>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="img44">
            <a href="{{ asset_url('images/' . opt('favicon'), 1) }}" data-fancybox="favicon">
                <img src="{{ _img(asset_url('images/' . opt('favicon'), 1), 200, 200) }}" width="60" class="img-fluid img-thumbnail img_center" alt="img">
            </a>
            <button type="button" class="setting_img_delete btn-danger" data-skin="dark" data-toggle="kt-tooltip" title="remove image">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>


<div class="form-group row">
    <label for="meta_description" class="col-lg-2 col-form-label text-right">Default Description:</label>
    <div class="col-lg-10">
        <textarea name="opt[meta_description]" class="form-control" rows="4" placeholder="Write meta description" id="meta_description">{{ opt('meta_description') }}</textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<div class="form-group row">
    <label for="meta_keywords" class="col-lg-2 col-form-label text-right">Default Keywords:</label>
    <div class="col-lg-10">
        <textarea name="opt[meta_keywords]" class="form-control" rows="4" placeholder="Write meta keywords" id="meta_keywords">{{ opt('meta_keywords') }}</textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="footer_js" class="col-lg-2 col-form-label text-right">Footer Js<br/>Google Analytics:</label>
    <div class="col-lg-10">
        <textarea name="opt[footer_js]" class="form-control" rows="7" placeholder="Write/past code here" id="footer_js">{{ opt('footer_js') }}</textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="header_js" class="col-lg-2 col-form-label text-right">Header Js:</label>
    <div class="col-lg-10">
        <textarea name="opt[header_js]" class="form-control" rows="7" placeholder="Write/past code here" id="header_js">{{ opt('header_js') }}</textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="robots" class="col-lg-2 col-form-label text-right">Default Robots:</label>
    <div class="col-lg-10">
        <select id="robots" name="opt[robots]" class="form-control kt-bootstrap-select m_selectpicker">
            <?php
            $_robots = array(
                'INDEX, FOLLOW'  => 'INDEX, FOLLOW',
                'NOINDEX, FOLLOW'  => 'NOINDEX, FOLLOW',
                'INDEX, NOFOLLOW'  => 'INDEX, NOFOLLOW',
                'NOINDEX, NOFOLLOW'  => 'NOINDEX, NOFOLLOW',
            );
            echo selectBox($_robots, opt('robots'));
            ?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="theme" class="col-lg-2 col-form-label text-right">Theme:</label>
    <div class="col-lg-10">
        <select id="theme" name="opt[theme]" class="form-control m-bootstrap-select m_selectpicker">
            <?php
            foreach(array_filter(glob(resource_path('views/themes/*')), 'is_dir') as $_dir){
                $_theme_dir = end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))));
                $_theme_name = ucwords(str_replace(array('-','_'), ' ', end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))))));
                $_themes[$_theme_dir] = $_theme_name;
            }

            echo selectBox($_themes, opt('theme'));
            ?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="site_loader" class="col-lg-2 col-form-label text-right">Site Loader:</label>
    <div class="col-lg-10">
        <select id="site_loader" name="opt[site_loader]" class="form-control m-bootstrap-select m_selectpicker">
            <?php
            $_OP = ['On' => 'On', 'Off' => 'Off',];
            echo selectBox($_OP, opt('site_loader'));
            ?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

@if (\Schema::hasTable('pages'))
    <div class="form-group row">
        <label for="front_page" class="col-lg-2 col-form-label text-right">Home Page:</label>
        <div class="col-lg-10">
            <select id="front_page" name="opt[front_page]" class="form-control m-select2" style="width: 100%;">
                <?php
                $_OP = \App\Page::where(['status' => 'Published'])->get()->pluck('title', 'id')->toArray();
                echo selectBox($_OP, opt('front_page'));
                ?>
            </select>
        </div>
    </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
@endif

@if (\Schema::hasTable('blog_posts'))
    <div class="form-group row">
        <label for="blog_page" class="col-lg-2 col-form-label text-right">Blog Page:</label>
        <div class="col-lg-10">
            <select id="blog_page" name="opt[blog_page]" class="form-control m-select2" style="width: 100%;">
                <?php
                //$_OP = \App\Page::where(['status' => 'Published'])->get()->pluck('title', 'id')->toArray();
                echo selectBox($_OP, opt('blog_page'));
                ?>
            </select>
        </div>
    </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

    <div class="form-group row">
        <label for="posts_per_page" class="col-lg-2 col-form-label">Posts Per Page:</label>
        <div class="col-lg-10">
            <input type="text" name="opt[posts_per_page]" id="posts_per_page" class="form-control" value="<?php echo opt('posts_per_page'); ?>">
        </div>
    </div>
    <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
@endif
