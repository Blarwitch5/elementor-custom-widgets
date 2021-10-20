function openTab(event, tabTitle) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tab__content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tab__link");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabTitle).style.display = "flex";
  event.currentTarget.className += " active";
}
//add id="defaultOpen" to first tab
const tabLinksList = document.querySelector('.tab__links-wrapper');
tabLinksList.children[0].setAttribute('id', 'defaultOpen');
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
