<div class="mt-3"></div>

<?php
$values = json_decode(opt('smtp'));
?>
<div class="form-group m-form__group row">
    <label class="col-lg-2 col-form-label">SMTP:</label>
    <div class="col-lg-2">
        <select name="opt[smtp][status]" id="smtp" class="form-control m-bootstrap-select m_selectpicker">
            <?php
            $_OP = array(
                '1'  => 'Yes',
                '0'  => 'No'
            );
            echo selectBox($_OP, $values->status);?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<?php
$inputs = ['Host', 'User', 'Pass', 'port' => 'Port'];
foreach ($inputs as $key => $title) {
$name = (is_int($key) ? Str::slug($title, '_', true) : $key);
?>
<div class="form-group row">
    <label class="col-lg-2 col-form-label">{{ $title }}:</label>
    <div class="col-lg-6">
        <input type="text" name="opt[smtp][{{ $name }}]" class="form-control" placeholder="{{ $title }}" value="{{ $values->{$name} }}">
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<?php
}
?>
