window.calendarInterop = {
    renderCalendar: function (elementId, eventsJson) {
        const calendarEl = document.getElementById(elementId);
        const events = JSON.parse(eventsJson);

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: events
        });

        calendar.render();
    }
};
