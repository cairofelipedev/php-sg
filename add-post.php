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

if (isset($_POST['btnsave'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $link = $_POST['link'];
  $status = $_POST['status'];
  $network = $_POST['network'];
  $type = $_POST['type'];
  $user_create = $_POST['user_create'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];

  $imgFile2 = $_FILES['user_image2']['name'];
  $tmp_dir2 = $_FILES['user_image2']['tmp_name'];
  $imgSize2 = $_FILES['user_image2']['size'];

  if (empty($title)) {
    $errMSG = "Por favor, insira um titulo para o post";
  } else {
    $upload_dir = 'uploads/posts/'; // upload directory
    $imgExt =  strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
    $imgExt2 =  strtolower(pathinfo($imgFile2, PATHINFO_EXTENSION));

    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    // rename uploading image
    $title2 = preg_replace("/\s+/", "", $title);
    $title3 = substr($title2, 0, -1);

    $userpic  = $title3 . "image01" . "." . $imgExt;
    $userpic2  = $title3 . "image02" . "." . $imgExt2;
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
  }
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO posts (title,description,link,status,img,img2,user_create,type,network) VALUES(:utitle,:udescription,:ulink,:ustatus,:upic,:upic2,:uuser_create,:utype,:unetwork)');

    $stmt->bindParam(':utitle', $title);
    $stmt->bindParam(':udescription', $description);
    $stmt->bindParam(':ulink', $link);
    $stmt->bindParam(':ustatus', $status);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':upic2', $userpic2);
    $stmt->bindParam(':uuser_create', $user_create);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':unetwork', $network);

    if ($stmt->execute()) {
      echo ("<script>window.location = 'posts';</script>");
    } else {
      $errMSG = "Erro, solicite suporte";
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
  <?php include "components/Header.php"; ?>
  <?php include "components/SideBar.php"; ?>
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
                        <textarea type="text" class="form-control" value="<?php echo $title; ?>" name="title" placeholder="Titulo do post" style="height: 100px;"></textarea>
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
                        <select name="network" class="form-select" id="floatingSelect" aria-label="Rede Social do post">
                          <option value="insta">INSTAGRAM</option>
                          <option value="face">FACEBOOK</option>
                          <option value="whats">WHATS-APP</option>
                        </select>
                        <label for="floatingSelect">REDE SOCIAL</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating mb-3">
                        <select name="type" class="form-select" id="floatingSelect" aria-label="Tipo de post">
                          <option value="story">STORY</option>
                          <option value="feed">FEED</option>
                          <option value="status">STATUS</option>
                        </select>
                        <label for="floatingSelect">TIPO</label>
                      </div>
                    </div>
                    <div class="col-md-12 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="" name="link" placeholder="Link do post">
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
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image" accept="image/*">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="file-loading">
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image2" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>

                <input type="hidden" value="4" name="status">
                <input type="hidden" value="<?php echo $_SESSION['name']; ?>" name="user_create">
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