function filterContent() {
    var input, filter, sections, section, content, i, txtValue;
    var searchInputs = document.querySelectorAll(".sidebar input[type='text'][placeholder='Search...']");
    
    searchInputs.forEach(function(input) {
        filter = input.value.toUpperCase();
        sections = document.getElementsByClassName("sections");
        
    
        for (i = 0; i < sections.length; i++) {
           section = sections[i];
           content = section.querySelector(".Body-Content"); 
    
           if (content) {
           var items = content.getElementsByTagName("div");
              for (var j = 0; j < items.length; j++) {
                 var item = items[j];
                 txtValue = item.textContent || item.innerText;
                 if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    item.style.display = "";
                 } else {
                    item.style.display = "none";
                 }
              }
           }
        }
    });
}


var searchInputs = document.querySelectorAll(".sidebar input[type='text'][placeholder='Search...']");
searchInputs.forEach(function(input) {
    input.addEventListener("input", filterContent);
});
