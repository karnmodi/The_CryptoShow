function showSection(sectionId) {
      var sections = document.querySelectorAll('.sections');
      sections.forEach(function (section) {
        if (section.classList.contains(sectionId)) {
          section.style.display = 'block';
        } else {
          section.style.display = 'none';
        }
      });
    }