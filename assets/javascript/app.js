//import './bootstrap.js'; //PROBLEM!!!!
import '../styles/app.css';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

var theme = localStorage.getItem('theme');
if(theme === null){
  localStorage.setItem('theme', 'light');
}

//dark light mode
const themeBtn = document.getElementById("themeChange");

theme = localStorage.getItem('theme');
if(theme === 'dark'){
  document.body.classList.add("changeTheme");
  themeBtn.classList.add("bx-sun");
}
else {
  document.body.classList.remove("changeTheme");
  themeBtn.classList.remove("bx-sun");
}

themeBtn.onclick = () => {
  theme = localStorage.getItem('theme');
  if(theme !== 'dark'){
    localStorage.setItem('theme', 'dark');
    theme = localStorage.getItem('theme');
    document.body.classList.add("changeTheme");
    themeBtn.classList.toggle("bx-sun");
  }
  else {
    localStorage.setItem('theme', 'light');
    theme = localStorage.getItem('theme');
    document.body.classList.remove("changeTheme");
    themeBtn.classList.toggle("bx-sun");
  }  
}

//navbar responsive to window size
const navToggle = document.getElementById("navToggle");

navToggle.onclick = function toggleMenu() {
  let navbar = document.getElementById("navbar");
  navbar.className = navbar.className === "navbar" ?
                      "navbar responsive" : "navbar";
}

//sticky navbar
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");


var sticky = navbar.offsetTop;


function myFunction() {
  if (window.scrollY >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
} 


