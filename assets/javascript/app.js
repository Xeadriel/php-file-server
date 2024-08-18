import './bootstrap.js';
import '../styles/app.css';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


const themeBtn = document.getElementById("themeChange");
themeBtn.onclick = () => {
  themeBtn.classList.toggle("bx-sun");
  if (themeBtn.classList.contains("bx-sun")) {
    document.body.classList.add("changeTheme");
  } else {
    document.body.classList.remove("changeTheme");
  }
}



