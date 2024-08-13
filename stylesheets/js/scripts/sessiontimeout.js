/* FOR SESSION EXPIRED */
function redirectToLogout() {
  // Show the loading modal
  $("#sessionTimeoutModal").modal("hide");
  $("#loadingIndicator").modal("show");

  // Wait for 2 seconds before executing the logout
  setTimeout(function () {
    // Redirect to logout.php
    window.location = "logout.php";
  }, 2000); // 2 seconds (2000 milliseconds)
}

var interval;
$(document)
  .on("mousemove", function () {
    clearInterval(interval);
    var countdown = 7 * 60; // 7 minutes
    $timer = $(".timer"); // After 5 minutes session expired  (mouse button click code)
    $timer.text(countdown);
    interval = setInterval(function () {
      $timer.text(--countdown);

      if (countdown === 0) {
        // alert("Session expired. User successfully logged out.");
        $("#sessionTimeoutModal").modal("show");
        // window.location = "logout.php";
      }
    }, 1000);
  })
  .mousemove();

var interval;
$(document)
  .on("keydown", function () {
    clearInterval(interval);
    var countdown = 7 * 60; // 7 minutes
    $timer = $(".timer"); // After 5 minutes session expired (keyboard button press code)
    $timer.text(countdown);
    interval = setInterval(function () {
      $timer.text(--countdown);

      if (countdown === 0) {
        // alert("Session expired User successfully logout.");
        $("#sessionTimeoutModal").modal("show");
        // window.location = "logout.php";
      }
    }, 1000);
  })
  .keydown();
