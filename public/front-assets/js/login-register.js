// 1. إظهار وإخفاء الباسورد
document.querySelectorAll('.toggle-pass').forEach((btn) => {
  btn.addEventListener('click', function () {
    const input = this.parentElement.querySelector('input');
    if (input.type === 'password') {
      input.type = 'text';
      this.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      input.type = 'password';
      this.classList.replace('fa-eye', 'fa-eye-slash');
    }
  });
});

// 2. فحص تطابق الباسورد في صفحة التسجيل
const regForm = document.getElementById('registerForm');
if (regForm) {
  regForm.addEventListener('submit', (e) => {
    const p1 = document.getElementById('regPass').value;
    const p2 = document.getElementById('regConfirmPass').value;

    if (p1 !== p2) {
      e.preventDefault();
      alert('⚠️ Password and Confirm Password do not match!');
    }
  });
}

// 3. رسالة نجاح وهمية للدخول
const loginForm = document.getElementById('loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('✅ Welcome back to ClickClinic!');
  });
}
