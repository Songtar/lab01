// js/register.js
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registerForm');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const full_name = document.getElementById('full_name').value.trim();
    const email     = document.getElementById('email').value.trim();
    const password  = document.getElementById('password').value;
    const country   = document.getElementById('country').value.trim();
    const city      = document.getElementById('city').value.trim();
    const contact   = document.getElementById('contact').value.trim();
    const imageEl   = document.getElementById('image');

    // Quick client validation
    if (full_name.length < 3) return alert('Name too short.');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return alert('Invalid email.');
    const passOk = password.length >= 8 && /[A-Z]/.test(password) && /\d/.test(password) &&
                   /[!@#$%^&*()_\-+={}[\]|:;"'<>,.?/~`]/.test(password);
    if (!passOk) return alert('Password must be 8+ chars, include uppercase, digit, special char.');
    if (country.length < 2) return alert('Enter country.');
    if (city.length < 2) return alert('Enter city.');
    if (!/^\+?\d{7,15}$/.test(contact)) return alert('Enter a valid phone number.');

    const fd = new FormData();
    fd.append('full_name', full_name);
    fd.append('email', email);
    fd.append('password', password);
    fd.append('country', country);
    fd.append('city', city);
    fd.append('contact', contact);
    if (imageEl && imageEl.files[0]) fd.append('image', imageEl.files[0]);

    try {
      const res = await fetch('/actions/register_customer_action.php', { method: 'POST', body: fd });
      const data = await res.json();
      if (data.status === 'success') {
        alert('Registration successful! Please log in.');
        window.location.href = '/login/login.php';
      } else {
        alert(data.message || 'Registration failed.');
      }
    } catch (err) {
      console.error(err);
      alert('Network error.');
    }
  });
});
