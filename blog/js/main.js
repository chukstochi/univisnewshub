const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

//  to open the navigation menu

const openNav = () => {
     navItems.style.display = 'flex';
     openNavBtn.style.display = 'none';
     closeNavBtn.style.display = 'inline-block';
}
// to close the navigation menu
const closeNav = () => {
     navItems.style.display = 'none';
     openNavBtn.style.display = 'inline-block';
     closeNavBtn.style.display = 'none';
}

openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);








// // Sidebar functionality for small screens
// document.addEventListener("DOMContentLoaded", () => {
//      const profileToggle = document.getElementById("profileToggle");
//      const dropdown = document.getElementById("profileDropdown");

//      if (profileToggle) {
//           profileToggle.addEventListener("click", () => {
//                dropdown.classList.toggle("show");
//           });

//           // Optional: Hide dropdown when clicking outside
//           document.addEventListener("click", (e) => {
//                if (!profileToggle.contains(e.target)) {
//                     dropdown.classList.remove("show");
//                }
//           });
//      }
// });

const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show__sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');

// to show sidebar on small screens
const showSidebar = () => {
     sidebar.style.left = '0';
     showSidebarBtn.style.display = 'none';
     hideSidebarBtn.style.display = 'inline-block';
}

const hideSidebar = () => {
     sidebar.style.left = '-100%';
     showSidebarBtn.style.display = 'inline-block';
     // hideSidebarBtn.style.display = 'none';
}


showSidebarBtn.addEventListener('click', showSidebar);
hideSidebarBtn.addEventListener('click', hideSidebar);






// scroll to left and right button

// function scrollTabs(distance) {
//      const tabBar = document.getElementById('tabBar');
//      tabBar.scrollBy({
//           left: distance,
//           behavior: 'smooth'
//      });
// }