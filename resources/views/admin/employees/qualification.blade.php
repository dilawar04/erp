@php
    if($row->id > 0){
        $qualifications = \DB::table('employee_qualifications')->where(['user_id' => $row->id])->get();
    } else {
        $qualifications = [[]];
    }
@endphp

<div class="qualifications-container">
    @foreach($qualifications as $k => $qualification)
    <div class="clone">
        <div class="row">
            <div class="col-lg-11">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="qualification_{{ $k }}" class="col-form-label">Qualification:</label><br>
                        <select name="qualifications[qualification][]" id="qualification_{{ $k }}" class="form-control m-select2" style="width: 100%">
                            {!! selectBox(DB_enumValues('employee_qualifications', 'qualification'), old("qualifications.qualification.{$k}", $qualification->qualification)) !!}
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="subject_{{ $k }}" class="col-form-label">Subject:</label>
                        <input type="text" name="qualifications[subject][]" id="subject_{{ $k }}" class="form-control" placeholder="{{ __('Subject') }}" value="{{ old("qualifications.subject.{$k}", $qualification->subject) }}"/>
                    </div>
                    <div class="col-lg-5">
                        <label for="institution_{{ $k }}" class="col-form-label">Institution:</label>
                        <input type="text" name="qualifications[institution][]" id="institution_{{ $k }}" class="form-control" placeholder="{{ __('Institution') }}" value="{{ old("qualifications.institution.{$k}", $qualification->institution) }}"/>
                    </div>
                    <div class="col-lg-2">
                        <label for="grade_marks_{{ $k }}" class="col-form-label">Grade/Marks:</label>
                        <input type="text" name="qualifications[marks][]" id="grade_marks_{{ $k }}" class="form-control" placeholder="{{ __('Grade/Marks') }}" value="{{ old("qualifications.marks.{$k}", $qualification->marks) }}"/>
                    </div>

                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                <div class="form-group row justify-content-center">
                    <div class="col-lg-3">
                        <label for="passing_year_{{ $k }}" class="col-form-label">Year Of Passing:</label>
                        <input type="number" name="qualifications[passing_year][]" id="passing_year_{{ $k }}" class="form-control" placeholder="{{ __('Year Of Passing') }}" value="{{ old("qualifications.passing_year.{$k}", $qualification->passing_year) }}"/>
                    </div>
                    <div class="col-lg-3 text-center">
                        <label for="document" class="col-form-label">{{ __('Upload Document') }}:</label><br>
                        <input disabled type="hidden" name="photo--rm" value="{{ $row->document }}">
                        @php
                            $file_input = '<input type="file" name="image" accept="jpg,jpeg,png,bmp,gif,pdf,doc,docx" name="photo" id="photo" class="form-control custom-file-input" placeholder="'.__('Photo').'" value="'.($row->photo).'" >';
                            $thumb_url = asset_url("{$_this->module}/" . $row->document);
                            $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/document', true);
                            echo thumb_box($file_input, $thumb_url, $delete_img_url);
                        @endphp
                        <span class="form-text text-muted">"jpg, png, bmp, gif, pdf,doc,docx" file extension's</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <p style="margin-top: 6px;">&nbsp;</p>
                <button type="button" class="btn btn-success btn-icon add-more" clone-container=".qualifications-container" callback="qualifications_cb"><i class="la la-plus"></i></button>
                <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".qualifications-container-.clone"><i class="la la-trash"></i></button>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    </div>
    @endforeach
</div>
<script>
    function qualifications_cb(clone, cc){
        const index = cc.find('.clone').length - 1;
        //$('select[multiple]', clone).attr('name', 'leaves_id['+ index +'][]');

        $('[data-select2-id]').not('select[data-select2-id], .select2-container[data-select2-id]').removeAttr('data-select2-id')
        $('.select2-container', clone).remove();
        $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
        $('.m-select2', clone).select2();
    }
</script>
