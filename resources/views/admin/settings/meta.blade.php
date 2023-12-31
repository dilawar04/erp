<div class="mt-3"></div>
<div class="form-group row">
    <label for="meta_title" class="col-lg-2 col-sm-12 col-form-label">Meta Title:</label>
    <div class="col-lg-9">
        <input name="opt[meta_title]" class="form-control" type="text" value="{{ opt('meta_title') }}" placeholder="Enter meta title" id="meta_title">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="meta_keywords" class="col-lg-2 col-sm-12 col-form-label">Meta Keywords:</label>
    <div class="col-lg-9">
        <textarea name="opt[meta_keywords]" class="form-control kt_autosize_1" rows="3" placeholder="Write meta keywords" id="meta_keywords">{{ opt('meta_keywords') }}</textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="meta_description" class="col-lg-2 col-sm-12 col-form-label">Meta description:</label>
    <div class="col-lg-9">
        <textarea name="opt[meta_description]" class="form-control kt_autosize_1" rows="5" placeholder="Write meta description" id="meta_description">{{ opt('meta_description') }}</textarea>
    </div>
</div>
