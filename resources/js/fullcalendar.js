import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import caLocale from '@fullcalendar/core/locales/ca';

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.href === "http://localhost/") {
        const calendarEl = document.getElementById('calendar');
        const events = JSON.parse(calendarEl.dataset.events);
        if (calendarEl) {
            const calendar = new Calendar(calendarEl, {
                locale: caLocale,
                nowIndicator: true,
                height: '90vh',
                snapDuration: 1,
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                initialView: 'timeGridWeek',
                buttonText: {
                    today: 'Avui',
                    month: 'Mes',
                    week: 'Setmana',
                    day: 'Dia',
                    next: 'Següent',
                    prev: 'Anterior',
                    nextYear: 'Any següent',
                    prevYear: 'Any anterior'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                },
                views: {
                    timeGridWeek: {
                        type: 'timeGridWeek',
                        slotMinTime: '06:00',
                        slotMaxTime: '22:00',
                    },
                    timeGridDay: {
                        type: 'timeGridDay',
                        slotMinTime: '06:00',
                        slotMaxTime: '22:00'
                    }
                },

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'createReservation dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: events,

                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '08:00',
                    endTime: '18:00',
                },

                editable: true,

                eventDurationEditable: false,

                customButtons: {
                    createReservation: {
                        text: "+",
                        hint: "Crear una nova reserva",
                        click: function () {
                            document.location.href = "/reservations/create";
                        }
                    }
                },

                eventDrop: function (info) {
                    updateEvent(info.event);
                },

                eventClick: function (info) {
                    openEvent(info.event);
                }
            });
            calendar.render();

            function openEvent(event) {
                const eventId = event.id;

                document.location.href = `/reservations/${eventId}`;
            }

            function updateEvent(event) {
                const eventStart = new Date(event.start.getTime() - event.start.getTimezoneOffset() * 60000);
                const eventData = {
                    id: event.id,
                    start: eventStart.toISOString() // Retorna en format ISO sense canviar l'hora
                };


                fetch('/reservations/update_calendar', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(eventData),

                })
                    .then(response => response.json())
                    .then(data => {

                        if (!data.success) {
                            alert('No s\'ha pogut actualitzar l\'esdeveniment.');
                            location.reload();
                        }
                    }).catch(error => {
                    console.error('Error:', error);
                })
            }


        }
    }
});
