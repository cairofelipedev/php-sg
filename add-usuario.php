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

if (isset($_POST['btnsave'])) {
  $name = $_POST['name'];
  $login = $_POST['login'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $type = $_POST['type'];
  $whats = $_POST['whats'];
  $address = $_POST['address'];
  $district = $_POST['district'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $status = $_POST['status'];
  $points = $_POST['points'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];

  if (empty($name)) {
    $errMSG = "Por favor, insira o nome";
  } else {
    $upload_dir = 'uploads/usuarios/'; // upload directory
    $imgExt =  strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));

    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    // rename uploading image
    $name2 = preg_replace("/\s+/", "", $name);
    $name3 = substr($name2, 0, -1);
    $userpic  = $name3 . "perfil" . "." . $imgExt;

    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '5MB'
      if ($imgSize < 5000000) {
        move_uploaded_file($tmp_dir, $upload_dir . $userpic);
      } else {
        $errMSG = "Imagem muito grande.";
      }
    }
  }
  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO users (name,login,email,password,type,whats,address,district,city,state,img,status,points) VALUES(:uname,:ulogin,:uemail,:upassword,:utype,:uwhats,:uaddress,:udistrict,:ucity,:ustate,:upic,:ustatus,:upoints)');
    $stmt->bindParam(':uname', $name);
    $stmt->bindParam(':ulogin', $login);
    $stmt->bindParam(':uemail', $email);
    $stmt->bindParam(':upassword', $password);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':uwhats', $whats);
    $stmt->bindParam(':uaddress', $address);
    $stmt->bindParam(':udistrict', $district);
    $stmt->bindParam(':ucity', $city);
    $stmt->bindParam(':upoints', $points);
    $stmt->bindParam(':ustate', $state);
    $stmt->bindParam(':ustatus', $status);

    if ($stmt->execute()) {
      echo ("<script>window.location = 'usuarios';</script>");
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

  <?php include "components/Header.php"; ?>
  <?php include "components/SideBar.php"; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Adicionar Usuário</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="painel-controle.php">Home</a></li>
          <li class="breadcrumb-item"><a href="painel-usuarios.php">Painel Usuários</a></li>
          <li class="breadcrumb-item active">Adicionar Usuário</li>
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
                <div class="alert alert-danger">
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
                        <input type="text" class="form-control" value="<?php echo $name; ?>" name="name" placeholder="Nome Completo">
                        <label for="">Nome do Usuário</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $email; ?>" name="email" placeholder="Email">
                        <label for="">Email</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $whats; ?>" name="whats" placeholder="Telefone do usuário">
                        <label for="">Telefone</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating mb-3">
                        <select name="type" class="form-select" id="floatingSelect" aria-label="Tipo">
                          <?php
                          if ($_SESSION['type'] == 1) {
                          ?>
                            <option value="1">Administrador</option>
                            <option value="2">Afiliado</option>
                            <option value="3">Marketing</option>
                            <option value="4">Cliente</option>
                          <?php
                          }
                          ?>
                          <option value="5">Médico</option>
                          <option value="6">Cadastro</option>
                        </select>
                        <label for="floatingSelect">Tipo</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <select name="status" class="form-select" id="floatingSelect" aria-label="Status">
                          <option value="1">Ativado</option>
                          <option value="2">Desativado</option>
                        </select>
                        <label for="floatingSelect">Status</label>
                      </div>
                    </div>
                  </div>
                  <h5 class="card-title">Login</h5>
                  <div class="row">
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $login; ?>" name="login" placeholder="Login do Usuário">
                        <label for="">Login do Usuário</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="password" class="form-control" value="<?php echo $password; ?>" name="password" placeholder="Senha do Usuário">
                        <label for="">Senha do Usuário</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <h5 class="card-title">Localização</h5>
                  <div class="row">
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $address; ?>" name="address" placeholder="Endereço">
                        <label for="">Endereço</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $district; ?>" name="district" placeholder="Email">
                        <label for="">Bairro</label>
                      </div>
                    </div>
                    <div class="col-md-6 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $city; ?>" name="city" placeholder="Cidade">
                        <label for="">Cidade</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $state; ?>" name="state" placeholder="Estado">
                        <label for="">Estado</label>
                      </div>
                    </div>
                  </div>
                  <h5 class="card-title">Imagens</h5>
                  <div class="row">
                    <div class="file-loading">
                      <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image" accept="image/*">
                    </div>
                  </div>
                </div>
                <input type="hidden" name="points" value="0">
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

  <?php include "components/footer.php"; ?>

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