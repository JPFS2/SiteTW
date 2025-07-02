document.getElementById('loginForm').addEventListener('submit', function(event) {
    var email = document.getElementById('email').value.trim();
    var senha = document.getElementById('senha').value.trim();

    if (email === '' || senha === '') {
      alert('Por favor, preencha todos os campos.');
      event.preventDefault(); // evita o envio do form
      return;
    }

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      alert('Por favor, insira um e-mail válido.');
      event.preventDefault();
      return;
    }
    if (senha.length < 6) {
      alert('A senha deve ter no mínimo 6 caracteres.');
      event.preventDefault();
      return;
    }
  });

  