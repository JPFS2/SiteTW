<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Segmentos</title>
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

        <div class="col-md-6 text-md-start text-center">
          <h1 class="display-4">Sistema completo para seu negócio</h1>
          <p class="lead ">Lorem ipsum dolor elit. Expedita reiciendis.</p>
          <a href="index.php?page=sobre" class="btn btn-primary mt-3 px-4 py-2 btn-contato">Fale conosco</a>
        </div>

        <div class="col-md-6 text-center mt-4 mt-md-0">
          <div class="w-100" style="max-width: 500px; margin: 0 auto;">
            <div class="card shadow rounded-4">
              <div class="card-body p-4">
                <h4 class="card-title mb-4 text-center">Preencha o formulário para <strong>negociações</strong></h4>

                <form>
                  <div class="mb-3 text-start">
                    <label for="nome" class="form-label fw-semibold">Nome</label>
                    <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" required>
                  </div>

                  <div class="mb-3 text-start">
                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                    <input type="tel" class="form-control" id="telefone" placeholder="(00) 00000-0000" required>
                  </div>

                  <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-semibold">E-mail</label>
                    <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                  </div>

                  <div class="mb-3 text-start">
                    <label for="setor" class="form-label fw-semibold">Segmento</label>
                    <input type="text" class="form-control" id="Segmento" placeholder="Segmento" required>
                  </div>

                  <div class="mb-4 text-start">
                    <label for="cidade" class="form-label fw-semibold">Cidade</label>
                    <input type="text" class="form-control" id="cidade" placeholder="Digite sua cidade" required>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill">Enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>

  </section>
  <section class="container py-5" id="funcionalidades">
    <div class="text-center mb-4 funcionalidades">
      <h2>
        Conheça algumas <strong>funcionalidades</strong> do nosso sistema:
      </h2>
    </div>
    <div class="nav nav-pills justify-content-center mb-5 gap-2 btn-func" id="pills-tab" role="tablist">
      <button class="nav-link rounded-pill px-4 py-2 show active" id="pdv-tab" data-bs-toggle="tab" data-bs-target="#pdv" type="button" role="tab">
        <i class="bi bi-display"></i> PDV
      </button>
      <button class="nav-link rounded-pill px-4 py-2" id="fiscal-tab" data-bs-toggle="tab" data-bs-target="#fiscal" type="button" role="tab">
        <i class="bi bi-printer"></i> Fiscal
      </button>
      <button class="nav-link rounded-pill px-4 py-2" id="financeiro-tab" data-bs-toggle="tab" data-bs-target="#financeiro" type="button" role="tab">
        <i class="bi bi-cash-coin"></i> Financeiro
      </button>
      <button class="nav-link rounded-pill px-4 py-2" id="estoque-tab" data-bs-toggle="tab" data-bs-target="#estoque" type="button" role="tab">
        <i class="bi bi-box-seam"></i> Estoque
      </button>
      <button class="nav-link rounded-pill px-4 py-2" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab">
        <i class="bi bi-bar-chart-line"></i> Dashboard
      </button>
      <button class="nav-link rounded-pill px-4 py-2 " id="integracoes-tab" data-bs-toggle="tab" data-bs-target="#gerencial" type="button" role="tab">
        <i class="bi bi-gear-fill"></i> Gerencial
      </button>
    </div>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pdv" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Emita cupons fiscais com o nosso sistema em poucos cliques</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="fiscal" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Emita documentos fiscais e arquivos</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>

        </div>
      </div>

      <div class="tab-pane fade" id="financeiro" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Tenha controle completo dos resultados da empresa</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>
        </div>
      </div>


      <div class="tab-pane fade" id="estoque" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Faça o controle do estoque e inventário</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="dashboard" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Dashboard para acompanhar as vendas e resultados da empresa</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="gerencial" role="tabpanel">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!--<img src="assets/img/integracoes.png" alt="Integrações" class="img-fluid">-->
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold">Faça vendas gerenciais para controle interno</h5>
            <ul class="mt-3 point">
              <li>Função 1;</li>
              <li>Função 2;</li>
              <li>Função 3;</li>
              <li>Função 4;</li>
              <li>Função 5;</li>
              <li>Função 6;</li>
              <li>Função 7;</li>
            </ul>
          </div>
        </div>
      </div>

  </section>
<section class="py-5 bg-white">
  <div class="container aplicativo">
    <h2 class="text-center mb-5">
      <strong>Aplicativos</strong> para decolar seu negócio
    </h2>

    <div class="row">
      
      <div class="col-lg-3 mb-4">
        <div class="nav flex-column nav-pills gap-2" id="pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active btn-func" id="pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#pills-dashboard" type="button" role="tab">
            <img src="icons/dashboard.svg" width="30" class="me-2"> Mentor
          </button>
          <button class="nav-link btn-func" id="pills-forca-tab" data-bs-toggle="pill" data-bs-target="#pills-forca" type="button" role="tab">
            <img src="icons/forca-vendas.svg" width="30" class="me-2"> Distribuidora
          </button>
          <button class="nav-link btn-func" id="pills-gourmet-tab" data-bs-toggle="pill" data-bs-target="#pills-gourmet" type="button" role="tab">
            <img src="icons/gourmet.svg" width="30" class="me-2"> Separação
          </button>
          <button class="nav-link btn-func" id="pills-balcao-tab" data-bs-toggle="pill" data-bs-target="#pills-balcao" type="button" role="tab">
            <img src="icons/balcao.svg" width="30" class="me-2"> App
          </button>
          <button class="nav-link btn-func" id="pills-coletor-tab" data-bs-toggle="pill" data-bs-target="#pills-coletor" type="button" role="tab">
            <img src="icons/coletor.svg" width="30" class="me-2"> App
          </button>
        </div>
      </div>

      
      <div class="col-lg-9">
        <div class="tab-content" id="pills-tabContent">
          
        
          <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="images/dashboard.png" class="img-fluid" >
              </div>
              <div class="col-md-6">
                <h5 class="fw-bold" >Força de Vendas</h5>
                <ul class="list-unstyled mt-3">
                  <li>✅ Vendas</li>
                  <li>✅ Otimização de tempo e recursos</li>
                  <li>✅ Baixo custo para sua empresa</li>
                </ul>
                
              </div>
            </div>
          </div>

          
          <div class="tab-pane fade" id="pills-forca" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="images/forca-vendas.png" class="img-fluid">
              </div>
              <div class="col-md-6">
                <h5 class="fw-bold" >Função</h5>
                <ul class="list-unstyled mt-3">
                  <li>✅ lista 1</li>
                  <li>✅ lista 2</li>
                  <li>✅ lista 3</li>
                </ul>
              </div>
            </div>
          </div>

         
          <div class="tab-pane fade" id="pills-gourmet" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="images/gourmet.png" class="img-fluid" >
              </div>
              <div class="col-md-6">
                <h5 class="fw-bold">Função</h5>
                <ul class="list-unstyled mt-3">
                  <li>✅ lista 1</li>
                  <li>✅ lista 2</li>
                  <li>✅ lista 3</li>
                </ul>
              </div>
            </div>
          </div>

    
          <div class="tab-pane fade" id="pills-balcao" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="images/balcao.png" class="img-fluid">
              </div>
              <div class="col-md-6">
                <h5 class="fw-bold">Função</h5>
                <ul class="list-unstyled mt-3">
                   <li>✅ lista 1</li>
                  <li>✅ lista 2</li>
                  <li>✅ lista 3</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="pills-coletor" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="images/coletor.png" class="img-fluid">
              </div>
              <div class="col-md-6">
                <h5 class="fw-bold" >Função</h5>
                <ul class="list-unstyled mt-3">
                  <li>✅ lista 1</li>
                  <li>✅ lista 2</li>
                  <li>✅ lista 3</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

</body>

</html>