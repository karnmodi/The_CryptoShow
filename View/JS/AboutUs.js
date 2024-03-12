window.addEventListener('scroll', function() {
    // Get elements you want to animate
    var sections = document.querySelector('.section');

    // Get the position of the container relative to the viewport
    sections.forEach(section => {
        
    });
    var position = container.getBoundingClientRect().top;
    var screenHeight = window.innerHeight;

    // Check if the container is within the viewport
    if (position <= screenHeight) {
        container.classList.add('fade-in'); // Add animation class
    }
});