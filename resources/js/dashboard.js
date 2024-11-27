import Chart from 'chart.js/auto';

Chart.defaults.borderColor = '#c6d1e3';
Chart.defaults.color = '#000';
const blue = '#40a8f5';
const transparentBlue = 'rgba(64,168,245,0.5)';
const red = '#ff6060';
const transparentRed = 'rgba(255,96,96,0.5)';

document.addEventListener('DOMContentLoaded', () => {
    // Get the current date
    const currentDate = new Date();

    // Set the end-date to today's date (current date)
    const endDate_date = currentDate.toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('end-date').value = endDate_date;

    // Set the start-date to 15 days before the current date
    currentDate.setDate(currentDate.getDate() - 15);
    const startDate_date = currentDate.toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('start-date').value = startDate_date;
});

async function fetchDashboardData() {
    try {
        const response = await fetch('/admin/dashboard-data');
        return await response.json();
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
}

function createCharts(data) {
    console.log(data.donator_new_and_returned);
    new Chart(document.getElementById('donation_breakdown').getContext('2d'), {
        type: 'pie',
        options: {
            responsive: true,
        },
        data: {
            labels: data.donation_breakdown.map(item => item.type),
            datasets: [{
                label: 'Don',
                data: data.donation_breakdown.map(item => item.donation),
                backgroundColor: [red, blue],
            }]
        }
    });

    const donationChart = new Chart(document.getElementById('donation_last').getContext('2d'), {
        type: 'line',
        options: {
            responsive: true,
        },
        data: {
            labels: data.donation_last.map(item => item.payment_date),
            datasets: [{
                label: 'Don',
                data: data.donation_last.map(item => item.total_donation),
                backgroundColor: transparentBlue,
                borderColor: blue
            }]
        }
    });

    function updateChart() {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            return; // Do nothing if both dates are not selected
        }

        fetch(`/admin/donation-between-dates?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                // Update chart data
                const labels = data.map(item => item.payment_date);
                const donations = data.map(item => item.total_donation);

                donationChart.data.labels = labels;
                donationChart.data.datasets[0].data = donations;

                donationChart.update(); // Re-render the chart
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Erreur lors de la récupération des données.');
            });
    }
    document.getElementById('start-date').addEventListener('input', updateChart);
    document.getElementById('end-date').addEventListener('input', updateChart);

    new Chart(document.getElementById('projects_classement').getContext('2d'), {
        type: 'bar',
        options: {
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value; // You can format ticks if needed
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false // Avoid drawing grid lines on the second axis to keep the chart clean
                    },
                    ticks: {
                        callback: function(value) {
                            if (Math.floor(value) === value) {
                                return value;
                            }
                        }
                    }
                }
            }
        },
        data: {
            labels: data.projects_classement.map(item => item.title),
            datasets: [
                {
                    label: 'Nombre de don',
                    data: data.projects_donation_count.map(item => item.count),
                    type: 'line',
                    yAxisID: 'y1',
                    backgroundColor: transparentRed,
                    borderColor: red,
                },
                {
                    label: 'Don collécté',
                    data: data.projects_classement.map(item => item.donation_collected),
                    yAxisID: 'y',
                    backgroundColor: transparentBlue,
                    borderRadius: 5,
                }
            ]
        }
    });

    new Chart(document.getElementById('projects_avg_donation').getContext('2d'), {
        type: 'bar',
        options: {
            responsive: true,
        },
        data: {
            labels: data.projects_avg_donation.map(item => item.title),
            datasets: [
                {
                    label: 'Don collécté en moyenne',
                    data: data.projects_avg_donation.map(item => item.moyenne),
                    backgroundColor: transparentBlue,
                    borderRadius: 5,
                },
            ]
        }
    });

    new Chart(document.getElementById('donator_new_and_returned').getContext('2d'), {
        type: 'pie',
        options: {
            responsive: true,
        },
        data: {
            labels: data.donator_new_and_returned.map(item => item.category),
            datasets: [{
                label: 'Nombre de donnateurs',
                data: data.donator_new_and_returned.map(item => item.donation_count),
                backgroundColor: [red, blue],
            }]
        }
    });

}

async function initDashboard() {
    const dashboardData = await fetchDashboardData();
    console.log(dashboardData.users)
    createCharts(dashboardData);

    document.getElementById("total_donation").innerText = new Intl.NumberFormat('en-US', { useGrouping: true }).format(dashboardData.total_donation.amount).replace(/,/g, ' ') + " MGA";
    document.getElementById("total_donors").innerText = dashboardData.total_donors.count;
    document.getElementById("total_donation_count").innerText = dashboardData.total_donation_count.count;
    document.getElementById("users_donation").innerText = dashboardData.users_donation.name;

    const tableBody = document.querySelector('#users-table tbody');
    dashboardData.users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.total}</td>
                `;
        tableBody.appendChild(row);
    });
    new DataTable(document.getElementById('users-table'));
}

document.addEventListener('DOMContentLoaded', initDashboard);
