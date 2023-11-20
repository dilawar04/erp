@php
    if($row->id > 0){
        $references = \DB::table('employee_references')->where(['user_id' => $row->id])->get();
    } else {
        $references = [[]];
    }
@endphp

<div class="references-container">
    @foreach($references as $k => $reference)
    <div class="clone">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="references_name_{{ $k }}" class="col-form-label">Reference Name:</label>
                        <input type="text" name="references[name][]" id="references_name_{{ $k }}" class="form-control" placeholder="{{ __('Name') }}" value="{{ old("references.name.{$k}", $reference->name) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="references_organization_{{ $k }}" class="col-form-label">Organization:</label>
                        <input type="text" name="references[organization][]" id="references_organization_{{ $k }}" class="form-control" placeholder="{{ __('Organization') }}" value="{{ old("references.organization.{$k}", $reference->organization) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="references_designation_{{ $k }}" class="col-form-label">Designation:</label>
                        <input type="text" name="references[designation][]" id="references_designation_{{ $k }}" class="form-control" placeholder="{{ __('Designation') }}" value="{{ old("references.designation.{$k}", $reference->designation) }}"/>
                    </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="references_contact_{{ $k }}" class="col-form-label">Contact No:</label>
                        <input type="text" name="references[contact][]" id="references_contact_{{ $k }}" class="form-control" placeholder="{{ __('Contact #') }}" value="{{ old("references.contact.{$k}", $reference->contact) }}"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="references_email" class="col-form-label">Email:</label>
                        <input type="text" name="references[email][]" id="references_email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old("references.email.{$k}", $reference->email) }}"/>
                    </div>

                    <div class="col-lg-4">
                        <label for="reference_type{{ $k }}" class="col-form-label">Reference Type:</label>
                        <select name="references[type][]" itemid="reference_type{{ $k }}" id="type" class="form-control">
                            {!! selectBox(DB_enumValues('employee_references', 'type'), old("references.type.{$k}", $reference->type)) !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 text-center">
                <label for="file" class="-col-lg-2 -col-sm-12 -col-form-label">File Upload:</label><br>

                <input disabled type="hidden" name="references_file--rm" value="{{ $reference_file }}">
                @php
                    $file_input = '<input type="file" name="references_file" accept="pdf,doc,docx" id="references_file" class="form-control custom-file-input" placeholder="'.__('File').'" value="'.($row->references_file).'" >';
                    $thumb_url = asset_url("{$_this->module}/" . $reference_file);
                    $delete_img_url = admin_url('ajax/delete_img/' . $row->id . '/references_file', true);
                    echo thumb_box($file_input, $thumb_url, $delete_img_url);
                @endphp
                <span class="form-text text-muted">"pdf,doc,docx" file extension's</span>
            </div>
            <div class="col-lg-1">
                <p style="margin-top: 6px;">&nbsp;</p>
                <button type="button" class="btn btn-success btn-icon add-more" clone-container=".references-container" callback="references_cb"><i class="la la-plus"></i></button>
                <button type="button" class="btn btn-danger btn-icon" remove-limit="1" remove-el=".references-container-.clone"><i class="la la-trash"></i></button>
            </div>
        </div>
        <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
    </div>
    @endforeach
</div>
<script>
    function references_cb(clone, cc){
        const index = cc.find('.clone').length - 1;
        //$('select[multiple]', clone).attr('name', 'leaves_id['+ index +'][]');

        $('[data-select2-id]').not('select[data-select2-id], .select2-container[data-select2-id]').removeAttr('data-select2-id')
        $('.select2-container', clone).remove();
        $('.m-select2', clone).removeClass('select2-offscreen, select2-hidden-accessible').removeAttr('data-select2-id');
        $('.m-select2', clone).select2();
    }
</script>
