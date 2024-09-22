//import './bootstrap.js'; //PROBLEM!!!!
//import '../styles/app.css';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


//dark light mode
var theme = localStorage.getItem('theme') || 'light';
const themeBtn = document.getElementById("themeChange");

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
    document.body.classList.add("changeTheme");
    themeBtn.classList.toggle("bx-sun");
  }
  else {
    localStorage.setItem('theme', 'light');
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


//code for cropping chosen image for profile picture
window.onload = () => {
  var hiddenImgInput = document.getElementById("profile_edit_form_image_path");
  const modalCropBtn = document.getElementById("modalCropBtn");
  const modalSaveBtn = document.getElementById("modalSaveBtn");
  const modalCancelBtn = document.getElementById("modalCancelBtn");
  const ppClick = document.getElementById("ppClick");
  const imgInput = document.getElementById("imgInput");
  var croppieWrp = document.getElementById('croppie');
  const croppieResult = document.getElementById("croppieResult");
  const cropperModal = document.getElementById('cropperModal');
  var c = null;

  ppClick.onclick = () => {
    imgInput.click();
  }

  const croppieOptions = {
    showZoomer: true,
    enableOrientation: true,
    mouseWheelZoom: "ctrl",
    viewport: {
      width: 200,
      height: 200,
      type: "circle"
    },
    boundary: {
      width: 300,
      height: 500
    }
  };
  
  modalCropBtn.onclick = () => {
    const resultwrp = document.getElementById("resultwrp");
    c.result("base64").then((base64) => {
      croppieResult.src = base64;
    })
  }

  modalSaveBtn.onclick = () => {
    ppClick.src = croppieResult.src;
    hiddenImgInput.value = ppClick.src;
    cropperModal.style.display = 'none';
  }

  modalCancelBtn.onclick = () => {
    cropperModal.style.display = 'none';
  }

  imgInput.onchange = (event) => {
    const img = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      const imgUrl = e.target.result;
      const cropperModal = document.getElementById('cropperModal');
      cropperModal.style.display = 'flex';
      if(c){
        c.destroy();
      }
      c = new Croppie(croppieWrp, croppieOptions)
      c.bind({
        url : imgUrl,
      });
      console.log("image loaded!")
    }
    reader.readAsDataURL(img);
  }
}