// Listen for scroll events
window.addEventListener('scroll', function() {
    // Get all sections
    var sections = document.querySelectorAll('.section');

    // Loop through each section
    sections.forEach(section => {
        // Get the position of the section relative to the viewport
        var position = section.getBoundingClientRect().top;
        var screenHeight = window.innerHeight;

        // Check if the section is within the viewport
        if (position <= screenHeight) {
            // Add the 'fade-in' class to the section
            section.classList.add('fade-in');
        }
    });
});
