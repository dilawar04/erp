@php
$countdown = json_decode(opt('countdown'));
$transactions = json_decode(opt('transactions'));
@endphp
<div class="mt-3"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Contract:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[contract]" class="form-control" value="{{ opt('contract') }}" autocomplete="off" />
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>


<div class="form-group row">
    <label class="col-lg-2 col-form-label">Countdown:</label>
    <div class="col-lg-10">
        <select id="countdown_status" name="opt[countdown][status]" class="form-control">
            <?php
            $OP = ['No', 'Yes'];
            echo selectBox(array_combine($OP, $OP), $countdown->status);
            ?>
        </select>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Countdown Date:</label>
    <div class="col-lg-10">
        <input type="text" name="opt[countdown][date]" class="form-control datetimepicker" value="{{ $countdown->date }}" autocomplete="off" />
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<hr>

<div class="form-group row">
    <label class="col-lg-2 col-form-label">Coin Name:</label>
    <div class="col-lg-2">
        <input type="text" name="opt[coin_name]" id="coin_name" class="form-control" value="{{ opt('coin_name') }}">
    </div>

    <label class="col-lg-2 col-form-label">Coin Prize:</label>
    <div class="col-lg-2">
        <div class="input-group m-input-group">
            <input type="text" name="opt[coin_price]" id="coin_price" class="form-control" value="{{ opt('coin_price') }}">
            <div class="input-group-append">
                <span class="input-group-text">USD</span>
            </div>
        </div>
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

<div class="form-group row justify-content-center">
    <div class="col-lg-2">
        <label class="col-form-label">Total Tokens Bought:</label>
        <input type="text" name="opt[transactions][total]" class="form-control" value="{{ $transactions->total }}" autocomplete="off" />
    </div>
    <div class="col-lg-2">
        <label class="col-form-label">Transactions in last 24h</label>
        <input type="text" name="opt[transactions][last_24]" class="form-control" value="{{ $transactions->last_24 }}" autocomplete="off" />
    </div>
    <div class="col-lg-2">
        <label class="col-form-label">Transactions per hour</label>
        <input type="text" name="opt[transactions][per_hour]" class="form-control" value="{{ $transactions->per_hour }}" autocomplete="off" />
    </div>
    <div class="col-lg-2">
        <label class="col-form-label">Largest Transactions</label>
        <input type="text" name="opt[transactions][largest]" class="form-control" value="{{ $transactions->largest }}" autocomplete="off" />
    </div>
    <div class="col-lg-2">
        <label class="col-form-label">Years of Experience</label>
        <input type="text" name="opt[transactions][experience]" class="form-control" value="{{ $transactions->experience }}" autocomplete="off" />
    </div>
</div>
<div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>

