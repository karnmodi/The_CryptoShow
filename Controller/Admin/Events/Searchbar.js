function filterEvents() {
    var input, filter, container, cards, card, eventDetails, eventId, eventName, eventLocation, i;
    input = document.getElementById("CardSearch");
    filter = input.value.trim().toLowerCase();
    container = document.querySelector(".Events-section");
    cards = container.querySelectorAll(".Event-Cards");
    
    cards.forEach(function(card) {
      eventDetails = card.querySelector(".EventDetails");
      eventId = eventDetails.querySelector("h2").textContent.toLowerCase();
      eventName = eventDetails.querySelector("span:nth-child(2)").textContent.toLowerCase();
      eventLocation = eventDetails.querySelector("span:nth-child(4)").textContent.toLowerCase();
      
      if (eventId.includes(filter) || eventName.includes(filter) || eventLocation.includes(filter)) {
        card.style.display = ""; 
      } else {
        card.style.display = "none"; 
      }
    });
  }
  