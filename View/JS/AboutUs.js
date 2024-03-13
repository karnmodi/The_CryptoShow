window.addEventListener('scroll', function() {
<<<<<<< HEAD
    var sections = document.querySelector('.section');

=======
    // Get elements you want to animate
    var sections = document.querySelector('.section');

    // Get the position of the container relative to the viewport
>>>>>>> 5b1387eaa36c74953950ffab59f555c930ec025e
    sections.forEach(section => {
        
    });
    var position = container.getBoundingClientRect().top;
    var screenHeight = window.innerHeight;

<<<<<<< HEAD
    if (position <= screenHeight) {
        container.classList.add('fade-in');
=======
    // Check if the container is within the viewport
    if (position <= screenHeight) {
        container.classList.add('fade-in'); // Add animation class
>>>>>>> 5b1387eaa36c74953950ffab59f555c930ec025e
    }
});