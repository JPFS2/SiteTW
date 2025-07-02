<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../assets/css/variable.css" rel="stylesheet">
  <link href="../assets/css/login.css" rel="stylesheet">
</head>
<body>
<div class="login-container">
  <div class="login-card">
  <div class="logo"><img src="../assets/img/logo.png"></div>  
  <h2>The Way Sistemas</h2>
    <form id="loginForm" action="#" method="POST" >
      <div class="mb-3">
        <label for="email" class="form-label">E-mail:</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="seu@email.com"
          required
        
        />
      </div>
      <div class="mb-3">
        <label for="senha" class="form-label">Senha:</label>
        <input
          type="password"
          class="form-control"
          id="senha"
          name="senha"
          placeholder="Sua senha"
          required
        />
      </div>
      <button type="submit" class="btn btn-login">Entrar</button>
    </form>
  </div>
</div>
</body>
  <script src="../assets/js/script.js"></script>

</html>