window.dashboardCharts = {};

window.renderDashboardCharts = (data) => {

    const { leadStages, weekly, activityThisWeek, monthlyActivity } = data;

    window.dashboardCharts.leadPie = new Chart(document.getElementById("leadPieChart"), {
        type: 'pie',
        data: {
            labels: leadStages.labels,
            datasets: [{
                data: leadStages.values,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6f42c1', '#dc3545']
            }]
        }
    });

    window.dashboardCharts.weeklyLine = new Chart(document.getElementById("weeklyLineChart"), {
        type: 'line',
        data: {
            labels: weekly.labels,
            datasets: weekly.datasets.map(ds => ({
                label: ds.label,
                data: ds.data,
                fill: false,
                borderColor: ds.color,
                tension: 0.1
            }))
        }
    });

    window.dashboardCharts.salesPie = new Chart(document.getElementById("salesPieChart"), {
        type: 'pie',
        data: {
            labels: activityThisWeek.labels,
            datasets: [{
                data: activityThisWeek.values,
                backgroundColor: ['#20c997', '#6610f2', '#fd7e14', '#6c757d', '#17a2b8']
            }]
        }
    });

    window.dashboardCharts.stackedBar = new Chart(document.getElementById("stackedBarChart"), {
        type: 'bar',
        data: {
            labels: monthlyActivity.labels,
            datasets: monthlyActivity.datasets.map(ds => ({
                label: ds.label,
                data: ds.data,
                backgroundColor: ds.color
            }))
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                x: { stacked: true },
                y: { stacked: true }
            }
        }
    });
};

window.updateDashboardCharts = (data) => {
    const { leadStages, weekly, activityThisWeek, monthlyActivity } = data;

    // Update pie
    let pie = window.dashboardCharts.leadPie;
    pie.data.labels = leadStages.labels;
    pie.data.datasets[0].data = leadStages.values;
    pie.update();

    // Update line
    let line = window.dashboardCharts.weeklyLine;
    line.data.labels = weekly.labels;
    line.data.datasets = weekly.datasets.map(ds => ({
        label: ds.label,
        data: ds.data,
        fill: false,
        borderColor: ds.color,
        tension: 0.1
    }));
    line.update();

    // Update sales pie
    let pie2 = window.dashboardCharts.salesPie;
    pie2.data.labels = activityThisWeek.labels;
    pie2.data.datasets[0].data = activityThisWeek.values;
    pie2.update();

    // Update stacked bar
    let bar = window.dashboardCharts.stackedBar;
    bar.data.labels = monthlyActivity.labels;
    bar.data.datasets = monthlyActivity.datasets.map(ds => ({
        label: ds.label,
        data: ds.data,
        backgroundColor: ds.color
    }));
    bar.update();
};

window.toggleStackedBar = (isStacked) => {
    let bar = window.dashboardCharts.stackedBar;
    if (!bar) return;

    bar.options.scales.x.stacked = isStacked;
    bar.options.scales.y.stacked = isStacked;
    bar.update();
};

window.exportDashboardCharts = () => {
    const charts = window.dashboardCharts;
    for (const key in charts) {
        const chart = charts[key];
        const link = document.createElement('a');
        link.download = `${key}.png`;
        link.href = chart.toBase64Image();
        link.click();
    }
};

window.prepareDashboardChartData = (jsonData) => {
    if (!jsonData) {
        console.error("Data is null or undefined.");
        return null;
    }

    const leadStages = {
        labels: Object.keys(jsonData.leadStages || {}),
        values: Object.values(jsonData.leadStages || {})
    };

    const weekly = {
        labels: (jsonData.leadTrend8Weeks || []).map(w => w.week),
        datasets: [
            {
                label: 'Lead',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Lead),
                color: '#007bff'
            },
            {
                label: 'Qualified',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Qualified),
                color: '#28a745'
            },
            {
                label: 'Survey',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Survey),
                color: '#ffc107'
            },
            {
                label: 'Negotiation',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Negotiation),
                color: '#17a2b8'
            },
            {
                label: 'Win',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Win),
                color: '#6f42c1'
            },
            {
                label: 'Lost',
                data: (jsonData.leadTrend8Weeks || []).map(w => w.Lost),
                color: '#dc3545'
            }
        ]
    };

    const activityThisWeek = {
        labels: Object.keys(jsonData.activityThisWeekPie || {}),
        values: Object.values(jsonData.activityThisWeekPie || {})
    };

    const firstSalesWeeks = (jsonData.activityWeeklyBySales || [])[0]?.weeks || {};
    const weeks = Object.keys(firstSalesWeeks);

    const monthlyActivity = {
        labels: weeks,
        datasets: (jsonData.activityWeeklyBySales || []).map(sales => ({
            label: sales.sales,
            data: weeks.map(w => sales.weeks[w]),
            color: randomColor()
        }))
    };

    return { leadStages, weekly, activityThisWeek, monthlyActivity };
};

// Utility warna acak (atau ganti dgn warna tetap kalau mau)
function randomColor() {
    const colors = ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6f42c1', '#dc3545', '#fd7e14', '#20c997'];
    return colors[Math.floor(Math.random() * colors.length)];
}
