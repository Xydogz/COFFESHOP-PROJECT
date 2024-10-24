function checkPassword() {
    const password = document.getElementById('password').value;
    if (password === 'admin') {
      window.location.href = 'admin.html';
    } else {
      alert('Password salah!');
    }
  }