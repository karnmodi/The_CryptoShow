window.addEventListener('scroll', function() {
    var sections = document.querySelector('.section');

    sections.forEach(section => {
        
    });
    var position = container.getBoundingClientRect().top;
    var screenHeight = window.innerHeight;

    if (position <= screenHeight) {
        container.classList.add('fade-in');
    }
});