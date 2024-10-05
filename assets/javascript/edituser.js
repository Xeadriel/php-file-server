import './app.js';

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