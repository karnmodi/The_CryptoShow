function getRandomLightColor() {
    var r = Math.floor(Math.random() * 156) + 100; 
    var g = Math.floor(Math.random() * 156) + 100; 
    var b = Math.floor(Math.random() * 156) + 100;
    return `rgb(${r}, ${g}, ${b})`; 
  }
  
  function getRandomGradient() {
    var angle = Math.floor(Math.random() * 360);
    var stops = []; 
  
    for (var i = 0; i < 4; i++) {
      var color = getRandomLightColor();
      stops.push(color + ' ' + (i * 100 / 3) + '%');
    }
  

    return 'linear-gradient(' + angle + 'deg, ' + stops.join(', ') + ')';
  }
  
  var eventCards = document.querySelectorAll('.Event-Cards');
  
  eventCards.forEach(function(card) {
    var heading = card.querySelector('.Heading'); 
  
    var randomGradient = getRandomGradient();
  
    heading.style.backgroundImage = randomGradient;
    heading.style.borderRadius = '15px';
    heading.style.padding = '60px';
  });
  