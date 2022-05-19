<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location:login.php");
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "components/Head.php"; ?>
</head>

<body>

  <?php include "components/Header.php"; ?>
  <?php include "components/SideBar.php"; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1 class="text-black">Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Posts Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card posts-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtro</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Todos</a></li>
                    <li><a class="dropdown-item" href="#">Do mês</a></li>
                    <li><a class="dropdown-item" href="#">Do ano</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Posts <span>| Todos</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="text-black bi bi-layout-text-window-reverse"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php
                        $sth = $DB_con->prepare("SELECT count(*) as total from posts");
                        $sth->execute();
                        print_r($sth->fetchColumn());
                        ?>
                      </h6>
                      <!-- <span class="text-success small pt-1 fw-bold">+12 posts</span> <span class="text-muted small pt-2 ps-1">hoje</span> -->
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card posts-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtro</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Todos</a></li>
                    <li><a class="dropdown-item" href="#">do mês</a></li>
                    <li><a class="dropdown-item" href="#">da semana</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Ranking <span>| do mês</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="text-black bi bi-bar-chart"></i>
                    </div>
                    <div class="ps-3 card-text-ranking">
                      <?php
                      $i = 1;
                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC limit 2");
                      $stmt->execute();
                      if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                      ?>
                          <p><?php echo $i++ . "º" . " " . $name; ?></p>
                      <?php
                        }
                      }
                      ?>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card posts-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtro</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Todos</a></li>
                    <li><a class="dropdown-item" href="#">Streamear / Afiliado</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Usuários <span>| Todos</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="text-black bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php
                        $sth = $DB_con->prepare("SELECT count(*) as total from users");
                        $sth->execute();
                        print_r($sth->fetchColumn());
                        ?>
                      </h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            <div class="col-12">
              <!-- Postagens -->
              <div class="card pb-4">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filtro</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Todas</a></li>
                    <li><a class="dropdown-item" href="#">Da semana</a></li>
                    <li><a class="dropdown-item" href="#">Do mês</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Postagens<span>| Todas</span></h5>

                  <div class="news">
                    <?php
                    $stmt = $DB_con->prepare("SELECT * FROM posts ORDER BY id DESC");
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                    ?>
                        <div class="post-item">
                          <div class="row">
                            <div class="col-md-6">
                              <img src="./uploads/posts/<?php echo $_SESSION['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" class="rounded">
                              <h4><a href="#"> <?php echo $title ?></a></h4>
                              <p><?php echo $description ?></p>
                            </div>
                            <div class="col-md-4">
                              <h4><a href="#"> <i class="bi bi-person"></i> <?php echo $user_create; ?></a></h4>
                              <h4>
                                <i class="bi bi-clock"></i>
                                <?php
                                $date = new DateTime($data_create);
                                $date2 = $date->format('m');
                                $date3 = $date->format('d');
                                $date4 = $date->format('Y');
                                echo $date3;
                                if ($date2 == 01) {
                                  echo " Jan. ";
                                }
                                if ($date2 == 02) {
                                  echo " Fev. ";
                                }
                                if ($date2 == "03") {
                                  echo " Mar. ";
                                }
                                if ($date2 == 04) {
                                  echo " Abr. ";
                                }
                                if ($date2 == 05) {
                                  echo " Mai. ";
                                }
                                if ($date2 == 06) {
                                  echo " Jun. ";
                                }
                                if ($date2 == 07) {
                                  echo " Jul. ";
                                }
                                if ($date2 == "08") {
                                  echo " Ago. ";
                                }
                                if ($date2 == "09") {
                                  echo " Set. ";
                                }
                                if ($date2 == "10") {
                                  echo " Out. ";
                                }
                                if ($date2 == "11") {
                                  echo " Nov. ";
                                }
                                if ($date2 == "09") {
                                  echo " Dez. ";
                                }
                                echo $date4;
                                ?>
                              </h4>
                              <h4>
                                <?php
                                if ($network == "insta") {
                                  echo "<i class='bi bi-instagram'></i> ";
                                }
                                if ($network == "face") {
                                  echo "<i class='bi bi-facebook'></i> ";
                                }
                                if ($network == "whats") {
                                  echo "<i class='bi bi-whatsapp'></i> ";
                                }
                                echo $type;
                                ?>
                              </h4>
                              <h4>
                                Status:
                                <?php
                                if ($status == "1") {
                                  echo "<span class='text-success'>APROVADO</span>";
                                }
                                if ($status == "2") {
                                  echo "<span class='text-danger'>NÃO APROVADO</span>";
                                }
                                if ($status == "3") {
                                  echo "<span class='text-warning'>EM ANALISE</span>";
                                }
                                ?>
                              </h4>
                            </div>
                            <div class="col-md-2">
                              <div class="d-grid gap-2">
                                <button class="btn btn-success" type="button">Editar</button>
                                <button class="btn btn-danger" type="button">Excluir</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <h4><a href="#"><?php echo $link; ?></a></h4>
                        <hr>
                    <?php
                      }
                    }
                    ?>
                  </div><!-- End sidebar recent posts-->

                </div>
              </div><!-- End News & Updates -->
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <div class="card top-selling overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Ranking <span>| Todos</span></h5>

              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Ranking</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Pontos</th>

                    <th scope="col">Opções</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                  $stmt->execute();
                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      extract($row);
                  ?>
                      <tr>
                        <td class="fw-bold text-center">
                          <?php
                          echo $i++ . "º";
                          ?>
                        </td>
                        <th scope="row">
                          <img src="./uploads/usuarios/<?php echo $_SESSION['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded">
                        </th>
                        <td><a href="#" class="text-primary fw-bold"><?php echo $name ?></a></td>
                        <td class="text-center">
                          <?php echo $points ?>
                        </td>
                        <td>
                          <a href="#">
                            <button type="button" class="btn btn-success">Editar</button>
                          </a>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php include "components/Footer.php"; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>