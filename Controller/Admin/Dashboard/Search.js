function filterContent() {
   var filter = this.value.toUpperCase();
   var sections = document.getElementsByClassName("sections");
   var foundMatchingSection = false; 

   Array.from(sections).forEach(section => {
       var content = section.querySelector(".Body-Content");
       var sectionHasVisibleItems = false;

       if (content) {
           var items = content.getElementsByTagName("div");
           Array.from(items).forEach(item => {
               var txtValue = item.textContent || item.innerText;
               if (txtValue.toUpperCase().indexOf(filter) > -1) {
                   item.style.display = "";
                   sectionHasVisibleItems = true;
                   foundMatchingSection = true; 
               } else {
                   item.style.display = "none";
               }
           });
           section.style.display = sectionHasVisibleItems ? "" : "none";
       }
   });

   if (!foundMatchingSection && filter.trim() !== "") {
       console.log("No results found"); 
   }
}

var searchInputs = document.querySelectorAll(".sidebar input[type='text'][placeholder='Search...']");
searchInputs.forEach(input => {
   input.addEventListener("input", filterContent);
});
