
// Password Visibility Toggle
document.addEventListener('DOMContentLoaded', function () {
  
  const passwordInput = document.getElementById('floating-password');
  const togglePassword = document.getElementById('togglePassword');
  const passwordIcon = document.getElementById('passwordIcon');

  togglePassword.addEventListener('click', function () {

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      passwordIcon.classList.remove('ti-eye');
      passwordIcon.classList.add('ti-eye-off');
      togglePassword.setAttribute('aria-label', 'Hide password');
      togglePassword.setAttribute('aria-pressed', 'true');
    } else {
      passwordInput.type = 'password';
      passwordIcon.classList.remove('ti-eye-off');
      passwordIcon.classList.add('ti-eye');
      togglePassword.setAttribute('aria-label', 'Show password');
      togglePassword.setAttribute('aria-pressed', 'false');
    }

  });
});

// 