document.addEventListener('DOMContentLoaded', () => {
    // Données de l'utilisateur
    const userData = {
        name: "Sophie M.",
        currentPhase: "Phase ovulatoire",
        cycleDay: 14,
        totalCycleDays: 28,
        nextPeriodDate: "12 Sep.",
        fertileWindow: "11 – 16 Sep.",
        avgCycleLength: 27,
        periodDuration: 5,
        lastPeriodRange: "15–19 août",
        regularity: 95,
        registeredCycles: 6,
        startedSince: "avr. 2025"
    };

    // Suivi d'aujourd'hui3
    const dailyLog = {
        mood: "Bien",
        sleepHours: "7h30",
        energyLevel: "Haute",
        painLevel: "Aucune"
    };

    // Historique des cycles
    const cycleHistory = [
        { month: "Avr", days: 27, isCurrent: false },
        { month: "Mai", days: 28, isCurrent: false },
        { month: "Jun", days: 26, isCurrent: false },
        { month: "Jul", days: 28, isCurrent: false },
        { month: "Août", days: 28, isCurrent: true },
        { month: "Sep", days: 0, isCurrent: false }
    ];

    // --- Injection des données dans le HTML ---

    // Sidebar
    document.getElementById('sidebar-cycle-day').textContent = userData.cycleDay;
    document.getElementById('sidebar-total-days').textContent = userData.totalCycleDays;
    document.getElementById('sidebar-progress-fill').style.width = `${(userData.cycleDay / userData.totalCycleDays) * 100}%`;
    document.getElementById('sidebar-user-name').textContent = userData.name;
    document.getElementById('sidebar-user-phase').textContent = userData.currentPhase;

    // Header / Phase
    document.getElementById('circle-day').textContent = userData.cycleDay;
    document.getElementById('user-firstname').textContent = userData.name.split(' ')[0].toUpperCase();
    document.getElementById('current-phase').textContent = userData.currentPhase.toLowerCase();
    document.getElementById('next-period-date').textContent = userData.nextPeriodDate;
    document.getElementById('fertile-window').textContent = userData.fertileWindow;

    // Daily Logs
    document.getElementById('log-mood').textContent = dailyLog.mood;
    document.getElementById('log-sleep').textContent = dailyLog.sleepHours;
    document.getElementById('log-energy').textContent = dailyLog.energyLevel;
    document.getElementById('log-pain').textContent = dailyLog.painLevel;

    // Metrics
    document.getElementById('metric-cycle-days').textContent = `${userData.totalCycleDays}j`;
    document.getElementById('metric-avg-cycle').textContent = userData.avgCycleLength;
    document.getElementById('metric-period-duration').textContent = `${userData.periodDuration}j`;
    document.getElementById('metric-last-period-range').textContent = userData.lastPeriodRange;
    document.getElementById('metric-regularity').textContent = `${userData.regularity}%`;
    document.getElementById('metric-registered-cycles').textContent = userData.registeredCycles;
    document.getElementById('metric-started-since').textContent = userData.startedSince;

    // Historique des cycles (Génération du graphique)
    const chartContainer = document.getElementById('bar-chart-container');
    chartContainer.innerHTML = '';

    cycleHistory.forEach(item => {
        const barGroup = document.createElement('div');
        barGroup.className = 'bar-group';

        const topLabel = item.days > 0 ? `${item.days}j` : '—';
        const height = item.days > 0 ? item.days * 3 : 20;
        const currentClass = item.isCurrent ? 'current' : '';

        barGroup.innerHTML = `
            <span class="bar-label-top">${topLabel}</span>
            <div class="bar ${currentClass}" style="height: ${height}px;"></div>
            <span class="bar-label-bottom">${item.month}</span>
        `;

        chartContainer.appendChild(barGroup);
    });

    // Événement du bouton
    document.getElementById('openLogModal').addEventListener('click', () => {
        alert('Formulaire de mise à jour des entrées du jour.');
    });
});