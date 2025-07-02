<?php

$currentPage = $_GET['page'] ?? 'home';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand logo" href="index.php"><img src="./assets/img/logo.png"></a>
    <a class="navbar-brand" href="index.php">The Way Sistemas</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse menu" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'segmentos' ? 'active text-primary fw-bold' : '' ?>" href="index.php?page=segmentos">Segmentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'aplicativos' ? 'active text-primary fw-bold' : '' ?>" href="index.php?page=aplicativos">Aplicativos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'ouvidoria' ? 'active text-primary fw-bold' : '' ?>" href="index.php?page=ouvidoria">Ouvidoria</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'sobre' ? 'active text-primary fw-bold' : '' ?>" href="index.php?page=sobre">Sobre Nós</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary w-100 w-lg-auto mt-2 mt-lg-0 btn-login" href="./pages/login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
