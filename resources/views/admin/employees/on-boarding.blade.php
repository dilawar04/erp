
<div class="form-group row">
    <div class="col-lg-6">
        <label for="category_id" class="col-form-label">{{ __('Category') }}:</label><br>
        <select name="rel[category_id]" id="category_id" class="form-control m-select2" style="width: 100%">
            <option value="">- Select -</option>
            {!! selectBox("SELECT id, title FROM employee_categories", old('rel.category_id', $row->category_id)) !!}
        </select>
    </div>
    <div class="col-lg-6">
        <label for="employee_ID" class="col-form-label">{{ __('Employee ID') }}:</label>
        <input type="text" name="rel[employee_ID]" id="institution" class="form-control" placeholder="{{ __('Employee ID') }}" value="{{ old('rel.employee_ID', $row->employee_ID) }}"/>
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <div class="col-lg-4">
        <label for="designation_id" class="col-form-label">{{ __('Designation') }}:</label><br>
        <select name="rel[designation_id]" id="designation_id" class="form-control m-select2" style="width: 100%">
            <option value="">- Select -</option>
            {!! selectBox("SELECT id, title FROM designations", old('rel.designation_id', $row->designation_id)) !!}
        </select>
    </div>
    <div class="col-lg-4">
        <label for="department_id" class="col-form-label">{{ __('Department') }}:</label><br>
        <select name="rel[department_id]" id="department_id" class="form-control m-select2" style="width: 100%">
            <option value="0">- Select -</option>
            @php
                $_M = new Multilevel();
                $_M->type = 'select';
                $_M->id_Column = 'id';
                $_M->title_Column = 'title';
                $_M->link_Column = 'title';
                $_M->option_html = '<option {selected} value="{id}">{level}{title}</option>';
                $_M->level_spacing = 6;
                $_M->selected = old('department_id', $row->department_id);
                $_M->query = "SELECT * FROM `departments` WHERE `status`='Active'";
                echo $_M->build();
            @endphp
        </select>
    </div>
    <div class="col-lg-4">
        <label for="grade_id" class="col-form-label">{{ __('Grade') }}:</label><br>
        <select name="rel[grade_id]" id="grade_id" class="form-control m-select2" style="width: 100%">
            <option value="">- Select -</option>
            {!! selectBox("SELECT id, name FROM grades", old('rel.grade_id', $row->grade_id)) !!}
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<div class="form-group row">
    <div class="col-lg-3">
        <label for="salary_from" class="col-form-label">{{ __('Salary Range') }}:</label>
        <input type="text" name="rel[salary_from]" id="salary_from" class="form-control" placeholder="{{ __('FROM') }}" value="{{ old('rel.salary_from', $row->salary_from) }}"/>
    </div>
    <div class="col-lg-3">
        <label for="salary_to" class="col-form-label">{{ __('To') }}:</label>
        <input type="text" name="rel[salary_to]" id="salary_to" class="form-control" placeholder="{{ __('TO') }}" value="{{ old('rel.salary_to', $row->salary_from) }}"/>
    </div>

    <div class="col-lg-3">
        <label for="salary_type" class="col-form-label">{{ __('Salary type') }}:</label><br>
        <select name="rel[salary_type]" id="salary_type" class="form-control m-select2" style="width: 100%">
            {!! selectBox(DB_enumValues('employee_rel', 'salary_type'), old('rel.salary_type', $row->salary_type)) !!}
        </select>
    </div>
    <div class="col-lg-3">
        <label for="salary" class="col-form-label">{{ __('Salary/Wage') }}:</label>
        <input type="text" name="rel[salary]" id="salary" class="form-control" placeholder="{{ __('Salary/Wage') }}" value="{{ old('rel.salary', $row->salary) }}"/>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<div class="form-group row">
    <div class="col-lg-4">
        <label for="employment_type_id" class="col-form-label">{{ __('Employment type') }}:</label><br>
        <select name="rel[employment_type_id]" id="employment_type_id" class="form-control m-select2" style="width: 100%">
            <option value="">- Select -</option>
            {!! selectBox("SELECT id, title FROM employee_types", old('rel.employment_type_id', $row->employment_type_id)) !!}
        </select>
    </div>
    <div class="col-lg-2">
        <label for="joining_date" class="col-form-label">{{ __('Date of joining') }}:</label>
        <input type="text" name="rel[joining_date]" id="contract_to" autocomplete="off" class="form-control datepicker" placeholder="{{ __('joining date') }}" value="{{ old('rel.joining_date', $row->joining_date) }}"/>
    </div>
    <div class="col-lg-2">
        <label for="contract_from" class="col-form-label">{{ __('Contract from') }}:</label>
        <input type="text" name="rel[contract_from]" id="contract_from" autocomplete="off" class="form-control datepicker" placeholder="{{ __('Contract from') }}" value="{{ old('rel.contract_from', $row->contract_from) }}"/>
    </div>
    <div class="col-lg-2">
        <label for="contract_to" class="col-form-label">{{ __('To') }}:</label>
        <input type="text" name="rel[contract_to]" id="contract_to" autocomplete="off" class="form-control datepicker" placeholder="{{ __('Contract to') }}" value="{{ old('rel.contract_to', $row->contract_to) }}"/>
    </div>
    <div class="col-lg-2 text-center">
        <label for="contract" class="col-form-label">{{ __('Contract') }}:</label><br>
        <input disabled type="hidden" name="contract--rm" value="{{ $row->contract }}">
        @php
            $file_input = '<input type="file" name="image" accept="pdf,doc,docx" name="photo" id="photo" class="form-control custom-file-input" placeholder="'.__('contract').'" value="'.($row->contract).'" >';
            $thumb_url = asset_url("{$_this->module}/" . $row->contract);
            $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/contract', true);
            echo thumb_box($file_input, $thumb_url, $delete_img_url);
        @endphp
        <span class="form-text text-muted">"pdf,doc,docx" file extension's</span>
    </div>
</div>
