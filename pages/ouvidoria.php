<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Funcionalidades</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/css/variable.css" rel="stylesheet">
  <link href="./assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

  <section class="banner hero-section">
    <div class="container">
      <div class="row align-items-center">

        <div class="text-md-center text-center">
          <h1 class="display-4">Ouvidoria</h1>
          <p class="lead ">Entre em contato conosco através do nosso formulário</p>
        </div>

        <section>
          <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
              <div class="col-lg-7 col-md-9 col-sm-11">
                <div class="card shadow rounded-4">
                  <div class="card-body p-4">
                    <form>
                      <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Nome" required>
                      </div>

                      <div class="mb-3">
                        <label for="empresa" class="form-label">Empresa</label>
                        <input type="text" class="form-control" id="Empresa" placeholder="Empresa" required>
                      </div>

                      <div class="mb-3">
                        <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                      </div>

                      <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de manifestação</label>
                        <select class="form-select" id="tipo" required>
                          <option selected disabled>Escolha uma opção</option>
                          <option>Sugestão</option>
                          <option>Reclamação</option>
                          <option>Elogio</option>
                          <option>Denúncia</option>
                          <option>Outros</option>
                        </select>
                      </div>

                      <div class="mb-4">
                        <label for="mensagem" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="mensagem" rows="5" placeholder="Descreva sua manifestação aqui..." required></textarea>
                      </div>

                      <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="termos" required>
                        <label class="form-check-label" for="termos">
                          Concordo com o uso das informações fornecidas conforme os <a href="#">termos de privacidade</a>.
                        </label>
                      </div>

                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">Enviar</button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
  </section>


</body>

</html>