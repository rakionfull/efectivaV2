var BASE_URL = document.getElementById("base_url").value;
document.querySelectorAll(".text-input").forEach((element) => {
  element.addEventListener("blur", (event) => {
      if (event.target.value != "") {
          event.target.nextElementSibling.classList.add("filled");
      } else {
          event.target.nextElementSibling.classList.remove("filled");
      }
  });
});







