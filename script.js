function validatePassword() {
  var newPassword = document.getElementById("newpassword").value;
  var confirmPassword = document.getElementById("confirnewpassword").value;
  var confirmPasswordError = document.getElementById("confirmPasswordError");

  if (newPassword != confirmPassword) {
    confirmPasswordError.textContent =
      "Les mots de passe ne correspondent pas.";
    return false;
  } else {
    confirmPasswordError.textContent = "";
  }

  return true;
}

var passwordInput = null;
var passwordIcon = null;

function togglePasswordVisibility(inputId) {
  passwordInput = document.getElementById(inputId);
  passwordIcon = passwordInput.nextElementSibling;

  passwordIcon.onmousedown = function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      passwordIcon.classList.remove("fa-eye-slash");
      passwordIcon.classList.add("fa-eye");
    }
  };

  passwordIcon.onmouseup = function () {
    if (passwordInput.type === "text") {
      passwordInput.type = "password";
      passwordIcon.classList.remove("fa-eye");
      passwordIcon.classList.add("fa-eye-slash");
    }
  };
}

$(document).ready(function () {
  function toggleMenu() {
    $(".navbar-burger .line").toggleClass("cross");
    $(".navbar-info").toggleClass("open");
    $("footer").toggleClass("open");
  }

  $(".navbar-burger").click(function () {
    toggleMenu();
  });

  $(".navbar-info a").click(function () {
    toggleMenu();
  });
});

window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("scrollToTopBtn").style.display = "flex";
  } else {
    document.getElementById("scrollToTopBtn").style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
