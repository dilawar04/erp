@php
    $user_id = Auth::id();
    if($row->id > 0){
        $task = $row;
    } else {
        $task = \App\Task::where('assign_to', $user_id)->whereIn('status', ['Start', 'Pause'])->whereRaw(" NOW() BETWEEN tasks.start_date AND tasks.end_date")->orderBy('status', 'asc')->first();
    }
    // if($task->id > 0){
        $activity = \App\ActivityLog::orderBy('id', 'DESC')->whereIn('activity', ['start_task', 'update_task'])->where(['rel_id' => $task->id, 'user_id' => $user_id, 'table' => 'tasks'])->first();
        $task_log = json_decode($activity->description);

        $diff_sec = 0;
        if($task_log->status == 'Start') {
            $start_date = new DateTime();
            $since_start = $start_date->diff(new DateTime($activity->created_at));
            $diff_sec = ($since_start->h * 3600) + ($since_start->i * 60) + $since_start->s;
        }

        $parsed = date_parse($task->estimate_time);
        $task_sec = ($parsed['hour'] * 3600) + ($parsed['minute'] * 60) + $parsed['second'];
        $task_sec -= intval($task_log->spent_time + $diff_sec);
        //dd($task_sec);

        $inverse_status = ($task->status == 'Start' ? 'Pause' : 'Start');
@endphp
<style>
    .timer-padding{ padding:  6px 5px 0 5px;}
    .timer-padding .btn{ /*float: right;*/}
    .countdown{display: inline-block; }
    .countdown #clock{
        /*border-radius: 4px;*/
        font-size: 28px;
        color: white;
        padding: 2px  20px;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.2);
        font-family: monospace;
        background: #1e1e2d;  /* fallback for old browsers */

    }
    .task-title{
        color: red;
    }
    .timer-padding .btn.btn-icon {
        height: 35px;
        width: 35px;
        margin-top: -5px;
    }
</style>
<div class="timer-padding">
    <div class="row">

        <div class="col-lg-4">
            <label class="btn btn-danger active btn-icon" style="" id="play-pause" status="{{ $inverse_status }}">
                <i class="la la-{{ strtolower($task->status == 'Start' ? 'pause' : 'play') }}"></i> <span class="clock-status"></span>
            </label>
            <div class="countdown"><span id="clock"><span>{{ gmdate('H:i:s', ($task_sec)) }}</span></span></div>
            {{--<label class="btn btn-success active btn-icon" style="" id="task-done" data-status="done">
                <i class="la la-check"></i>
            </label>--}}
        </div>
        <div class="col-lg-8">
            <div class="" style="margin: 8px 0px;">
                <h4 style="display: inline-block">Task: </h4> <a href="{{ admin_url("briefcase/execute_task/{$task->id}") }}"><b class="task-title">{{ $task->task_type }}</b></a>
            </div>
        </div>
    </div>
</div>

<script>
    let seconds = new Date().getTime() + 1000 * <?php echo $task_sec; ?>;
    <?php if($task->assign_to !== Auth::id()) { echo "seconds = 0;"; }?>
    console.log(seconds);
    //let seconds = new Date().getTime() + (1000 * 4);
    let $clock = $('#clock');
    $clock.countdown(seconds)
        .on('update.countdown', function(event) {
            let $this = $(this);
            $this.html(event.strftime('<span>%H:%M:%S</span>'));
        })
        .on('finish.countdown', function () {
            console.log('End');
        });

    <?php if($task->status == 'Pause'){ ?>
        $clock.countdown('pause');
    <?php } else { ?>
        $clock.countdown('resume');
    <?php } ?>


    function update_task(_this, _status, reason = ''){
        let url = '<?php echo admin_url("briefcase/ajax/update_task/{$task->id}") ?>';
        console.log(url, 'layouts/inc/task_countdown.blade.php:93');
        $.ajax(url, {
            type: 'GET',
            data: {status: _status, reason: reason},
            dataType: 'JSON',
            success: function (json, status, xhr) {
                if (_status === 'Start') {
                    _this.attr('status', 'Pause');
                    //$('.clock-status', this).html('Resume');
                    $('.la', _this).removeClass('la-play').addClass('la-pause');
                    $clock.countdown('resume');
                } else {
                    _this.attr('status', 'Start');
                    //$('.clock-status', this).html('Pause');
                    $('.la', _this).removeClass('la-pause').addClass('la-play');
                    $clock.countdown('pause');
                }
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $.notify('<strong>Error</strong> ' + errorMessage, {type: 'danger'});
            }
        });
    }
    $('#play-pause').click(function() {
        let _this = $(this);
        let _data = _this.data();
        let _status = _this.attr('status');
        console.log(_status);
        if(_status === 'Pause'){
            Swal.fire({
                title: 'Type reason?',
                input: 'text',
                inputPlaceholder: 'Reason',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (input_val) => {
                    update_task(_this, _status, input_val);
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        } else{
            update_task(_this, _status)
        }

    });

    $('#task-done').click(function() {
        let _this = $(this);
        let _data = _this.data();
        let _status = 'Completed';
        swal.fire({
            title: "Are you sure?",
            text: "You won't complete this task!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Confirm!",
            cancelButtonText: "Cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if(e.value){
                let url = '<?php echo admin_url("briefcase/ajax/update_task/{$task->id}") ?>';
                $.ajax(url, {
                    type: 'GET',
                    data: {status: _status},
                    dataType: 'JSON',
                    success: function (json, status, xhr) {
                        console.log(json);
                        window.location.reload();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        $.notify('<strong>Error</strong> ' + errorMessage, {type: 'danger'});
                    }
                });
            }
        });
    });

    console.log($clock);
    /*$(document).on('click', '.start_task', function(e) {
        e.preventDefault();
        if(parseInt('<?php echo intval($task->id) ?>') > 0){
            $.notify('<strong>Warning</strong> Task already started!', {type: 'warning'});
        } else {
            $('.timer-padding').show();
            let _data = $(this).data();
            let url = $(this).attr('href');
            console.log(url, 'layouts/inc/task_countdown.blade.php');
            $.ajax(url, {
                type: 'GET',
                data: {},
                dataType: 'JSON',
                success: function (json, status, xhr) {
                    //console.log(json);
                    let seconds = new Date().getTime() + json.seconds;
                    console.log(seconds);
                    $clock.countdown(seconds);
                    $('#play-pause').click();
                    $('.task-title').html(json.task.title);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    $.notify('<strong>Error</strong> ' + errorMessage, {type: 'danger'});
                }
            });
        }
    });*/

</script>

