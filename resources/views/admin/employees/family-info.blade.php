@php
if($row->id > 0){
    $members = \DB::table('employee_members')->where(['user_id' => $row->id])->get();
} else {
    $members = [[]];
}
@endphp
<div class="members-container">
    @foreach($members as $k => $member)
    <div class="clone">
        <div class="row align-items-center">
            <div class="col-lg-11">
                <div class="from-group row">
                    <div class="col-lg-4">
                        <label for="member_name_{{ $k }}" class="col-form-label">Name:</label>
                        <input type="text" name="members[name][]" id="member_name_{{ $k }}" class="form-control" placeholder="{{ __('Name') }}" value="{{ old("members.name.{$k}", $member->name) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="member_age_{{ $k }}" class="col-form-label">Age:</label>
                        <input type="number" name="members[age][]" id="member_age_{{ $k }}" class="form-control" placeholder="{{ __('Age') }}" value="{{ old("members.age.{$k}", $member->age) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="member_relationship_{{ $k }}" class="col-form-label">Relationship:</label>
                        <input type="text" name="members[relationship][]" id="member_relationship_{{ $k }}" class="form-control" placeholder="{{ __('Relationship') }}" value="{{ old("members.relationship.{$k}", $member->relationship) }}"/>
                    </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                <div class="from-group row">
                    <div class="col-lg-4">
                        <label for="member_occupation_{{ $k }}" class="col-form-label">Occupation:</label>
                        <input type="text" name="members[occupation][]" id="member_occupation_{{ $k }}" class="form-control" placeholder="{{ __('Occupation') }}" value="{{ old("members.occupation.{$k}", $member->occupation) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="member_martial_status_{{ $k }}" class="col-form-label">Martial Status:</label><br>
                        <select name="members[martial_status][]" id="member_martial_status_{{ $k }}" class="form-control m-select2" style="width: 100%">
                            {!! selectBox(DB_enumValues('employee_rel', 'martial_status'), old("rel.martial_status.{$k}", $member->martial_status)) !!}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="member_dependent_{{ $k }}" class="col-form-label">Dependent:</label><br>
                        <select name="members[dependent][]" id="member_dependent_{{ $k }}" class="form-control" style="width: 100%">
                            {!! selectBox(DB_enumValues('employee_members', 'dependent'), old("rel.dependent.{$k}", $member->dependent)) !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <button type="button" class="btn btn-success btn-icon add-more" clone-container=".members-container" callback="members_cb"><i class="la la-plus"></i></button>
                <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".members-container-.clone"><i class="la la-trash"></i></button>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    </div>
    @endforeach
</div>
<script>
    function members_cb(clone, cc){
        const index = cc.find('.clone').length - 1;
        //$('select[multiple]', clone).attr('name', 'leaves_id['+ index +'][]');

        $('[data-select2-id]').not('select[data-select2-id], .select2-container[data-select2-id]').removeAttr('data-select2-id')
        $('.select2-container', clone).remove();
        $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
        $('.m-select2', clone).select2();
    }
</script>
