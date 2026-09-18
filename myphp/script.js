document.addEventListener('DOMContentLoaded', () => {
    const formFeedback = document.getElementById('form-feedback');
    if (formFeedback && formFeedback.classList.contains('success')) {
        window.setTimeout(() => {
            formFeedback.classList.add('is-hidden');
        }, 5000);
    }

    const userData = window.dashboardData || {};
    const name = userData.name || 'Utilisateur';
    const firstName = name.split(' ')[0];
    const cycleDay = userData.cycleDay || '-';
    const totalCycleDays = userData.totalCycleDays || '-';

    const setText = (id, value) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    };

    setText('top-user-name', name);
    setText('user-firstname', firstName);
    setText('circle-day', cycleDay);
    setText('current-phase', userData.currentPhase || 'Aucune donnée');
    setText('next-period-date', userData.nextPeriodDate || '-');

    const today = new Intl.DateTimeFormat('fr-FR', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
    }).format(new Date());
    setText('today-date', today.charAt(0).toUpperCase() + today.slice(1));

    const cycleRing = document.querySelector('.cycle-ring');
    if (cycleRing && Number.isFinite(Number(cycleDay)) && Number(totalCycleDays) > 0) {
        const progress = Math.min(Number(cycleDay) / Number(totalCycleDays), 1) * 100;
        cycleRing.style.background = `conic-gradient(#c46786 0 ${progress}%, #f0d5dc ${progress}% 100%)`;
    }

    document.querySelectorAll('.symptom').forEach((symptom) => {
        symptom.addEventListener('click', () => {
            document.querySelectorAll('.symptom').forEach((item) => item.classList.remove('selected'));
            symptom.classList.add('selected');
        });
    });

    const menuToggle = document.getElementById('burger');
    const topNav = document.querySelector('.top-nav');
    menuToggle?.addEventListener('click', () => {
        const isOpen = topNav.classList.toggle('active');
        menuToggle.setAttribute('aria-expanded', String(isOpen));
        menuToggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
    });

    const calendarGrid = document.getElementById('cycle-calendar-grid');
    const calendarLabel = document.getElementById('calendar-month-label');
    const startDate = userData.cycleStartDate ? new Date(`${userData.cycleStartDate}T00:00:00`) : null;
    const nextPeriodStart = userData.nextPeriodStart ? new Date(`${userData.nextPeriodStart}T00:00:00`) : null;
    let displayedMonth = nextPeriodStart
        ? new Date(nextPeriodStart.getFullYear(), nextPeriodStart.getMonth(), 1)
        : (startDate ? new Date(startDate.getFullYear(), startDate.getMonth(), 1) : new Date());

    const sameDate = (firstDate, secondDate) => firstDate.toDateString() === secondDate.toDateString();

    const renderCalendar = () => {
        if (!calendarGrid || !calendarLabel || !startDate) {
            return;
        }

        const year = displayedMonth.getFullYear();
        const month = displayedMonth.getMonth();
        const firstDay = new Date(year, month, 1);
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const mondayIndex = (firstDay.getDay() + 6) % 7;
        const today = new Date();
        const currentCycleDate = new Date(startDate);
        currentCycleDate.setDate(currentCycleDate.getDate() + Number(userData.cycleDay || 1) - 1);
        const cycleLength = Number(userData.totalCycleDays || 28);
        const periodLength = Number(userData.periodDuration || 5);
        const millisecondsPerDay = 24 * 60 * 60 * 1000;

        const dateDifferenceInDays = (firstDateValue, secondDateValue) => Math.round(
            (Date.UTC(
                secondDateValue.getFullYear(),
                secondDateValue.getMonth(),
                secondDateValue.getDate(),
            ) - Date.UTC(
                firstDateValue.getFullYear(),
                firstDateValue.getMonth(),
                firstDateValue.getDate(),
            )) / millisecondsPerDay,
        );

        calendarLabel.textContent = new Intl.DateTimeFormat('fr-FR', {
            month: 'long',
            year: 'numeric',
        }).format(displayedMonth);
        calendarGrid.innerHTML = '';

        for (let index = 0; index < mondayIndex + daysInMonth; index += 1) {
            const dayNumber = index - mondayIndex + 1;
            const day = document.createElement('span');
            day.className = 'calendar-day';

            if (dayNumber > 0) {
                const date = new Date(year, month, dayNumber);
                day.textContent = dayNumber;
                const daysFromCycleStart = dateDifferenceInDays(startDate, date);

                if (daysFromCycleStart >= 0) {
                    const cycleNumber = Math.floor(daysFromCycleStart / cycleLength);
                    const dayInCycle = daysFromCycleStart % cycleLength;
                    const cycleStart = new Date(startDate);
                    cycleStart.setDate(cycleStart.getDate() + cycleNumber * cycleLength);

                    if (dayInCycle < periodLength) {
                        day.classList.add(cycleNumber === 0 ? 'period-day' : 'next-period-day');
                        day.title = cycleNumber === 0
                            ? 'Règles : ' + date.toLocaleDateString('fr-FR')
                            : 'Prochaines règles : ' + date.toLocaleDateString('fr-FR');
                    }

                    const fertileWindowStart = new Date(cycleStart);
                    fertileWindowStart.setDate(fertileWindowStart.getDate() + cycleLength - 19);
                    const fertileWindowEnd = new Date(cycleStart);
                    fertileWindowEnd.setDate(fertileWindowEnd.getDate() + cycleLength - 14);
                    if (date >= fertileWindowStart && date <= fertileWindowEnd) {
                        day.classList.add('fertile-day');
                        day.title = 'Période fertile : ' + date.toLocaleDateString('fr-FR');
                    }

                    const estimatedOvulation = new Date(cycleStart);
                    estimatedOvulation.setDate(estimatedOvulation.getDate() + cycleLength - 16);
                    if (sameDate(date, estimatedOvulation)) {
                        day.classList.add('ovulation-day');
                        day.title = 'Ovulation estimée : ' + date.toLocaleDateString('fr-FR');
                    }
                }
                if (sameDate(date, today)) {
                    day.classList.add('today-day');
                }
                if (sameDate(date, currentCycleDate)) {
                    day.classList.add('cycle-day');
                }
            } else {
                day.classList.add('empty-day');
            }

            calendarGrid.appendChild(day);
        }
    };

    document.getElementById('previous-month')?.addEventListener('click', () => {
        displayedMonth.setMonth(displayedMonth.getMonth() - 1);
        renderCalendar();
    });
    document.getElementById('next-month')?.addEventListener('click', () => {
        displayedMonth.setMonth(displayedMonth.getMonth() + 1);
        renderCalendar();
    });
    renderCalendar();
});