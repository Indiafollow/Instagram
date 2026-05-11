async function submitForm(formId, url, errId) {
  const form = document.getElementById(formId);
  if (!form) return;
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) window.location.href = 'home.php';
    else document.getElementById(errId).textContent = data.error || 'Error';
  });
}
submitForm('loginForm', 'api/login.php', 'loginError');
submitForm('registerForm', 'api/register.php', 'registerError');
