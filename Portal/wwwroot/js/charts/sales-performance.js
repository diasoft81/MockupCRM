window.renderSalesChart = (labels, values) => {
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue per Bulan',
                data: values,
                backgroundColor: '#40916c'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Monthly Sales Revenue' }
            }
        }
    });
};
