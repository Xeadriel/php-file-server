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




