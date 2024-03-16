function filterEvents() {
    var input, filter, container, cards, card, eventDetails, eventName, eventLocation, eventId, i;
    input = document.getElementById("eventSearchString");
    filter = input.value.trim().toLowerCase();
    container = document.querySelector(".Events-section");
    cards = container.querySelectorAll(".Event-Cards");
    
    cards.forEach(function(card) {
      eventDetails = card.querySelector(".EventDetails");
      eventName = eventDetails.querySelector("h2").textContent.toLowerCase();
      eventLocation = eventDetails.querySelector("span:nth-child(4)").textContent.toLowerCase();
      eventId = eventDetails.querySelector("h2").textContent.toLowerCase();
      
      if (eventName.includes(filter) || eventLocation.includes(filter) || eventId.includes(filter)) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  }
