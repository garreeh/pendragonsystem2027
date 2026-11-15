<!-- AUTO LOGOUT MODAL -->
<div class="modal modal-blur fade" id="idleLogoutModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
  data-bs-keyboard="false">

  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body text-center py-5">

        <span class="avatar avatar-xl bg-danger-lt mb-4">
          <i class="ti ti-clock-exclamation fs-1 text-danger"></i>
        </span>

        <h2 class="mb-2">Session Expired</h2>

        <p class="text-secondary mb-4">
          You have been automatically logged out due to 3 minutes
          of inactivity. Please log in again to continue.
        </p>

        <a href="./../index.php" class="btn btn-primary w-100">
          <i class="ti ti-login me-2"></i>
          Login Again
        </a>

      </div>

    </div>
  </div>
</div>

<script>
  (function () {

    var idleTime = 10 * 60 * 1000; // 10 minutes
    // var idleTime = 5 * 1000; // 5 seconds for testing
    var idleTimer;
    var isLoggedOut = false;

    function logoutDueToInactivity() {

      if (isLoggedOut) {
        return;
      }

      isLoggedOut = true;

      $.ajax({
        url: './../controllers/logout_process.php',
        type: 'GET',
        success: function () {

          // Show Tabler / Bootstrap modal using jQuery
          $('#idleLogoutModal').modal({
            backdrop: 'static',
            keyboard: false
          });

          $('#idleLogoutModal').modal('show');

        },
        error: function (xhr) {
          console.log('Logout error:', xhr.status, xhr.responseText);

          // Still show the modal
          $('#idleLogoutModal').modal({
            backdrop: 'static',
            keyboard: false
          });

          $('#idleLogoutModal').modal('show');
        }
      });
    }

    function resetIdleTimer() {

      if (isLoggedOut) {
        return;
      }

      clearTimeout(idleTimer);

      idleTimer = setTimeout(
        logoutDueToInactivity,
        idleTime
      );
    }

    var activityEvents = [
      'mousemove',
      'mousedown',
      'keypress',
      'scroll',
      'touchstart',
      'click'
    ];

    for (var i = 0; i < activityEvents.length; i++) {
      document.addEventListener(
        activityEvents[i],
        resetIdleTimer,
        false
      );
    }

    resetIdleTimer();

  })();
</script>