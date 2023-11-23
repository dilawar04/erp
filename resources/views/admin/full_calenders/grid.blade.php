@php $form_buttons = ['save', 'view', 'delete', 'back']; @endphp
@extends('admin.layouts.admin')
@section('content')

<style>
    .select2-container--default{
        width: 100% !important;
    }
    #toast-container > .toast-warning {
        background-color: #cd1d1d;
        color: #b6bbcd;
        font-weight: 700;
    }
    #toast-container > .toast-success {
        background-color: #1d34cd;
        color: #b6bbcd;
        font-weight: 700;
    }
    .toast .toast-title {
        color:#ffffff;
    }
    .calender-btn {
        padding: 7px 20px 7px 20px !important;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    span.fc-icon.fc-icon-right-single-arrow {
        font-family: LineAwesome !important;
    }
    span.fc-icon.fc-icon-left-single-arrow {
        font-family: LineAwesome !important;
    }
</style>

@php   
    $working_days = json_decode($EventsCalender->working_days);
@endphp

<div class="container">
    <br />
    <h1 class="text-center text-primary">Calendar</h1>
    <div class="container">
        <div class="row">
            <input type="hidden" name="id" value="{{ $EventsCalender->id }}" id="weekid">
            <div class="col-lg-6">
                <label for="calendar-setup" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Week starts from') }}:</label>
                <select class="m-select2 w-100" name="weeks_start_from" id="weeks_start_from">
                    @php
                        $_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    @endphp
                    {!! selectBox(array_combine($_days, $_days), $EventsCalender->weeks_start_from) !!}
                </select>
                <!-- <input type="text" name="weeks_start_from" value="" id="weeks_start_from"> -->
            </div>  
            <div class="col-lg-4">
                <label for="calendar-setup" class="col-form-label" style="text-align: right !important;display: flex;">{{ __('Working days') }}:</label>
                <select class="m-select2 w-100" name="working_days[]" multiple="multiple" id="working_days">
                    @php
                        $_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    @endphp
                    {!! selectBox(array_combine($_days, $_days), $working_days) !!}
                </select>
            </div>  
            <div class="kt-portlet__foot">
                <button type="submit" class="btn btn-primary calender-btn" id="calendarbtn">Submit</button>
            </div>          
        </div>
    </div>  
    <br />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>            
        </div>
    </div>        

</div>
@endsection {{-- Scripts --}} @section('scripts')

<script>

$(document).ready(function () {
    $('#calendarbtn').on('click', function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var weekid = $('#weekid').val();
        var weeks_start_from = $('#weeks_start_from').val();
        var working_days = $('#working_days').val();
          $.ajax({
            url: "/admin/full_calenders/action",
            type: "POST",
            data: {
                _token: CSRF_TOKEN,
                id: weekid,
                weeks_start_from: weeks_start_from,
                working_days: working_days,
                type: 'calender'
            },
            cache: false,
            success: function(dataResult){
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                
            }
        });
    });

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    var calendar = $('#calendar').fullCalendar({
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events:'/admin/full_calenders',
        selectable:true,
        selectHelper: true,
        select:function(start, end, allDay)
        {
            var title = prompt('Event Title:');
            if(title)
            {
                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
                $.ajax({
                    url:"/admin/full_calenders/action",
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        type: 'add'
                    },
                    success:function(data)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessage("Event Created Successfully");
                    }
                })
            }
        },
        editable:true,
        eventResize: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/admin/full_calenders/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    displayMessage("Event Updated Successfully");
                }
            })
        },
        eventDrop: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/admin/full_calenders/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    displayMessage("Event Updated Successfully");
                }
            })
        },

        eventClick:function(event)
        {
            if(confirm("Are you sure you want to remove it?"))
            {
                var id = event.id;
                $.ajax({
                    url:"/admin/full-calenders/action",
                    type:"POST",
                    data:{
                        id:id,
                        type:"delete"
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessageDanger("Event Deleted Successfully");
                    }
                })
            }
        }
    });
});
function displayMessage(message) {
    toastr.success(message, 'Event');            
}
function displayMessageDanger(message) {
    toastr.warning(message, 'Event');            
}
  
</script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

@endsection
