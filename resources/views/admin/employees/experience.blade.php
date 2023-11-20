@php
    if($row->id > 0){
        $experiences = \DB::table('employee_experiences')->where(['user_id' => $row->id])->get();
    } else {
        $experiences = [[]];
    }
@endphp
<div class="experiences-container">
    @foreach($experiences as $k => $experience)
    <div class="clone">
        <div class="row">
            <div class="col-lg-11">
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label for="job_position_{{ $k }}" class="col-form-label">Job Position:</label>
                        <input type="text" name="experiences[job_position][]" id="job_position_{{ $k }}" class="form-control" placeholder="Job Position" value="{{ $experience->job_position }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="company_{{ $k }}" class="col-form-label">Company:</label>
                        <input type="text" name="experiences[company][]" id="company_{{ $k }}" class="form-control" placeholder="company" value="{{ $experience->company }}">
                    </div>
                    <div class="col-lg-6">
                        <label for="location_{{ $k }}" class="col-form-label">Location:</label>
                        <input type="text" name="experiences[location][]" id="location_{{ $k }}" class="form-control" placeholder="Location" value="{{ $experience->location }}">
                    </div>
                </div>
                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                <div class="form-group row">
                    <div class="col-lg-3">
                        <label for="last_salary_{{ $k }}" class="col-form-label">Last Salary:</label>
                        <input type="number" name="experiences[last_salary][]" id="last_salary_{{ $k }}" class="form-control" placeholder="Last Salary" value="{{ $experience->last_salary }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="working_from" class="col-form-label">Working Form:</label>
                        <input type="datetime" name="experiences[working_from][]" id="working_from_{{ $k }}" class="form-control datepicker" autocomplete="off" placeholder="Working From" value="{{ $experience->working_from }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="working_to_{{ $k }}" class="col-form-label">Working To:</label>
                        <input type="datetime" name="experiences[working_to][]" id="working_to_{{ $k }}" class="form-control datepicker" autocomplete="off" placeholder="To" value="{{ $experience->working_to }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="skills_{{ $k }}" class="col-form-label">Skills:</label><br>
                        <select name="experiences[skills][{{ $k }}][]" id="skills_{{ $k }}" multiple class="form-control m-select2 skills" style="width: 100%">
                            {!! selectBox("SELECT skill, skill as name FROM skills", old("members.skills.{$k}", json_decode($experience->skills))) !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <p style="margin-top: 6px;">&nbsp;</p>
                <button type="button" class="btn btn-success btn-icon add-more" clone-container=".experiences-container" callback="experiences_cb"><i class="la la-plus"></i></button>
                <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".experiences-container-.clone"><i class="la la-trash"></i></button>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    </div>
    @endforeach
</div>

<script>
    function experiences_cb(clone, cc){
        const index = cc.find('.clone').length - 1;
        $('.skills', clone).attr('name', 'experiences[skills]['+ index +'][]');

        $('[data-select2-id]').not('select[data-select2-id], .select2-container[data-select2-id]').removeAttr('data-select2-id')
        $('.select2-container', clone).remove();
        $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
        $('.m-select2', clone).select2();
    }
</script>
