@extends('layouts.app')

@section('title', 'Calendrier d\'Équipe')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="premium-card p-4">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: '{{ route("calendar.events") }}',
            height: 'auto',
            navLinks: true,
            dayMaxEvents: true,
            themeSystem: 'standard',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            }
        });
        calendar.render();
    });
</script>
<style>
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f1f5f9;
        padding: 5px;
    }
    .fc .fc-toolbar-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1e293b;
    }
    .fc .fc-button-primary {
        background-color: #6366f1;
        border-color: #6366f1;
    }
    .fc .fc-button-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
</style>
@endsection
