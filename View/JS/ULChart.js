document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('UserLoginChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: chartData.userNames,
            datasets: [{
                label: 'Login Counts',
                data: chartData.loginCounts,
                backgroundColor: chartData.userNames.map(() => getRandomColor()), // Random color for each user
                borderColor: chartData.userNames.map(() => 'rgba(255, 255, 255, 1)'),
                borderWidth: 1,
                barThickness: 60 
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Function to generate random colors
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
});
