<div class="mt-3"></div>
<div class="form-group row">
    <label for="meta_title" class="col-lg-2 col-sm-12 col-form-label">Admin Logo:</label>
    <div class="col-lg-6">
        <div class="custom-file">
            <input type="file" name="opt[admin_logo]" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <span class="form-text text-muted">jpg, png only allow & max 1mb size</span>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="img44">
            <img src="{{ _img(asset_url('images/' . opt('admin_logo'), 1), 200, 200) }}" width="60" class="img-fluid img-thumbnail img_center" alt="img">
            <button type="button" class="setting_img_delete btn-danger" data-skin="dark" data-toggle="kt-tooltip" title="remove image">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="copyright_admin" class="col-lg-2 col-sm-12 col-form-label">Copyright Text:</label>
    <div class="col-lg-6">
        <textarea name="opt[copyright_admin]" id="copyright_admin" cols="" rows="5" class="form-control col-sm-12"><?php echo opt('copyright_admin'); ?></textarea>
    </div>
</div>
