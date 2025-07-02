<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Way Sistemas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="./assets/css/variable.css" rel="stylesheet">
  <link href="./assets/css/style.css" rel="stylesheet">
 
</head>

<body>

  <section class="banner hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-md-start text-center">
          <h1 class="display-4">Seja nosso cliente</h1>
          <p class="lead ">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita reiciendis.</p>
          <a href="index.php?page=segmentos" class="btn btn-primary mt-3 px-4 py-2 btn-contato">Fale conosco</a>
        </div>

        <div class="col-md-6 text-center mt-4 mt-md-0 img-hero">
          <img src="./assets/img/hero-section.png" alt="Ilustração" class="img-fluid">
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

  <section class="py-5 section-segmento">
    <div class="container">
      <div class="row align-items-center">


        <div class="col-md-7 mb-4 mb-md-0 cards">
          <h2><span class="fw-bold ">Segmentos</span> que atendemos</h2>

          <div class="row g-3 mt-4">
            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">🛒</div>
                  <div class="mt-2 text-dark fw-medium">Mercado</div>
                </div>
              </a>
            </div>
            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">🏭</div>
                  <div class="mt-2 text-dark fw-medium">Indústria</div>
                </div>
              </a>
            </div>
            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">🏫</div>
                  <div class="mt-2 text-dark fw-medium">Escolas</div>
                </div>
              </a>
            </div>

            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">⚙️</div>
                  <div class="mt-2 text-dark fw-medium">Serviço</div>
                </div>
              </a>
            </div>
            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">🔨</div>
                  <div class="mt-2 text-dark fw-medium">Construção</div>
                </div>
              </a>
            </div>

            <div class="col-4 ">
              <a href="index.php?page=segmentos">
                <div class="card text-center p-3 h-100 card-butao">
                  <div class="text-warning fs-2">👜</div>
                  <div class="mt-2 text-dark fw-medium">Confecção</div>
                </div>
              </a>
            </div>
          </div>


          <div class="mt-4 ">
            <a href="index.php?page=segmentos" class="btn btn-primary text-white px-4 py-2">
              Segmentos
            </a>
          </div>
        </div>

        <div class="col-md-5 text-center">
          <img src="./assets/img/segmentos.png" alt="Segmentos" class="img-fluid">
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
              <img src="" width="30" class="me-2"> Mentor
            </button>
            <button class="nav-link btn-func" id="pills-forca-tab" data-bs-toggle="pill" data-bs-target="#pills-forca" type="button" role="tab">
              <img src="" width="30" class="me-2"> Distribuidora
            </button>
            <button class="nav-link btn-func" id="pills-gourmet-tab" data-bs-toggle="pill" data-bs-target="#pills-gourmet" type="button" role="tab">
              <img src="" width="30" class="me-2"> Separação
            </button>
            <button class="nav-link btn-func" id="pills-balcao-tab" data-bs-toggle="pill" data-bs-target="#pills-balcao" type="button" role="tab">
              <img src="" width="30" class="me-2"> App
            </button>
            <button class="nav-link btn-func" id="pills-coletor-tab" data-bs-toggle="pill" data-bs-target="#pills-coletor" type="button" role="tab">
              <img src="" width="30" class="me-2"> App
            </button>
          </div>
        </div>


        <div class="col-lg-9">
          <div class="tab-content" id="pills-tabContent">


            <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel">
              <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                  <img src="" class="img-fluid">
                </div>
                <div class="col-md-6">
                  <h5 class="fw-bold">Força de Vendas</h5>
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
                  <img src="" class="img-fluid">
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


            <div class="tab-pane fade" id="pills-gourmet" role="tabpanel">
              <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                  <img src="" class="img-fluid">
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
                  <img src="" class="img-fluid">
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
                  <img src="" class="img-fluid">
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

          </div>
        </div>
      </div>
    </div>
  </section>

 <section class="py-5 section-segmento">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-6 text-center mb-4 mb-md-0">
        <div id="globo-container"></div>
      </div>

      <div class="col-md-6">
        <h3 class="fw-bold d-inline-block py-1 mb-4">
          Por onde estamos<br>
        </h3>

        <div class="row">
          <div class="col-6 mb-3">
            <div class="fw-bold d-inline-block">+24 Estados</div>
            <div class="text-muted">Alcançados</div>
          </div>
          <div class="col-6 mb-3">
            <div class="fw-bold d-inline-block">+100 cidades</div>
            <div class="text-muted">Encontradas</div>
          </div>
          <div class="col-6 mb-3">
            <div class="fw-bold d-inline-block">+200 clientes</div>
            <div class="text-muted">Impactados</div>
          </div>
          <div class="col-6 mb-3">
            <div class="fw-bold d-inline-block">1000 PDVs</div>
            <div class="text-muted">Ativos</div>
          </div>
          <div class="col-6 mb-3">
            <div class="fw-bold d-inline-block">Não só no Brasil</div>
            <div class="text-muted">Também em outros países</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.150.1/build/three.min.js"></script>
<script type="module" src="./assets/js/globo.js"></script>


</body>

</html>