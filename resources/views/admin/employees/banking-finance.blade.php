@php
    if($row->id > 0){
        $banks = json_decode($row->banks);
    } else {
        $banks = [[]];
    }
@endphp
<div class="form-group row">
    <div class="col-lg-6">
        <label for="bank_name" class="col-form-label">Bank Name:</label>
        <input type="text" name="rel[banks][name]" id="bank_name" class="form-control" placeholder="Bank Name" value="{{ old("rel.banks.name", $banks->name) }}">
    </div>
    <div class="col-lg-6">
        <label for="sales_tax" class="col-form-label">Branch Name:</label>
        <input type="text" name="rel[banks][branch]" id="branch_name" class="form-control" placeholder="Branch Name" value="{{ old("rel.banks.name", $banks->branch) }}">
    </div>
    <div class="col-lg-6">
        <label for="ntn" class="col-form-label">Account No:</label>
        <input type="text" name="rel[banks][account_no]" id="account_no" class="form-control" placeholder="Account No" value="{{ old("rel.banks.name", $banks->account_no) }}">
    </div>
    <div class="col-lg-6">
        <label for="sales_tax" class="col-form-label">IBAN:</label>
        <input type="text" name="rel[banks][IBAN]" id="iban" class="form-control" placeholder="IBAN" value="{{ old("rel.banks.name", $banks->IBAN) }}">
    </div>
</div>
