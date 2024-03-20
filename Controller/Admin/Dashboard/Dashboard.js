var data = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','Sep','Oct', 'Nov', 'Dec'],
    datasets: [{
        label: 'Join',
        backgroundColor: 'blue',
        data: [65, 59, 85, 70, 50, 30, 40, 95, 88, 68, 72,83]
    },

    {
        label: 'Leave', 
        backgroundColor: 'red', 
        data: [20, 25, 15, 10, 40, 5, 45, 23, 17, 11, 22, 38] 
    }]
};

// Chart configuration
var options = {};

// Get the canvas element
var ctx = document.getElementById('myChart').getContext('2d');

// Create the chart
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});