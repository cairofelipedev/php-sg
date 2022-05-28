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
error_reporting(~E_ALL);

if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM posts WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: posts");
}

if ($_SESSION['type'] != 1) {
  echo ("
    <script type= 'text/javascript'>alert('Acesso Restrito!');</script>
    <script>window.location = 'painel-controle.php';</script>");
}
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
      <h1>Postagens</h1>
      <div class="d-flex justify-content-between">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Postagens</li>
          </ol>
        </nav>
        <a href="add-post">
          <button class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Adicionar Post</button>
        </a>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <?php
        $stmt = $DB_con->prepare('SELECT * FROM posts ORDER BY id DESC');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        ?>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title2 text-center pt-3"><?php echo $title; ?></h5>
                  <?php
                  if ($type == 1) {
                    echo "<h5 class='card-title-2 text-center'>Administrador</h5>";
                  }
                  if ($type == 2) {
                    echo "<h5 class='card-title-2 text-center'>Afiliado</h5>";
                  }
                  if ($type == 4) {
                    echo "<h5 class='card-title-2 text-center'>Cliente</h5>";
                  }
                  ?>
                  <img class="img-fluid" src="./uploads/posts/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/sem-imagem-10.jpg'">
                  <h5 class="card-title2 text-center pt-2">
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
                  </h5>
                  <h4 class="card-title2"><i class="bi bi-person"></i> <?php echo $user_create; ?></h4>
                  <h4 class="card-title2">
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
                    echo $network . " - " . $type;
                    ?>
                    <h5 class="card-title2">
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
                    <h4 class="card-title2"><?php echo $links; ?></h4>
                    <div class="d-flex justify-content-between pt-2">
                      <a href="<?php echo $URI->base('/editar-post/' . slugify($id)); ?>">
                        <button type="button" class="btn btn-success">Editar</button>
                      </a>
                      <a href="<?php echo $URI->base('/delete-post/' . slugify($id)); ?>">
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
    </section>

  </main><!-- End #main -->

  <?php include "components/footer.php"; ?>

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