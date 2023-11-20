@php
    if($row->id > 0){
        $emergency_contact = json_decode($row->emergency_contact);
    } else {
        $emergency_contact = [[]];
    }
@endphp
<h5>Emergency Contact 1:</h5>
<div class="form-group row">
    <div class="col-lg-3">
        <label for="name_1" class="col-form-label">Name:</label>
        <input type="text" name="rel[emergency_contact][name][]" id="name_1" class="form-control" placeholder="Name" value="{{ old("rel.emergency_contact.name.0", $emergency_contact->name[0]) }}">
    </div>
    <div class="col-lg-3">
        <label for="relationship_1" class="col-form-label">Relationship:</label>
        <input type="text" name="rel[emergency_contact][relationship][]" id="relationship_1" class="form-control" placeholder="Relationship" value="{{ old("rel.emergency_contact.name.0", $emergency_contact->relationship[0]) }}">
    </div>
    <div class="col-lg-3">
        <label for="contact_1_1" class="col-form-label">Contact NO:1:</label>
        <input type="text" name="rel[emergency_contact][contact_1][]" id="contact_1_1" class="form-control" placeholder="Contact" value="{{ old("rel.emergency_contact.name.0", $emergency_contact->contact_1[0]) }}">
    </div>
    <div class="col-lg-3">
        <label for="contact_1_2" class="col-form-label">Contact No:2:</label>
        <input type="text" name="rel[emergency_contact][contact_2][]" id="contact_1_2" class="form-control" placeholder="Contact" value="{{ old("rel.emergency_contact.name.0", $emergency_contact->contact_2[0]) }}">
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
<h5>Emergency Contact 2:</h5>
<div class="form-group row">
    <div class="col-lg-3">
        <label for="name_1" class="col-form-label">Name:</label>
        <input type="text" name="rel[emergency_contact][name][]" id="name_1" class="form-control" placeholder="Name" value="{{ old("rel.emergency_contact.name.1", $emergency_contact->name[1]) }}">
    </div>
    <div class="col-lg-3">
        <label for="relationship_1" class="col-form-label">Relationship:</label>
        <input type="text" name="rel[emergency_contact][relationship][]" id="relationship_1" class="form-control" placeholder="Relationship" value="{{ old("rel.emergency_contact.name.1", $emergency_contact->relationship[1]) }}">
    </div>
    <div class="col-lg-3">
        <label for="contact_1_1" class="col-form-label">Contact NO:1:</label>
        <input type="text" name="rel[emergency_contact][contact_1][]" id="contact_1_1" class="form-control" placeholder="Contact" value="{{ old("rel.emergency_contact.name.1", $emergency_contact->contact_1[1]) }}">
    </div>
    <div class="col-lg-3">
        <label for="contact_1_2" class="col-form-label">Contact No:2:</label>
        <input type="text" name="rel[emergency_contact][contact_2][]" id="contact_1_2" class="form-control" placeholder="Contact" value="{{ old("rel.emergency_contact.name.1", $emergency_contact->contact_2[1]) }}">
    </div>
</div>
