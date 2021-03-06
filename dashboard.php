<?php
session_start();
require_once 'config/classes/Url.class.php';
require_once 'config/classes/Helper.php';
$URI = new URI();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');

if (isset($_SESSION['logado'])) :
else :
  header("Location:login");
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "components/Head.php"; ?>
</head>

<body>
  <style>
    .twitter,
    .facebook,
    .instagram,
    .tiktok,
    .twitch {
      display: none;
    }
  </style>
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
        <div class="col-lg-6">
          <div class="row">
            <?php
            if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2)) {
            ?>
              <!-- Posts Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card posts-card">
                  <div class="card-body">
                    <h5 class="card-title">Estatísticas <span>| <i class="text-black bi bi-layout-text-window-reverse"></i></span></h5>
                    <div class="d-flex align-items-center">
                      <div class="ps-3">
                        <h6>
                          <?php
                          if ($_SESSION['type'] == 1) {
                          ?>
                            <?php
                            $sth = $DB_con->prepare("SELECT count(*) as total from posts");
                            $sth->execute();
                            print_r($sth->fetchColumn());
                            ?>
                          <?php } ?>
                          <?php
                          if ($_SESSION['type'] == 2) {
                          ?>
                            <?php
                            $sth = $DB_con->prepare("SELECT count(*) as total from posts where user_create='$_SESSION[name]'");
                            $sth->execute();
                            print_r($sth->fetchColumn());
                            ?>
                          <?php } ?>
                        </h6>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Ranking Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card posts-card">
                  <div class="card-body">
                    <h5 class="card-title">Ranking <span>| <i class="text-black bi bi-bar-chart"></i></span></h5>

                    <div class="d-flex align-items-center">
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
              </div><!-- End Ranking Card -->
            <?php } ?>
            <?php
            if ($_SESSION['type'] == 1) {
            ?>
              <!-- Customers Card -->
              <div class="col-xxl-4 col-xl-12">

                <div class="card info-card posts-card">
                  <div class="card-body">
                    <h5 class="card-title">Usuários <span>| <i class="text-black bi bi-people"></i></span></h5>
                    <div class="d-flex align-items-center">
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
            <?php } ?>
            <div class="col-12">
              <!-- Postagens -->
              <div class="card pb-4">
                <div class="filter mr-4">
                  <select name="network" class="form-select" id="SelectOptions" required>
                    <option value="all">TODAS</option>
                    <option value="twitter">TWITTER</option>
                    <option value="facebook">FACEBOOK</option>
                    <option value="instagram">INSTAGRAM</option>
                    <option value="tiktok">TIKTOK</option>
                    <option value="twitch">TWITCH</option>
                  </select>
                </div>
                <div class="card-body pb-0">
                  <h5 class="card-title">Postagens<span>| Todas</span></h5>
                  <div class="news">
                    <?php
                    if ($_SESSION['type'] == 1) {
                    ?>
                      <div class="DivPai">
                        <div class="all">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i> ";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i> ";
                                        }
                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>
                                        <?php if ($network == "twitter") { ?>
                                          <h4 class="card-title2">Impressões: <?php echo $impressions; ?></h4>
                                          <h4 class="card-title2">Menções: <?php echo $mentions; ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php echo $views_tt; ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tt; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_fb; ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php echo $views_fb; ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php echo $likes_fb; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php echo $views_video; ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php echo $views_profile; ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php echo $comments; ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php echo $shares ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tiktok ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php echo $number_videos; ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php echo $number_lives; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php echo $media; ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php echo $minutes; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_twitch; ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php echo $unique_participants ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="twitter">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where network='twitter' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>
                                        <?php if ($network == "twitter") { ?>
                                          <h4 class="card-title2">Impressões: <?php echo $impressions; ?></h4>
                                          <h4 class="card-title2">Menções: <?php echo $mentions; ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php echo $views_tt; ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tt; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="facebook">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where network='facebook' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_fb; ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php echo $views_fb; ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php echo $likes_fb; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>


                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="instagram">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where network='instagram' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="tiktok">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where network='tiktok' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>


                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php echo $views_video; ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php echo $views_profile; ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php echo $comments; ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php echo $shares ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tiktok ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php echo $number_videos; ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php echo $number_lives; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="twitch">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where network='twitch' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      </a>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }

                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php echo $media; ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php echo $minutes; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_twitch; ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php echo $unique_participants ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['type'] == 2) {
                    ?>
                      <div class="DivPai">
                        <div class="all">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i> ";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i> ";
                                        }
                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>
                                        <?php if ($network == "twitter") { ?>
                                          <h4 class="card-title2">Impressões: <?php echo $impressions; ?></h4>
                                          <h4 class="card-title2">Menções: <?php echo $mentions; ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php echo $views_tt; ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tt; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_fb; ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php echo $views_fb; ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php echo $likes_fb; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php echo $views_video; ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php echo $views_profile; ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php echo $comments; ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php echo $shares ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tiktok ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php echo $number_videos; ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php echo $number_lives; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php echo $media; ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php echo $minutes; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_twitch; ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php echo $unique_participants ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-3">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="twitter">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' and network='twitter' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }
                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>
                                        <?php if ($network == "twitter") { ?>
                                          <h4 class="card-title2">Impressões: <?php echo $impressions; ?></h4>
                                          <h4 class="card-title2">Menções: <?php echo $mentions; ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php echo $views_tt; ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tt; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="facebook">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' and network='facebook' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_fb; ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php echo $views_fb; ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php echo $likes_fb; ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>


                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="instagram">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' and network='instagram' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="tiktok">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' and network='tiktok' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }


                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>


                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php echo $views_video; ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php echo $views_profile; ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php echo $comments; ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php echo $shares ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php echo $followers_tiktok ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php echo $number_videos; ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php echo $number_lives; ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <div class="twitch">
                          <div class="row">
                            <?php
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[name]' and network='twitch' ORDER BY id DESC");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                            ?>
                                <div class="col-lg-6">
                                  <div class="card">
                                    <div class="card-body pt-4">
                                      <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                      <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>

                                      <h5 class="card-title2 pt-2 text-center">
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
                                        if ($status == "4") {
                                          echo "<span style='color:gray'>AGUARDANDO ANALISE</span>";
                                        }
                                        ?>
                                      </h5>
                                      <h5 class="card-title2">
                                        <i class="bi bi-clock-fill"></i>
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
                                      </h5>
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                      <h4 class="card-title2">
                                        <?php
                                        if ($network == "instagram") {
                                          echo "<i class='bi bi-instagram'></i> ";
                                        }
                                        if ($network == "facebook") {
                                          echo "<i class='bi bi-facebook'></i> ";
                                        }
                                        if ($network == "twitter") {
                                          echo "<i class='bi bi-twitter'></i> ";
                                        }
                                        if ($network == "tiktok") {
                                          echo "<i class='bi bi-tiktok'></i>";
                                        }
                                        if ($network == "twitch") {
                                          echo "<i class='bi bi-twitch'></i>";
                                        }

                                        echo $type;
                                        ?>
                                        <h4 class="card-title2"><?php echo $link; ?></h4>

                                        <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>

                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php echo $media; ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php echo $minutes; ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php echo $followers_twitch; ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php echo $unique_participants ?></h4>
                                        <?php } ?>

                                        <div class="d-flex justify-content-between pt-2">
                                          <a href="<?php echo $URI->base('editar-post/' . slugify($id)); ?>">
                                            <button type="button" class="btn btn-success">Editar</button>
                                          </a>
                                          <a href="estatisticas.php?delete_id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger">Excluir</button>
                                          </a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              }
                            } else {
                              ?>
                              <div class="alert alert-warning col-md-12">
                                <span class="fw-bolder">Sem post cadastrado...</span>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                    <?php if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 3)) { ?>
                      <div class="DivPai">
                        <div class="all">
                          <!-- Recent Sales -->
                          <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                              <div class="card-body">
                                <table id="example" class="display" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th scope="col">DATA</th>
                                      <th scope="col">STREMEAR</th>
                                      <th scope="col">REDE SOCIAL</th>
                                      <th scope="col">MARCA</th>
                                      <th scope="col">DETALHES</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $stmt = $DB_con->prepare("SELECT * FROM posts WHERE status='1' ORDER BY id DESC");
                                    $stmt->execute();
                                    if ($stmt->rowCount() > 0) {
                                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <tr>
                                          <th scope="row"><a href="#">
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
                                            </a></th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                              <h4><?php echo $user_create; ?></h4>
                                            </a></td>
                                          <td><?php
                                              if ($network == "instagram") {
                                                echo "<i class='bi bi-instagram'></i> INSTAGRAM ";
                                              }
                                              if ($network == "facebook") {
                                                echo "<i class='bi bi-facebook'></i> FACEBOOK";
                                              }
                                              if ($network == "twitter") {
                                                echo "<i class='bi bi-twitter'></i> TWITTER";
                                              }
                                              if ($network == "tiktok") {
                                                echo "<i class='bi bi-tiktok'></i> TIKTOK";
                                              }
                                              if ($network == "twitch") {
                                                echo "<i class='bi bi-twitch'></i> TWITCH";
                                              }
                                              ?></td>
                                          <td><?php echo $type; ?></td>
                                          <td>
                                            <a href="#jsModal<?php echo $id; ?>" id="popup" class="jsModalTrigger">
                                              <button class="btn btn-faq" type="button" id="popup" class="jsModalTrigger">
                                                <i class="bi bi-eye-fill"></i>
                                              </button>
                                            </a>
                                          </td>
                                        </tr>
                                    <?php
                                      }
                                    }
                                    ?>
                                  </tbody>
                                </table>
                                <?php
                                $stmt = $DB_con->prepare("SELECT * FROM posts where status='1' ORDER BY id DESC");
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) {
                                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                ?>
                                    <div id="jsModal<?php echo $id; ?>" class="modal2">
                                      <div class="modal__overlay jsOverlay"></div>
                                      <div class="modal__container">
                                        <div class="row justify-content-center">
                                          <div class="col-md-6">
                                            <div class="card">
                                              <div class="card-body pt-4">
                                                <img src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'" width="100%" height="200px">
                                                <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>
                                                <h5 class="card-title2">
                                                  <i class="bi bi-clock-fill"></i>
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
                                                </h5>
                                                <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_create; ?></h4>
                                                <h4 class="card-title2">
                                                  <?php
                                                  if ($network == "instagram") {
                                                    echo "<i class='bi bi-instagram'></i> INSTAGRAM";
                                                  }
                                                  if ($network == "facebook") {
                                                    echo "<i class='bi bi-facebook'></i> FACEBOOK";
                                                  }
                                                  if ($network == "twitter") {
                                                    echo "<i class='bi bi-twitter'></i> TWITTER";
                                                  }
                                                  if ($network == "tiktok") {
                                                    echo "<i class='bi bi-tiktok'></i> TIKTOK";
                                                  }
                                                  if ($network == "twitch") {
                                                    echo "<i class='bi bi-twitch'></i>TWITCH";
                                                  }
                                                  ?>
                                                  <h4 class="card-title2"><?php echo $type; ?></h4>
                                                  <h4 class="card-title2"><?php echo $link; ?></h4>
                                                  <h4 class="card-title2 text-center pt-2">ENGAJAMENTO</h4>
                                                  <?php if ($network == "twitch") { ?>
                                                    <h4 class="card-title2">Média de espectadores : <?php echo $media; ?></h4>
                                                    <h4 class="card-title2">Minutos assistidos gerados: <?php echo $minutes; ?></h4>
                                                    <h4 class="card-title2">Novos seguidores: <?php echo $followers_twitch; ?></h4>
                                                    <h4 class="card-title2">Participantes únicos do chat: <?php echo $unique_participants ?></h4>
                                                  <?php } ?>
                                                  <?php if ($network == "twitter") { ?>
                                                    <h4 class="card-title2">Impressões: <?php echo $impressions; ?></h4>
                                                    <h4 class="card-title2">Menções: <?php echo $mentions; ?></h4>
                                                    <h4 class="card-title2">Visualizações: <?php echo $views_tt; ?></h4>
                                                    <h4 class="card-title2">Seguidores: <?php echo $followers_tt; ?></h4>
                                                  <?php } ?>
                                                  <?php if ($network == "facebook") { ?>
                                                    <h4 class="card-title2">Alcance: <?php echo $reach_fb; ?></h4>
                                                    <h4 class="card-title2">Visita à pagina: <?php echo $views_fb; ?></h4>
                                                    <h4 class="card-title2">Novas Curtidas: <?php echo $likes_fb; ?></h4>
                                                  <?php } ?>
                                                  <?php if ($network == "instagram") { ?>
                                                    <h4 class="card-title2">Alcance: <?php echo $reach_insta; ?></h4>
                                                    <h4 class="card-title2">Visita ao perfil: <?php echo $views_insta; ?></h4>
                                                    <h4 class="card-title2">Novos seguidores: <?php echo $followers_insta; ?></h4>
                                                  <?php } ?>
                                                  <?php if ($network == "tiktok") { ?>
                                                    <h4 class="card-title2">Visualizações de vídeo : <?php echo $views_video; ?></h4>
                                                    <h4 class="card-title2">Visualizações de perfil: <?php echo $views_profile; ?></h4>
                                                    <h4 class="card-title2">Curtidas: <?php echo $comments; ?></h4>
                                                    <h4 class="card-title2">Compartilhamentos: <?php echo $shares ?></h4>
                                                    <h4 class="card-title2">Seguidores: <?php echo $followers_tiktok ?></h4>
                                                    <h4 class="card-title2">Número de vídeos publicados: <?php echo $number_videos; ?></h4>
                                                    <h4 class="card-title2">Número de lives realizadas: <?php echo $number_lives; ?></h4>
                                                  <?php } ?>

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <button class="modal__close jsModalClose">&#10005;</button>
                                      </div>
                                    </div>
                                <?php
                                  }
                                } ?>
                              </div>

                            </div>
                          </div><!-- End Recent Sales -->
                        </div>
                        <div class="twitter">
                          <table id="example2" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">DATA</th>
                                <th scope="col">STREMEAR</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">IMPRESSÕES</th>
                                <th scope="col">MENÇÕES</th>
                                <th scope="col">VISUALIZAÇÕES</th>
                                <th scope="col">SEGUIDORES</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stmt = $DB_con->prepare("SELECT * FROM posts where network='twitter' ORDER BY id DESC");
                              $stmt->execute();
                              if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);
                              ?>
                                  <tr>
                                    <th scope="row"><a href="#">
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
                                      </a></th>
                                    <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><?php echo $user_create; ?></h4>
                                      </a></td>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $impressions; ?></td>
                                    <td><?php echo $mentions; ?></td>
                                    <td><?php echo $views_tt; ?></td>
                                    <td><?php echo $followers_tt; ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="facebook">
                          <table id="example3" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">DATA</th>
                                <th scope="col">STREMEAR</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">ALCANCE</th>
                                <th scope="col">VISITAS</th>
                                <th scope="col">NOVAS CURTIDAS</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stmt = $DB_con->prepare("SELECT * FROM posts where status='1' and network='facebook' ORDER BY id DESC");
                              $stmt->execute();
                              if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);
                              ?>
                                  <tr>
                                    <th scope="row"><a href="#">
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
                                      </a></th>
                                    <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><?php echo $user_create; ?></h4>
                                      </a></td>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $reach_fb; ?></td>
                                    <td><?php echo $views_fb; ?></td>
                                    <td><?php echo $likes_fb; ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="instagram">
                          <table id="example4" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">DATA</th>
                                <th scope="col">STREMEAR</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">ALCANCE</th>
                                <th scope="col">VISUALIZAÇÕES</th>
                                <th scope="col">SEGUIDORES</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stmt = $DB_con->prepare("SELECT * FROM posts where status='1' and network='instagram' ORDER BY id DESC");
                              $stmt->execute();
                              if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);
                              ?>
                                  <tr>
                                    <th scope="row"><a href="#">
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
                                      </a></th>
                                    <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><?php echo $user_create; ?></h4>
                                      </a></td>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $reach_insta; ?></td>
                                    <td><?php echo $views_insta; ?></td>
                                    <td><?php echo $followers_insta; ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="tiktok">
                          <table id="example5" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">DATA</th>
                                <th scope="col">STREMEAR</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">ALCANCE</th>
                                <th scope="col" class="text-uppercase">Visualizações de vídeo</th>
                                <th scope="col">Visualizações de perfil</th>
                                <th scope="col" class="text-uppercase">Curtidas</th>
                                <th scope="col" class="text-uppercase">Compartilhamentos</th>
                                <th scope="col" class="text-uppercase">Seguidores</th>
                                <th scope="col" class="text-uppercase">Número de vídeos publicados</th>
                                <th scope="col" class="text-uppercase">Número de lives realizadas</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stmt = $DB_con->prepare("SELECT * FROM posts where status='1' and network='tiktok' ORDER BY id DESC");
                              $stmt->execute();
                              if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);
                              ?>
                                  <tr>
                                    <th scope="row"><a href="#">
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
                                      </a></th>
                                    <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><?php echo $user_create; ?></h4>
                                      </a></td>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $views_profile; ?></td>
                                    <td><?php echo $comments; ?></td>
                                    <td><?php echo $shares; ?></td>
                                    <td><?php echo $followers_tiktok; ?></td>
                                    <td><?php echo $number_videos; ?></td>
                                    <td><?php echo $number_lives; ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="twitch">
                          <table id="example5" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">DATA</th>
                                <th scope="col">STREMEAR</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">Minutos assistidos gerados:</th>
                                <th scope="col">Novos seguidores:</th>
                                <th scope="col">Participantes únicos do chat</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stmt = $DB_con->prepare("SELECT * FROM posts where status='1' and network='twitch' ORDER BY id DESC");
                              $stmt->execute();
                              if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);
                              ?>
                                  <tr>
                                    <th scope="row"><a href="#">
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
                                      </a></th>
                                    <td> <a href="<?php echo $URI->base('/perfil/' . slugify($user_create)); ?>">
                                        <h4><?php echo $user_create; ?></h4>
                                      </a></td>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $minutes; ?></td>
                                    <td><?php echo $followers_twitch; ?></td>
                                    <td><?php echo $unique_participants; ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    <?php } ?>
                  </div><!-- End sidebar recent posts-->

                </div>
              </div><!-- End News & Updates -->
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-6">
          <div class="card top-selling">
            <div class="card-body pb-0">
              <h5 class="card-title">Ranking <span>| Todos</span></h5>
              <table class="table table-borderless datatable">
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
                          <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded">
                        </th>
                        <td><a href="<?php echo $URI->base('/perfil/' . slugify($name)); ?>" class="text-primary fw-bold"><?php echo $name ?></a></td>
                        <td class="text-center">
                          <?php echo $points ?>
                        </td>
                        <?php
                        if ($_SESSION['type'] == 1) {
                        ?>
                          <td>
                            <a href="<?php echo $URI->base('perfil/' . $name); ?>">
                              <button type="button" class="btn btn-success">Editar</button>
                            </a>
                          </td>
                        <?php } ?>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/modal.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.2/js/fileinput.min.js" integrity="sha512-OgkQrY08KbdmZRLKrsBkVCv105YJz+HdwKACjXqwL+r3mVZBwl20vsQqpWPdRnfoxJZePgaahK9G62SrY9hR7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function() {
      //Select para mostrar e esconder divs
      $('#SelectOptions').on('change', function() {
        var SelectValue = '.' + $(this).val();
        $('.DivPai .all').hide();
        $('.DivPai .twitter').hide();
        $('.DivPai .facebook').hide();
        $('.DivPai .instagram').hide();
        $('.DivPai .tiktok').hide();
        $('.DivPai .twitch').hide();
        $(SelectValue).toggle();
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example2').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example3').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example4').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example5').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example6').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example7').DataTable({
        language: {
          url: 'assets/js/dataBr.json'
        },
        responsive: true
      });
    });
  </script>

</body>

</html>