<div class="mt-3"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Site Title:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[site_title]" class="form-control" value="<?php echo opt('site_title'); ?>">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<div class="form-group row">
    <label class="col-lg-2 col-form-label">Tag Line:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[tag_line]" class="form-control" value="<?php echo opt('tag_line'); ?>">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<!--<div class="form-group row">
    <label class="col-lg-2 col-form-label">Top Text:</label>
    <div class="col-lg-10">
        <textarea name="opt[top_text]" cols="" rows="5" class="small_editor col-sm-12"><?php /*echo opt('top_text'); */?></textarea>
    </div>
</div>-->

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Copyright Text:</label>
    <div class="col-lg-10">
        <textarea name="opt[copyright]" cols="" rows="5" class="form-control col-sm-12"><?php echo opt('copyright'); ?></textarea>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Currency:</label>
    <div class="col-lg-2">
        <input type="text" name="opt[currency]" class="form-control" value="<?php echo opt('currency'); ?>">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Weekend:</label>
    <div class="col-lg-10">
        <select id="weekend" name="opt[weekend][]" class="form-control m_select2-tags" multiple>
            <?php
            $weekend = json_decode(opt('weekend'));
            $OP = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            echo selectBox(array_combine($OP, $OP), $weekend);
            ?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label for="maintenance_mode" class="col-lg-2 col-form-label">Maintenance Mode:</label>
    <div class="col-lg-6">
        <select name="opt[maintenance_mode]" class="form-control m_selectpicker">
            <option value="Inactive"> Inactive </option>
            <option value="Active"> Active </option>
        </select>
    </div>
</div>
