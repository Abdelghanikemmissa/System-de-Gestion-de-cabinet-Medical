@extends('dashboard.medecin.layout')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <h2 class="text-xl font-bold mb-6">Agenda du Cabinet</h2>
    <div id='calendar'></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fr', // Langue française
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      events: @json($events), // On injecte les données PHP ici
      eventClick: function(info) {
        // Redirection vers le dossier quand on clique sur un RDV
        if (info.event.url) {
            window.location.href = info.event.url;
            return false;
        }
      }
    });
    calendar.render();
  });
</script>
@endsection