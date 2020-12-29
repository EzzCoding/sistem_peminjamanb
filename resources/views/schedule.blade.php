@extends ('layout.app')
@section ('content')
<div></div>
<div class="container">
    <div class="response"></div>
    <div id='calendar'></div>  
</div>

<div id="dialog">
    <div id="dialog-body">
        <form id="dayclick" method="post" action="{{route('subjectStore')}}">
            @csrf
            <div class="form-group">
                <label for="Subject">Mata Kuliah</label>
                <input type="text" class="form-control" name="subject" placeholder="Mata Kuliah">
            </div>

            <div class="form-group">
                <label for="Subject">Dosen</label>
                <input type="text" class="form-control" name="teacher" placeholder="Dosen">
            </div>

            <div class="form-group">
                <label for="Subject">Mulai</label>
                <input type="text" class="form-control" id="start" name="start" placeholder="Mulai">
            </div>

            <div class="form-group">
                <label for="Subject">Berakhir</label>
                <input type="text" class="form-control" id="end" name="end" placeholder="Berakhir">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="{{asset ('fullcalendar/fullcalendar.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$(document).ready(function() {
    function convert(str){
        const d     = new Date(str);
        let month   = '' + (d.getMonth() +1);
        let day     = '' + d.getDate();
        let year    = d.getFullYear();
        if (month.length < 2) month = '0'+ month;
        if (day.length < 2) day = '0' + day;
        let hour    = '' + d.getUTCHours();
        let minutes = '' + d.getUTCMinutes();
        let seconds = '' + d.getUTCSeconds();
        if(hour.length < 2) hour = '0' + hour;
        if(minutes.length < 2) hour = '0' + minutes;  
        if(seconds.length < 2) hour = '0' + seconds;  
        return [year, month, day].join('-') + ' ' +[hour, minutes, seconds].join(':');
    }
    var calendar = $('#calendar').fullCalendar({
        header: {
            left    : 'prev,next today',
            center  : 'title',
            right   : 'year,month,basicWeek,basicDay'
        },
        timezone            : 'local',
        height              : "650",
        selectable          : true,
        dragabble           : true,
        defaultView         : 'month',
        yearColumns         : 5,
        durationEditable    : true,
        bootstrap           : true,
        events              :"{{route('allSchedule')}}",
        dayClick            : function(date, event, view){
            $('#start').val(convert(date));
            $('#end').val(convert(date));
            $('#dialog').dialog({
                title       :'Tambah Mata Kuliah',
                width       : 600, 
                height      : 700,
                modal       : true,
                show        : {effect: 'clip', duration: 350},
                hide        : {effect: 'clip', duration: 250}
            })
        }
    })
});
  </script>
@endsection
