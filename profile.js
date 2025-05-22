// GANTI & HAPUS FOTO
const uploadInput = document.getElementById("upload-photo");
const profileImage = document.getElementById("profile-image");

uploadInput.addEventListener("change", function () {
  const file = uploadInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      profileImage.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

// hapus foto
function hapusFoto() {
  profileImage.src = "";
  uploadInput.value = "";
}

// UBAH NAMA & EMAIL
const editIcons = document.querySelectorAll(".input-with-icon i");

editIcons.forEach((icon) => {
  icon.addEventListener("click", function () {
    const input = this.previousElementSibling;

    if (input.hasAttribute("readonly")) {
      input.removeAttribute("readonly");
      input.focus();
      this.classList.replace("ph-pencil", "ph-check");
      this.style.color = "green";
    } else {
      input.setAttribute("readonly", true);
      this.classList.replace("ph-check", "ph-pencil");
      this.style.color = "#000";

      console.log("Data disimpan:", input.value);
      // fetch/ajax
    }
  });
});
