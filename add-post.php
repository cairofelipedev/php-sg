<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location:login.php");
endif;

if (isset($_POST['btnsave'])) {
  $link = $_POST['benefit'];
  $description = $_POST['description'];
  $title_s1 = $_POST['title_s1'];
  $service_1 = $_POST['service_1'];
  $title_s2  = $_POST['title_s2'];
  $service_2 = $_POST['service_2'];
  $title_s3 = $_POST['title_s3'];
  $service_3 = $_POST['service_3'];
  $plan_1 = $_POST['plan_1'];
  $plan_2 = $_POST['plan_2'];
  $slug = $_POST['slug'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];

  $imgFile2 = $_FILES['user_image2']['name'];
  $tmp_dir2 = $_FILES['user_image2']['tmp_name'];
  $imgSize2 = $_FILES['user_image2']['size'];

  $imgFile3 = $_FILES['user_image3']['name'];
  $tmp_dir3 = $_FILES['user_image3']['tmp_name'];
  $imgSize3 = $_FILES['user_image3']['size'];

  if (empty($benefit)) {
    $errMSG = "Por favor, insira um nome para o benefício";
  } else {
    $upload_dir = 'uploads/beneficios/'; // upload directory
    $imgExt =  strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
    $imgExt2 =  strtolower(pathinfo($imgFile2, PATHINFO_EXTENSION));
    $imgExt3 =  strtolower(pathinfo($imgFile3, PATHINFO_EXTENSION));

    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    // rename uploading image
    $benefit2 = preg_replace("/\s+/", "", $benefit);
    $benefit3 = substr($benefit2, 0, -1);

    $userpic  = $benefit3 . "beneficio1" . "." . $imgExt;
    $userpic2  = $benefit3 . "beneficio2" . "." . $imgExt2;
    $userpic3  = $benefit3 . "beneficio3" . "." . $imgExt2;
    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '5MB'
      if ($imgSize < 5000000) {
        move_uploaded_file($tmp_dir, $upload_dir . $userpic);
      } else {
        $errMSG = "Imagem muito grande.";
      }
    }
    if (in_array($imgExt2, $valid_extensions)) {
      // Check file size '5MB'
      if ($imgSize2 < 5000000) {
        move_uploaded_file($tmp_dir2, $upload_dir . $userpic2);
      } else {
        $errMSG = "Imagem muito grande.";
      }
    }
    if (in_array($imgExt3, $valid_extensions)) {
      // Check file size '5MB'
      if ($imgSize3 < 5000000) {
        move_uploaded_file($tmp_dir3, $upload_dir . $userpic3);
      } else {
        $errMSG = "Imagem muito grande.";
      }
    }
  }
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO benefits (benefit,description,title_s1,service_1,title_s2,service_2,title_s3,service_3,img_1,img_2,img_3,plan_1,plan_2,slug) VALUES(:ubenefit,:udescription,:utitle_s1,:uservice_1,:utitle_s2,:uservice_2,:utitle_s3,:uservice_3,:upic,:upic2,:upic3,:uplan_1,:uplan_2,:uslug)');

    $stmt->bindParam(':ubenefit', $benefit);
    $stmt->bindParam(':udescription', $description);
    $stmt->bindParam(':utitle_s1', $title_s1);
    $stmt->bindParam(':uservice_1', $service_1);
    $stmt->bindParam(':utitle_s2', $title_s2);
    $stmt->bindParam(':uservice_2', $service_2);
    $stmt->bindParam(':utitle_s3', $title_s3);
    $stmt->bindParam(':uservice_3', $service_3);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':upic2', $userpic2);
    $stmt->bindParam(':upic3', $userpic3);
    $stmt->bindParam(':uplan_1', $plan_1);
    $stmt->bindParam(':uplan_2', $plan_2);
    $stmt->bindParam(':uslug', $slug);

    if ($stmt->execute()) {
      echo ("<script>window.location = 'painel-beneficios.php';</script>");
    } else {
      $errMSG = "Erro..";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "components/Head.php"; ?>
</head>

<body>
  <?php include "components/header.php" ?>
  <?php include "components/sidebar.php" ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Adicionar Post</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="posts">Postagens</a></li>
          <li class="breadcrumb-item active">Adicionar Post</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12 justify-content-center">

          <div class="card">
            <div class="card-body">
              <?php
              if (isset($errMSG)) {
              ?>
                <div class="alert alert-danger mt-2">
                  <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                </div>
              <?php
              }
              ?>
              <!-- Vertical Form -->
              <form method="POST" enctype="multipart/form-data" class="row">
                <div class="col-md-6">
                  <h5 class="card-title">Informações</h5>
                  <div class="row">
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <textarea type="text" class="form-control" value="<?php echo $title; ?>" name="title" placeholder="Titulo do Post" style="height: 100px;"></textarea>
                        <label for="">Título do Post</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <textarea type="text" class="form-control" value="<?php echo $description; ?>" name="description" placeholder="Subtitulo do post" style="height: 100px;"></textarea>
                        <label for="">Descrição do post</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating mb-3">
                        <select name="plan_1" class="form-select" id="floatingSelect" aria-label="Plano Essencial">
                          <option value="essencial">INSTAGRAM</option>
                          <option value="">FACEBOOK</option>
                          <option value="">WHATS-APP</option>
                        </select>
                        <label for="floatingSelect">REDE SOCIAL</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating mb-3">
                        <select name="plan_1" class="form-select" id="floatingSelect" aria-label="Plano Essencial">
                          <option value="essencial">STORY</option>
                          <option value="">FEED</option>
                          <option value="">STATUS</option>
                        </select>
                        <label for="floatingSelect">TIPO</label>
                      </div>
                    </div>
                    <div class="col-md-12 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="" name="title_s1" placeholder="Titulo do Serviço 1">
                        <label for="">Link do post</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <h5 class="card-title">Imagens</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="file-loading">
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image3" accept="image/*">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="file-loading">
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image2" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center pt-2">
                  <button type="submit" name="btnsave" class="btn btn-primary">Adicionar</button>
                  <button type="reset" class="btn btn-secondary">Resetar</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
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
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.2/js/fileinput.min.js" integrity="sha512-OgkQrY08KbdmZRLKrsBkVCv105YJz+HdwKACjXqwL+r3mVZBwl20vsQqpWPdRnfoxJZePgaahK9G62SrY9hR7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>