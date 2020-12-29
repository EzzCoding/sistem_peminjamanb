@extends ('layout.app')
@section ('content')
<div></div>
<div class="container">
    <div class="response"></div>
    <div id='calendar'></div>  
</div>

<div id="dialog">
    <div id="dialog-body">
        <form id="dayclick" method="post" action="{{url('schedule')}}">
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
                <input type="text" class="form-control" name="start" placeholder="Mulai">
            </div>

            <div class="form-group">
                <label for="Subject">Berakhir</label>
                <input type="text" class="form-control" name="end" placeholder="Berakhir">
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="{{asset ('fullcalendar/fullcalendar.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        header: {
            left    : 'prev,next today',
            center  : 'title',
            right   : 'year,month,basicWeek,basicDay',
        timezone            : 'local',
        height              : "650",
        selectable          : true,
        dragabble           : true,
        defaultView         : 'month',
        yearColumns         : 5,
        durationEditable    : true,
        bootstrap           : true,
},
        dayClick            : function(date, event, view){
            $('#dialog').dialog({
                title:'Tambah Mata Kuliah',
                width: 600, 
                height: 700,
                show:{effect: 'clip', duration: 350}
            })
        }
    })
});
  </script>
@endsection
