<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location:login");
endif;

require_once 'config/classes/Url.class.php';
require_once 'config/classes/Helper.php';

$URI = new URI();

$url = explode("/", $_SERVER['REQUEST_URI']);
$idPost = $url[3];

if (empty($idPost)) {
  header("Location: ../posts");
}

$stmt2 = $DB_con->prepare("SELECT id FROM posts where id='$idPost'");
$stmt2->execute();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $post = $id;
}

$id = $idPost;
$stmt_edit = $DB_con->prepare('SELECT * FROM posts WHERE id =:uid');
$stmt_edit->execute(array(':uid' => $id));
$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($edit_row);

if (($_SESSION['name'] != $user_create) and ($_SESSION['type'] != "1")) {
  echo ("<script type= 'text/javascript'>alert('Acesso Restrito!');</script><script>window.location = '../dashboard';</script>");
}

if (isset($_POST['btnsave'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $status = $_POST['status'];
  $type = $_POST['type'];
  $network = $_POST['network'];
  $link = $_POST['link'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];



  if ($imgFile) {
    $upload_dir = 'uploads/posts/'; // upload directory	
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    $title2 = preg_replace("/\s+/", "", $title);
    $title3 = substr($title2, 0, -1);
    $userpic = $title3 . "edit" . "." . $imgExt;
    if (in_array($imgExt, $valid_extensions)) {
      if ($imgSize < 5000000) {
        unlink($upload_dir . $edit_row['img']);
        move_uploaded_file($tmp_dir, $upload_dir . $userpic);
      } else {
        $errMSG = "Imagem grande demais, max 5MB";
      }
    } else {
      $errMSG = "Imagens apenas nos formatos JPG, JPEG, PNG & GIF files are allowed.";
    }
  } else {
    // if no image selected the old image remain as it is.
    $userpic = $edit_row['img']; // old image from database
  }

  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('UPDATE posts
    SET 
    title=:utitle,
    description=:udescription,
    link=:ulink,
    status=:ustatus,
    type=:utype,
    network=:unetwork,
    img=:upic
    WHERE id=:uid');
    $stmt->bindParam(':utitle', $title);
    $stmt->bindParam(':udescription', $description);
    $stmt->bindParam(':ustatus', $status);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':unetwork', $network);
    $stmt->bindParam(':ulink', $link);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':uid', $id);

    if ($stmt->execute()) {
      echo ("<script>window.location = '../posts';</script>");
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
  <?php include "components/Header.php" ?>
  <?php include "components/SideBar.php" ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Editar Post</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="posts">Postagens</a></li>
          <li class="breadcrumb-item active">Editar Post</li>
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
                        <textarea type="text" class="form-control" value="<?php echo $title; ?>" name="title" placeholder="Titulo do post" style="height: 100px;"><?php echo $title; ?></textarea>
                        <label for="">Título do Post</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <textarea type="text" class="form-control" value="<?php echo $description; ?>" name="description" placeholder="Subtitulo do post" style="height: 100px;"><?php echo $description; ?></textarea>
                        <label for="">Descrição do post</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating mb-3">
                        <select name="network" class="form-select" id="floatingSelect" aria-label="Rede Social do post">
                          <option value="<?php echo $network; ?>">
                            <?php
                            if ($network == "insta") {
                              echo "INSTAGRAM";
                            }
                            if ($network == "face") {
                              echo "FACEBOOK";
                            }
                            if ($network == "whats") {
                              echo "WHATS";
                            }
                            ?> (selecionado)
                          </option>
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
                          <option value="<?php echo $type; ?>"><?php echo $type; ?> (selecionado)
                          </option>
                          <option value="story">STORY</option>
                          <option value="feed">FEED</option>
                          <option value="status">STATUS</option>
                        </select>
                        <label for="floatingSelect">TIPO</label>
                      </div>
                    </div>
                    <div class="col-md-12 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $link; ?>" name="link" placeholder="Link do post">
                        <label for="">Link do post</label>
                      </div>
                    </div>
                    <div class="col-md-12 pb-3">
                      <div class="form-floating mb-3">
                        <select name="status" class="form-select" id="floatingSelect" aria-label="Tipo de Status">
                          <option value="<?php echo $status; ?>">
                            <?php
                            if ($status == "1") {
                              echo "APROVADO";
                            }
                            if ($status == "2") {
                              echo "NÃO APROVADO";
                            }
                            if ($status == "3") {
                              echo "EM ANALISE";
                            }
                            if ($status == "4") {
                              echo "AGUARDANDO ANALISE";
                            }
                            ?>
                            (selecionado)
                          </option>
                          <option value="1">APROVADO</option>
                          <option value="2">NÃO APROVADO</option>
                          <option value="3">EM ANALISE</option>
                          <option value="4">AGUARDANDO ANALISE</option>
                        </select>
                        <label for="floatingSelect">TIPO</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <h5 class="card-title">Imagem</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="file-loading">
                        <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image" accept="image/*">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-10">
                          <img src="<?php echo $URI->base("/uploads/posts/$img") ?>" onerror="this.src='./assets/img/semperfil.png'" class="img-fluid">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center pt-2">
                  <button type="submit" name="btnsave" class="btn btn-primary">Editar</button>
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
  <script src="<?php echo $URI->base('/assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/chart.js/chart.min.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/echarts/echarts.min.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/quill/quill.min.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/simple-datatables/simple-datatables.js') ?>"></script>
  <script src="<?php echo $URI->base('/assets/vendor/tinymce/tinymce.min.js') ?>"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo $URI->base('/assets/js/main.js') ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.2/js/fileinput.min.js" integrity="sha512-OgkQrY08KbdmZRLKrsBkVCv105YJz+HdwKACjXqwL+r3mVZBwl20vsQqpWPdRnfoxJZePgaahK9G62SrY9hR7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>