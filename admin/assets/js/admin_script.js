// This event fires when the initial HTML document has been completely loaded and parsed,
// without waiting for stylesheets and images to finish loading.
document.addEventListener("DOMContentLoaded", (event) => {
  // console.log("DOM fully loaded and parsed. Running scripts.");

  // --- Hamburger Menu Logic ---
  const menuBtn = document.getElementById("mobile-menu-btn");
  const sidebar = document.querySelector(".sidebar");
  const overlay = document.getElementById("page-overlay");

  if (menuBtn && sidebar && overlay) {
    // console.log("Hamburger elements successfully found.");

    menuBtn.addEventListener("click", function () {
      // console.log("Hamburger button clicked!");

      // Check if the sidebar is currently active
      const isActive = sidebar.classList.contains("sidebar-active");

      if (isActive) {
        // If it's active, close it
        sidebar.classList.remove("sidebar-active");
        overlay.classList.remove("is-active");
        menuBtn.classList.remove("is-active");
      } else {
        // If it's not active, open it
        sidebar.classList.add("sidebar-active");
        overlay.classList.add("is-active");
        menuBtn.classList.add("is-active");
      }
    });

    overlay.addEventListener("click", function () {
      console.log("Overlay clicked, closing menu.");
      sidebar.classList.remove("sidebar-active");
      overlay.classList.remove("is-active");
      menuBtn.classList.remove("is-active");
    });
  } else {
    console.log(
      "Hamburger elements NOT found on this page (this is normal for the login page)."
    );
  }

  // --- Show/Hide Password Logic ---
  const passwordField = document.getElementById("password-field");
  const togglePassword = document.getElementById("toggle-password");

  if (passwordField && togglePassword) {
    console.log("Password toggle elements successfully found.");

    togglePassword.addEventListener("click", function () {
      const type =
        passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      this.textContent = type === "password" ? "👁️" : "🙈";
    });
  }
});
