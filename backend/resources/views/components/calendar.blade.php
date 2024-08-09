<style>
.calendar {
    display: flex;
    flex-direction: column;
    width: 300px;
    margin: auto;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    margin-top: 10px;
}
.day {
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #000000;
}
.empty {
    background-color: #f0f0f0;
}
</style>
<body>
    <div class="calendar">
        <div class="calendar-header">
            <button onclick="prevMonth()">Poprzedni</button>
            <div id="monthYear"></div>
            <button onclick="nextMonth()">Następny</button>
        </div>
        <div class="calendar-body" id="calendarDays">
        </div>
    </div>

    <script>
        const calendarDays = document.getElementById('calendarDays');
        const monthYear = document.getElementById('monthYear');
        let date = new Date();

        function renderCalendar() {
            calendarDays.innerHTML = '';
            monthYear.innerHTML = date.toLocaleDateString('pl-PL', { month: 'long', year: 'numeric' });

            const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
            const lastDateOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
            const lastDayOfLastMonth = new Date(date.getFullYear(), date.getMonth(), 0).getDate();

            for (let i = firstDayOfMonth; i > 0; i--) {
                calendarDays.innerHTML += `<div class="day empty">${lastDayOfLastMonth - i + 1}</div>`;
            }

            for (let i = 1; i <= lastDateOfMonth; i++) {
                calendarDays.innerHTML += `<div class="day">${i}</div>`;
            }
        }

        function prevMonth() {
            date.setMonth(date.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            date.setMonth(date.getMonth() + 1);
            renderCalendar();
        }

        renderCalendar();
    </script>
</body>
</html>
