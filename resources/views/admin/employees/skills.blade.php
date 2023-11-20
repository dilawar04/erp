@php
    if($row->id > 0){
        $skills = \DB::table('employee_skills')->where(['user_id' => $row->id])->get();
    } else {
        $skills = [[]];
    }
@endphp

<div class="skills-container">
    <div class="form-group row -justify-content-center">
        <div class="col-lg-3">
            <label for="skill_type" class="col-form-label">{{ __('Type') }}:</label><br>
            <select name="skills[skill_type][]" id="skill_type" class="form-control m-select2" style="width: 100%">
                {!! selectBox(DB_enumValues('employee_skills', 'skill_type'), old('skills.skill_type', $skills[0]->skill_type)) !!}
            </select>
        </div>
    </div>
    @foreach($skills as $k => $skill)
    <div class="clone">
        <div class="row">
            <div class="col-lg-11">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label for="skill_{{ $k }}" class="col-form-label">{{ __('Skill') }}:</label><br>
                        <select name="skills[skill][]" id="skill_{{ $k }}" class="form-control m-select2" style="width: 100%">
                            <option value="">- Select -</option>
                            {!! selectBox("SELECT skill, skill as name FROM skills", old("members.skill.{$k}", $skill->skill)) !!}
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="level_{{ $k }}" class="col-form-label">{{ __('Level') }}</label><br>
                        <select name="members[level][]" id="level_{{ $k }}" class="form-control m-select2" style="width: 100%">
                            {!! selectBox(array_combine(range(0, 10), array_map(function ($val)  { return "Level " . $val;}, range(0, 10))), old("skills.level.{$k}", $skill->level))  !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <p style="margin-top: 6px;">&nbsp;</p>
                <button type="button" class="btn btn-success btn-icon add-more" clone-container=".skills-container" callback="skills_cb"><i class="la la-plus"></i></button>
                <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".skills-container-.clone"><i class="la la-trash"></i></button>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    </div>
    @endforeach
</div>
<script>
    function skills_cb(clone, cc){
        const index = cc.find('.clone').length - 1;
        //$('select[multiple]', clone).attr('name', 'leaves_id['+ index +'][]');

        $('[data-select2-id]').not('select[data-select2-id], .select2-container[data-select2-id]').removeAttr('data-select2-id')
        $('.select2-container', clone).remove();
        $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
        $('.m-select2', clone).select2();
    }
</script>
