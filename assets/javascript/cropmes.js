window.onload = () => {
  var croppedImg = document.getElementById("cropppedImg");
  var savedImg = document.getElementById("savedImg");

  const modalCropBtn = document.getElementById("modalCropBtn");
  const modalSaveBtn = document.getElementById("modalSaveBtn");
  const modalCancelBtn = document.getElementById("modalCancelBtn");
  const chooseImgBtn = document.getElementById("chooseImgBtn");
  const imgInput = document.getElementById("imgInput");
  const modal = document.getElementById("cropper-modal");
  
  modalCropBtn.onclick = () => {
    
  }

  modalSaveBtn.onclick = () => {
    
  }

  chooseImgBtn.onclick = () => {

  }

  imgInput.onchange = (event) => {
    modal.style.display = 'flex';
    const img = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      const imgUrl = e.target.result;
      console.log("imgurl is : " + imgUrl);
      var cropme = new Cropme("cropmeContainer");
      cropme.bind({
        url : imgUrl
      });
    }
    reader.readAsDataURL(img);
    
  }

  imgInput.addEventListener('change', (event) => {
    modal.style.display = 'flex';
    const img = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      const imgUrl = e.target.result;
      console.log("imgurl is : " + imgUrl);
      var cropme = new Cropme("cropmeContainer");
      cropme.bind({
        url : imgUrl
      });
    }
    if(img){
      reader.readAsDataURL(img);
      console.log("image read : " + img);
    }
    
    
  })

  modalCancelBtn.onclick = () => {
    modal.style.display = 'none';
  }
}

