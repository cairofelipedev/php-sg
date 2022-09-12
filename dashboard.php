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
    <?php
    if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2)) {
    ?>.twitter,
    .facebook,
    .instagram,
    .tiktok,
    .twitch {
      display: none;
    }

    <?php }
    if (($_SESSION['type'] == 3)) {
    ?>.twitter,
    .facebook,
    .instagram,
    .tiktok {
      display: none;
    }

    <?php } ?>
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
        <div class="col-lg-8">
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
                            $sth = $DB_con->prepare("SELECT count(*) as total from posts where user_create='$_SESSION[id]'");
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
                <div class="mr-4">
                  <select name="network" class="form-select" id="SelectOptions" required>
                    <?php
                    if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2)) {
                    ?>
                      <option value="all">TODAS</option>
                    <?php } ?>
                    <option value="twitch">TWITCH</option>
                    <option value="twitter">TWITTER</option>
                    <option value="facebook">FACEBOOK</option>
                    <option value="instagram">INSTAGRAM</option>
                    <option value="tiktok">TIKTOK</option>
                  </select>
                </div>
                <div class="card-body pb-0">
                  <?php
                  if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2)) {
                  ?>
                    <h5 class="card-title">Postagens<span>| Todas</span></h5>
                  <?php } ?>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Impressões: <?php if ($impressions == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($impressions, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Menções: <?php if ($mentions == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($mentions, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php if ($views_tt == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($views_tt, 0, ',', '.');
                                                                                  } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tt == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tt, 0, ',', '.');
                                                                              } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_fb == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_fb, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php if ($views_fb == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_fb, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php if ($likes_fb == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($likes_fb, 0, ',', '.');
                                                                                  } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php if ($views_video == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_video, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php if ($views_profile == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_profile, 0, ',', '.');
                                                                                            } ?></h4>
                                          comments <h4 class="card-title2">Compartilhamentos: <?php if ($shares == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($shares, 0, ',', '.');
                                                                                              } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tiktok == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tiktok, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php if ($number_videos == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($number_videos, 0, ',', '.');
                                                                                                } ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php if ($number_lives == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($number_lives, 0, ',', '.');
                                                                                              } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php if ($media == "") {
                                                                                            echo "";
                                                                                          } else {
                                                                                            echo number_format($media, 0, ',', '.');
                                                                                          } ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php if ($minutes == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($minutes, 0, ',', '.');
                                                                                              } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_twitch == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_twitch, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php if ($unique_participants == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($unique_participants, 0, ',', '.');
                                                                                                } ?></h4>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Impressões: <?php if ($impressions == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($impressions, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Menções: <?php if ($mentions == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($mentions, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php if ($views_tt == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($views_tt, 0, ',', '.');
                                                                                  } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tt == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tt, 0, ',', '.');
                                                                              } ?></h4>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Alcance: <?php if ($reach_fb == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_fb, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php if ($views_fb == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_fb, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php if ($likes_fb == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($likes_fb, 0, ',', '.');
                                                                                  } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Visualizações de vídeo : <?php if ($views_video == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_video, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php if ($views_profile == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_profile, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php if ($comments == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($comments, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php if ($shares == "") {
                                                                                        echo "";
                                                                                      } else {
                                                                                        echo number_format($shares, 0, ',', '.');
                                                                                      } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tiktok == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tiktok, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php if ($number_videos == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($number_videos, 0, ',', '.');
                                                                                                } ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php if ($number_lives == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($number_lives, 0, ',', '.');
                                                                                              } ?></h4>
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
                                        <h4><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Média de espectadores : <?php if ($media == "") {
                                                                                            echo "";
                                                                                          } else {
                                                                                            echo number_format($media, 0, ',', '.');
                                                                                          } ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php if ($minutes == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($minutes, 0, ',', '.');
                                                                                              } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_twitch == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_twitch, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php if ($unique_participants == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($unique_participants, 0, ',', '.');
                                                                                                } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Impressões: <?php if ($impressions == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($impressions, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Menções: <?php if ($mentions == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($mentions, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php if ($views_tt == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($views_tt, 0, ',', '.');
                                                                                  } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tt == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tt, 0, ',', '.');
                                                                              } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "facebook") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_fb == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_fb, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php if ($views_fb == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_fb, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php if ($likes_fb == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($likes_fb, 0, ',', '.');
                                                                                  } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "tiktok") { ?>
                                          <h4 class="card-title2">Visualizações de vídeo : <?php if ($views_video == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_video, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php if ($views_profile == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_profile, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php if ($comments == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($comments, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php if ($shares == "") {
                                                                                        echo "";
                                                                                      } else {
                                                                                        echo number_format($shares, 0, ',', '.');
                                                                                      } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tiktok == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tiktok, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php if ($number_videos == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($number_videos, 0, ',', '.');
                                                                                                } ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php if ($number_lives == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($number_lives, 0, ',', '.');
                                                                                              } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "twitch") { ?>
                                          <h4 class="card-title2">Média de espectadores : <?php if ($media == "") {
                                                                                            echo "";
                                                                                          } else {
                                                                                            echo number_format($media, 0, ',', '.');
                                                                                          } ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php if ($minutes == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($minutes, 0, ',', '.');
                                                                                              } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_twitch == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_twitch, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php if ($unique_participants == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($unique_participants, 0, ',', '.');
                                                                                                } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' and network='twitter' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Impressões: <?php if ($impressions == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($impressions, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Menções: <?php if ($mentions == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($mentions, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações: <?php if ($views_tt == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($views_tt, 0, ',', '.');
                                                                                  } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tt == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tt, 0, ',', '.');
                                                                              } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' and network='facebook' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Alcance: <?php if ($reach_fb == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_fb, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita à pagina: <?php if ($views_fb == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_fb, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novas Curtidas: <?php if ($likes_fb == "") {
                                                                                    echo "";
                                                                                  } else {
                                                                                    echo number_format($likes_fb, 0, ',', '.');
                                                                                  } ?></h4>
                                        <?php } ?>
                                        <?php if ($network == "instagram") { ?>
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' and network='instagram' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Alcance: <?php if ($reach_insta == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($reach_insta, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Visita ao perfil: <?php if ($views_insta == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($views_insta, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($impressions == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_insta, 0, ',', '.');
                                                                                    } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' and network='tiktok' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Visualizações de vídeo : <?php if ($views_video == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_video, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Visualizações de perfil: <?php if ($views_profile == "") {
                                                                                              echo "";
                                                                                            } else {
                                                                                              echo number_format($views_profile, 0, ',', '.');
                                                                                            } ?></h4>
                                          <h4 class="card-title2">Curtidas: <?php if ($comments == "") {
                                                                              echo "";
                                                                            } else {
                                                                              echo number_format($comments, 0, ',', '.');
                                                                            } ?></h4>
                                          <h4 class="card-title2">Compartilhamentos: <?php if ($shares == "") {
                                                                                        echo "";
                                                                                      } else {
                                                                                        echo number_format($shares, 0, ',', '.');
                                                                                      } ?></h4>
                                          <h4 class="card-title2">Seguidores: <?php if ($followers_tiktok == "") {
                                                                                echo "";
                                                                              } else {
                                                                                echo number_format($followers_tiktok, 0, ',', '.');
                                                                              } ?></h4>
                                          <h4 class="card-title2">Número de vídeos publicados: <?php if ($number_videos == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($number_videos, 0, ',', '.');
                                                                                                } ?></h4>
                                          <h4 class="card-title2">Número de lives realizadas: <?php if ($number_lives == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($number_lives, 0, ',', '.');
                                                                                              } ?></h4>
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
                            $stmt = $DB_con->prepare("SELECT * FROM posts where user_create='$_SESSION[id]' and network='twitch' ORDER BY id DESC");
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
                                      <h4 class="card-title2"><i class="bi bi-person-fill"></i> <?php echo $user_name; ?></h4>
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
                                          <h4 class="card-title2">Média de espectadores : <?php if ($media == "") {
                                                                                            echo "";
                                                                                          } else {
                                                                                            echo number_format($media, 0, ',', '.');
                                                                                          } ?></h4>
                                          <h4 class="card-title2">Minutos assistidos gerados: <?php if ($minutes == "") {
                                                                                                echo "";
                                                                                              } else {
                                                                                                echo number_format($minutes, 0, ',', '.');
                                                                                              } ?></h4>
                                          <h4 class="card-title2">Novos seguidores: <?php if ($followers_twitch == "") {
                                                                                      echo "";
                                                                                    } else {
                                                                                      echo number_format($followers_twitch, 0, ',', '.');
                                                                                    } ?></h4>
                                          <h4 class="card-title2">Participantes únicos do chat: <?php if ($unique_participants == "") {
                                                                                                  echo "";
                                                                                                } else {
                                                                                                  echo number_format($unique_participants, 0, ',', '.');
                                                                                                } ?></h4>
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
                        <?php
                        if (($_SESSION['type'] == 1) or ($_SESSION['type'] == 2)) {
                        ?>
                          <div class="all">
                            <!-- Recent Sales -->
                            <div class="col-lg-12">
                              <div class="card top-selling">
                                <div class="card-body pb-0">
                                  <h5 class="card-title">Ranking <span>| Todos</span></h5>
                                  <table class="table table-borderless datatable">
                                    <thead>
                                      <tr>
                                        <th scope="col">Usuário</th>
                                        <th scope="col"></th>
                                        <th scope="col"><i class='bi bi-twitch'></i> Média de espectadores</th>
                                        <th scope="col"><i class='bi bi-twitch'></i> Minutos assistidos</th>
                                        <th scope="col"><i class='bi bi-twitch'></i> Novos seguidores</th>
                                        <th scope="col"><i class='bi bi-twitch'></i> Participantes únicos chat</th>
                                        <th scope="col"><i class='bi bi-twitter'></i> Impressões</th>
                                        <th scope="col"><i class='bi bi-twitter'></i> Menções</th>
                                        <th scope="col"><i class='bi bi-twitter'></i> Visualizações</th>
                                        <th scope="col"><i class='bi bi-twitter'></i> Seguidores</th>
                                        <th scope="col"><i class='bi bi-facebook'></i> Alcance</th>
                                        <th scope="col"><i class='bi bi-facebook'></i> Visita pagina</th>
                                        <th scope="col"><i class='bi bi-facebook'></i> Novas Curtidas</th>
                                        <th scope="col"><i class='bi bi-instagram'></i> Alcance</th>
                                        <th scope="col"><i class='bi bi-instagram'></i> Visita perfil</th>
                                        <th scope="col"><i class='bi bi-instagram'></i> Novos seguidores</th>
                                        <?php
                                        if ($_SESSION['type'] == 1) {
                                        ?>
                                          <th scope="col">Opções</th>
                                        <?php } ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                        <?php
                                        // $i = 1;
                                        $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                        $stmt->execute();
                                        if ($stmt->rowCount() > 0) {
                                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);
                                        ?>
                                            <th scope="row">
                                              <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                            </th>
                                            <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                            <?php
                                            if ($_SESSION['type'] == 1) {
                                            ?>
                                              <td>
                                                <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                  <button type="button" class="btn btn-success">Editar</button>
                                                </a>
                                              </td>
                                            <?php } ?>
                                            <td class="text-center">
                                              <?php
                                              $stmt2 = $DB_con->prepare("SELECT SUM(media) as total_media FROM posts where user_create=$id");
                                              $stmt2->execute();
                                              if ($stmt2->rowCount() > 0) {
                                                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_media, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt3 = $DB_con->prepare("SELECT SUM(minutes) as total_minutes FROM posts where user_create=$id");
                                              $stmt3->execute();
                                              if ($stmt3->rowCount() > 0) {
                                                while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_minutes, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt4 = $DB_con->prepare("SELECT SUM(followers_twitch) as total_followers_twitch FROM posts where user_create=$id");
                                              $stmt4->execute();
                                              if ($stmt4->rowCount() > 0) {
                                                while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_followers_twitch, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt5 = $DB_con->prepare("SELECT SUM(unique_participants) as total_unique_participants FROM posts where user_create=$id");
                                              $stmt5->execute();
                                              if ($stmt5->rowCount() > 0) {
                                                while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_unique_participants, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt6 = $DB_con->prepare("SELECT SUM(impressions) as total_impressions FROM posts where user_create=$id");
                                              $stmt6->execute();
                                              if ($stmt6->rowCount() > 0) {
                                                while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_impressions, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt7 = $DB_con->prepare("SELECT SUM(mentions) as total_mentions FROM posts where user_create=$id");
                                              $stmt7->execute();
                                              if ($stmt7->rowCount() > 0) {
                                                while ($row = $stmt7->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_mentions, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt8 = $DB_con->prepare("SELECT SUM(views_tt) as total_views_tt FROM posts where user_create=$id");
                                              $stmt8->execute();
                                              if ($stmt8->rowCount() > 0) {
                                                while ($row = $stmt8->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_views_tt, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt9 = $DB_con->prepare("SELECT SUM(followers_tt) as total_followers_tt FROM posts where user_create=$id");
                                              $stmt9->execute();
                                              if ($stmt9->rowCount() > 0) {
                                                while ($row = $stmt9->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_followers_tt, 0, ',', '.');
                                                }
                                              }
                                              ?>
                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt10 = $DB_con->prepare("SELECT SUM(reach_fb) as total_reach_fb FROM posts where user_create=$id");
                                              $stmt10->execute();
                                              if ($stmt10->rowCount() > 0) {
                                                while ($row = $stmt10->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_reach_fb, 0, ',', '.');
                                                }
                                              }
                                              ?>

                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt11 = $DB_con->prepare("SELECT SUM(views_fb) as total_views_fb FROM posts where user_create=$id");
                                              $stmt11->execute();
                                              if ($stmt11->rowCount() > 0) {
                                                while ($row = $stmt11->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_views_fb, 0, ',', '.');
                                                }
                                              }
                                              ?>

                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt12 = $DB_con->prepare("SELECT SUM(followers_tt) as total_followers_tt FROM posts where user_create=$id");
                                              $stmt12->execute();
                                              if ($stmt12->rowCount() > 0) {
                                                while ($row = $stmt12->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_followers_tt, 0, ',', '.');
                                                }
                                              }
                                              ?>

                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt13 = $DB_con->prepare("SELECT SUM(likes_fb) as total_likes_fb FROM posts where user_create=$id");
                                              $stmt13->execute();
                                              if ($stmt13->rowCount() > 0) {
                                                while ($row = $stmt13->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_likes_fb, 0, ',', '.');
                                                }
                                              }
                                              ?>

                                            </td>
                                            <td class="text-center">
                                              <?php
                                              $stmt14 = $DB_con->prepare("SELECT SUM(views_insta) as total_views_insta FROM posts where user_create=$id");
                                              $stmt14->execute();
                                              if ($stmt14->rowCount() > 0) {
                                                while ($row = $stmt14->fetch(PDO::FETCH_ASSOC)) {
                                                  extract($row);
                                                  echo number_format($total_views_insta, 0, ',', '.');
                                                }
                                              }
                                              ?>
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
                        <?php } ?>
                        <div class="twitter">
                          <div class="col-lg-12">
                            <div class="card top-selling">
                              <div class="card-body pb-0">
                                <h5 class="card-title">Ranking <span>| Twitter</span></h5>
                                <table class="table table-borderless datatable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Usuário</th>
                                      <th scope="col"></th>
                                      <th scope="col"><i class='bi bi-twitter'></i> Impressões</th>
                                      <th scope="col"><i class='bi bi-twitter'></i> Menções</th>
                                      <th scope="col"><i class='bi bi-twitter'></i> Visualizações</th>
                                      <th scope="col"><i class='bi bi-twitter'></i> Seguidores</th>
                                      <?php
                                      if ($_SESSION['type'] == 1) {
                                      ?>
                                        <th scope="col">Opções</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                      <?php
                                      // $i = 1;
                                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                      $stmt->execute();
                                      if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                          extract($row);
                                      ?>
                                          <th scope="row">
                                            <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                          </th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                          <?php
                                          if ($_SESSION['type'] == 1) {
                                          ?>
                                            <td>
                                              <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                <button type="button" class="btn btn-success">Editar</button>
                                              </a>
                                            </td>
                                          <?php } ?>
                                          <td class="text-center">
                                            <?php
                                            $stmt6 = $DB_con->prepare("SELECT SUM(impressions) as total_impressions FROM posts where user_create=$id");
                                            $stmt6->execute();
                                            if ($stmt6->rowCount() > 0) {
                                              while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_impressions, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt7 = $DB_con->prepare("SELECT SUM(mentions) as total_mentions FROM posts where user_create=$id");
                                            $stmt7->execute();
                                            if ($stmt7->rowCount() > 0) {
                                              while ($row = $stmt7->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_mentions, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt8 = $DB_con->prepare("SELECT SUM(views_tt) as total_views_tt FROM posts where user_create=$id");
                                            $stmt8->execute();
                                            if ($stmt8->rowCount() > 0) {
                                              while ($row = $stmt8->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_views_tt, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt9 = $DB_con->prepare("SELECT SUM(followers_tt) as total_followers_tt FROM posts where user_create=$id");
                                            $stmt9->execute();
                                            if ($stmt9->rowCount() > 0) {
                                              while ($row = $stmt9->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_followers_tt, 0, ',', '.');
                                              }
                                            }
                                            ?>
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
                          </div>
                        </div>
                        <div class="facebook">
                          <div class="col-lg-12">
                            <div class="card top-selling">
                              <div class="card-body pb-0">
                                <h5 class="card-title">Ranking <span>| Facebook</span></h5>
                                <table class="table table-borderless datatable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Usuário</th>
                                      <th scope="col"></th>

                                      <th scope="col"><i class='bi bi-facebook'></i> Alcance</th>
                                      <th scope="col"><i class='bi bi-facebook'></i> Visita pagina</th>
                                      <th scope="col"><i class='bi bi-facebook'></i> Novas Curtidas</th>

                                      <?php
                                      if ($_SESSION['type'] == 1) {
                                      ?>
                                        <th scope="col">Opções</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                      <?php
                                      // $i = 1;
                                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                      $stmt->execute();
                                      if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                          extract($row);
                                      ?>
                                          <th scope="row">
                                            <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                          </th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                          <?php
                                          if ($_SESSION['type'] == 1) {
                                          ?>
                                            <td>
                                              <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                <button type="button" class="btn btn-success">Editar</button>
                                              </a>
                                            </td>
                                          <?php } ?>

                                          <td class="text-center">
                                            <?php
                                            $stmt10 = $DB_con->prepare("SELECT SUM(reach_fb) as total_reach_fb FROM posts where user_create=$id");
                                            $stmt10->execute();
                                            if ($stmt10->rowCount() > 0) {
                                              while ($row = $stmt10->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_reach_fb, 0, ',', '.');
                                              }
                                            }
                                            ?>

                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt11 = $DB_con->prepare("SELECT SUM(views_fb) as total_views_fb FROM posts where user_create=$id");
                                            $stmt11->execute();
                                            if ($stmt11->rowCount() > 0) {
                                              while ($row = $stmt11->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_views_fb, 0, ',', '.');
                                              }
                                            }
                                            ?>

                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt15 = $DB_con->prepare("SELECT SUM(likes_fb) as total_likes_fb FROM posts where user_create=$id");
                                            $stmt15->execute();
                                            if ($stmt15->rowCount() > 0) {
                                              while ($row = $stmt15->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_likes_fb, 0, ',', '.');
                                              }
                                            }
                                            ?>

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
                        <div class="instagram">
                          <div class="col-lg-12">
                            <div class="card top-selling">
                              <div class="card-body pb-0">
                                <h5 class="card-title">Ranking <span>| Instagram</span></h5>
                                <table class="table table-borderless datatable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Usuário</th>
                                      <th scope="col"></th>
                                      <th scope="col"><i class='bi bi-instagram'></i> Alcance</th>
                                      <th scope="col"><i class='bi bi-instagram'></i> Visita perfil</th>
                                      <th scope="col"><i class='bi bi-instagram'></i> Novos seguidores</th>
                                      <?php
                                      if ($_SESSION['type'] == 1) {
                                      ?>
                                        <th scope="col">Opções</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                      <?php
                                      // $i = 1;
                                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                      $stmt->execute();
                                      if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                          extract($row);
                                      ?>
                                          <th scope="row">
                                            <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                          </th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                          <?php
                                          if ($_SESSION['type'] == 1) {
                                          ?>
                                            <td>
                                              <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                <button type="button" class="btn btn-success">Editar</button>
                                              </a>
                                            </td>
                                          <?php } ?>
                                          <td class="text-center">
                                            <?php
                                            $stmt2 = $DB_con->prepare("SELECT SUM(reach_insta) as total_reach_insta FROM posts where user_create=$id");
                                            $stmt2->execute();
                                            if ($stmt2->rowCount() > 0) {
                                              while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_reach_insta, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(views_insta) as total_views_insta FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_views_insta, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(followers_insta) as total_followers_insta FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_followers_insta, 0, ',', '.');
                                              }
                                            }
                                            ?>
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
                          </div>
                        </div>
                        <div class="tiktok">
                          <div class="col-lg-12">
                            <div class="card top-selling">
                              <div class="card-body pb-0">
                                <h5 class="card-title">Ranking <span>| TikTok</span></h5>
                                <table class="table table-borderless datatable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Usuário</th>
                                      <th scope="col"></th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Visualizações vídeo</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Visualizações perfil</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Curtidas</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Compartilhamentos</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Seguidores</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Num. vídeos publicados</th>
                                      <th scope="col"><i class='bi bi-tiktok'></i> Num. lives realizadas</th>
                                      <?php
                                      if ($_SESSION['type'] == 1) {
                                      ?>
                                        <th scope="col">Opções</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                      <?php
                                      // $i = 1;
                                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                      $stmt->execute();
                                      if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                          extract($row);
                                      ?>
                                          <th scope="row">
                                            <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                          </th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                          <?php
                                          if ($_SESSION['type'] == 1) {
                                          ?>
                                            <td>
                                              <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                <button type="button" class="btn btn-success">Editar</button>
                                              </a>
                                            </td>
                                          <?php } ?>
                                          <td class="text-center">
                                            <?php
                                            $stmt2 = $DB_con->prepare("SELECT SUM(views_video) as total_views_video FROM posts where user_create=$id");
                                            $stmt2->execute();
                                            if ($stmt2->rowCount() > 0) {
                                              while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_views_video, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(views_profile) as total_views_profile FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_views_profile, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(comments) as total_comments FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($comments, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(shares) as total_shares FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_shares, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt4 = $DB_con->prepare("SELECT SUM(followers_tiktok) as total_followers_tiktok FROM posts where user_create=$id");
                                            $stmt4->execute();
                                            if ($stmt4->rowCount() > 0) {
                                              while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_followers_tiktok, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt5 = $DB_con->prepare("SELECT SUM(number_videos) as total_number_videos FROM posts where user_create=$id");
                                            $stmt5->execute();
                                            if ($stmt5->rowCount() > 0) {
                                              while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_number_videos, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt6 = $DB_con->prepare("SELECT SUM(number_lives) as total_number_lives FROM posts where user_create=$id");
                                            $stmt6->execute();
                                            if ($stmt6->rowCount() > 0) {
                                              while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_number_lives, 0, ',', '.');
                                              }
                                            }
                                            ?>
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
                          </div>
                        </div>
                        <div class="twitch">
                          <div class="col-lg-12">
                            <div class="card top-selling">
                              <div class="card-body pb-0">
                                <h5 class="card-title">Ranking <span>| Twitch</span></h5>
                                <table class="table table-borderless datatable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Usuário</th>
                                      <th scope="col"></th>
                                      <th scope="col"><i class='bi bi-twitch'></i> Média de espectadores</th>
                                      <th scope="col"><i class='bi bi-twitch'></i> Minutos assistidos</th>
                                      <th scope="col"><i class='bi bi-twitch'></i> Novos seguidores</th>
                                      <th scope="col"><i class='bi bi-twitch'></i> Participantes únicos chat</th>
                                      <?php
                                      if ($_SESSION['type'] == 1) {
                                      ?>
                                        <th scope="col">Opções</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <!-- <td class="fw-bold text-center">
                                      <?php
                                      // echo $i++ . "º";
                                      ?>
                                    </td> -->
                                      <?php
                                      // $i = 1;
                                      $stmt = $DB_con->prepare("SELECT * FROM users where type='2' ORDER BY points DESC");
                                      $stmt->execute();
                                      if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                          extract($row);
                                      ?>
                                          <th scope="row">
                                            <img src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile" class="rounded" width="50px" width="50px">
                                          </th>
                                          <td> <a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold" style="font-size:12px"><?php echo $name ?></a></td>
                                          <?php
                                          if ($_SESSION['type'] == 1) {
                                          ?>
                                            <td>
                                              <a href="<?php echo $URI->base('perfil/' . $id); ?>">
                                                <button type="button" class="btn btn-success">Editar</button>
                                              </a>
                                            </td>
                                          <?php } ?>
                                          <td class="text-center">
                                            <?php
                                            $stmt2 = $DB_con->prepare("SELECT SUM(media) as total_media FROM posts where user_create=$id");
                                            $stmt2->execute();
                                            if ($stmt2->rowCount() > 0) {
                                              while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_media, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt3 = $DB_con->prepare("SELECT SUM(minutes) as total_minutes FROM posts where user_create=$id");
                                            $stmt3->execute();
                                            if ($stmt3->rowCount() > 0) {
                                              while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_minutes, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt4 = $DB_con->prepare("SELECT SUM(followers_twitch) as total_followers_twitch FROM posts where user_create=$id");
                                            $stmt4->execute();
                                            if ($stmt4->rowCount() > 0) {
                                              while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_followers_twitch, 0, ',', '.');
                                              }
                                            }
                                            ?>
                                          </td>
                                          <td class="text-center">
                                            <?php
                                            $stmt5 = $DB_con->prepare("SELECT SUM(unique_participants) as total_unique_participants FROM posts where user_create=$id");
                                            $stmt5->execute();
                                            if ($stmt5->rowCount() > 0) {
                                              while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                echo number_format($total_unique_participants, 0, ',', '.');
                                              }
                                            }
                                            ?>
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
                          </div>
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

        <div class="col-lg-4">
          <div class="card top-selling">
            <div class="card-body pb-0">
              <h5 class="card-title">Ranking Geral</h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Ranking</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Pontos</th>
                    <?php
                    if ($_SESSION['type'] == 1) {
                    ?>
                      <th scope="col">Opções</th>
                    <?php } ?>
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
                        <td><a href="<?php echo $URI->base('/perfil/' . slugify($id)); ?>" class="text-primary fw-bold"><?php echo $name ?></a></td>
                        <td class="text-center">
                          <?php echo $points ?>
                        </td>
                        <?php
                        if ($_SESSION['type'] == 1) {
                        ?>
                          <td>
                            <a href="<?php echo $URI->base('perfil/' . $id); ?>">
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