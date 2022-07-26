<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link text-black border" href="<?php echo $URI->base('/dashboard') ?>">
        <i class="bi biblack text-white"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-black border" href="<?php echo $URI->base('/estatisticas') ?>">
        <i class="text-black bi bi-layout-text-window-reverse"></i>
        <span>Estatísticas</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-black border" href="<?php echo $URI->base('/ranking') ?>">
        <i class="text-black bi bi-bar-chart"></i>
        <span>Ranking</span>
      </a>
    </li>
    <?php
    if ($_SESSION['type'] == 1) {
    ?>
      <li class="nav-item">
        <a class="nav-link text-black border" href="<?php echo $URI->base('/usuarios') ?>">
          <i class="text-black bi bi-person"></i>
          <span>Usuários</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-black border" href="<?php echo $URI->base('/patrocinadores') ?>">
          <i class="text-black bi bi-star"></i>
          <span>Patrocinadores</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link text-black" href="<?php echo $URI->base('/config/logout.php') ?>">
        <i class="text-black bi bi-box-arrow-in-right"></i>
        <span>Sair</span>
      </a>
    </li>
  </ul>
</aside><!-- End Sidebar-->