window.addEventListener('scroll', function() {
    // Get elements you want to animate
    var container = document.querySelector('.container');

    // Get the position of the container relative to the viewport
    var position = container.getBoundingClientRect().top;
    var screenHeight = window.innerHeight;

    // Check if the container is within the viewport
    if (position < screenHeight) {
        container.classList.add('fade-in'); // Add animation class
    }
});