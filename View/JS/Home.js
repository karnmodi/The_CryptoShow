function showSection(sectionId) {
  var sectionToShow = document.getElementById(sectionId);
  if (sectionToShow) {
    document.querySelectorAll('.sections').forEach(function(section) {
      section.style.display = 'none';
    });
    sectionToShow.style.display = 'block';

    localStorage.setItem('activeSection', sectionId);

    history.pushState({section: sectionId}, '', '#' + sectionId);
  }
}

window.addEventListener('popstate', function(event) {
  if (event.state && event.state.section) {
    showSection(event.state.section);
  } else {
    showSection('dashboardContent');
  }
});

document.addEventListener('DOMContentLoaded', function () {
  var currentSection = window.location.hash.replace('#', '');
  if (currentSection) {
    showSection(currentSection);
  }
});
