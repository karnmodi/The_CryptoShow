document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('eventsChart').getContext('2d');

    // Function to generate random colors
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Generate an array of random colors for each user
    const backgroundColors = eventsPerUserData.map(() => getRandomColor());

    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: eventsPerUserData.map(user => user.Name),
            datasets: [{
                label: 'Events Created',
                data: eventsPerUserData.map(user => user.EventCount),
                backgroundColor: backgroundColors, // Use the array of colors
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'black' // Optional for dark mode: 'white'
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
