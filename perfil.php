<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'dbconfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location: login.php");
endif;
error_reporting(~E_ALL);

if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
  $id = $_GET['edit_id'];
  $stmt_edit = $DB_con->prepare('SELECT * FROM users WHERE id =:uid');
  $stmt_edit->execute(array(':uid' => $id));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
} else {
  header("Location: painel-perfil.php");
}

if (isset($_POST['btnsave'])) {
  $name = $_POST['name'];
  $login = $_POST['login'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $type = $_POST['type'];
  $whats = $_POST['whats'];
  $address = $_POST['address'];
  $district = $_POST['district'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $status = $_POST['status'];
  $plan = $_POST['plan'];
  $link = $_POST['link'];

  $imgFile = $_FILES['user_image']['name'];
  $tmp_dir = $_FILES['user_image']['tmp_name'];
  $imgSize = $_FILES['user_image']['size'];


  if (empty($name)) {
    $errMSG = "Por favor, insira o nome do usuário";
  }

  if ($imgFile) {
    $upload_dir = 'uploads/usuarios/'; // upload directory	
    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    $name2 = preg_replace("/\s+/", "", $name);
    $name3 = substr($name2, 0, -1);
    $userpic = $name3 . "edit" . "." . $imgExt;
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
    $stmt = $DB_con->prepare('UPDATE users
    SET 
    name=:uname,
    login=:ulogin,
    email=:uemail,
    pass=:upass,
    type=:utype,
    img=:upic,
    whats=:uwhats,
    address=:uaddress,
    district=:udistrict,
    city=:ucity,
    state=:ustate,
    status=:ustatus,
    plan=:uplan,
    link=:ulink
    WHERE id=:uid');
    $stmt->bindParam(':uname', $name);
    $stmt->bindParam(':ulogin', $login);
    $stmt->bindParam(':uemail', $email);
    $stmt->bindParam(':upass', $pass);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':uwhats', $whats);
    $stmt->bindParam(':uaddress', $address);
    $stmt->bindParam(':udistrict', $district);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':ucity', $city);
    $stmt->bindParam(':ustate', $state);
    $stmt->bindParam(':ustatus', $status);
    $stmt->bindParam(':uplan', $plan);
    $stmt->bindParam(':ulink', $link);
    $stmt->bindParam(':uid', $id);

    if ($stmt->execute()) {
      echo ("<script>window.location = 'painel-usuarios.php';</script>");
    } else {
      $errMSG = "Erro..";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CENTROCARD - Painel de Controle</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/icon-semfundo.png" rel="icon">
  <link href="../assets/img/icon-semfundo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <?php include "components/header.php" ?>
  <?php include "components/sidebar.php" ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="painel-controle.php">Home</a></li>
          <li class="breadcrumb-item">Painel Usuários</li>
          <li class="breadcrumb-item active">Perfil do Usuário</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="./uploads/usuarios/<?php echo $img; ?>" onerror="this.src='./assets/img/semperfil.png'" class="rounded">
              <h2><?php echo $name; ?></h2>
              <h3>
                <?php
                if ($type == 1) {
                  echo "Administrador";
                }
                if ($type == 2) {
                  echo "Afiliado";
                }
                if ($type == 4) {
                  echo "Cliente";
                } ?>
              </h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Geral</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Detalhes do Perfil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nome Completo</div>
                    <div class="col-lg-9 col-md-8"><?php echo $name; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tipo do Usuário</div>
                    <div class="col-lg-9 col-md-8">
                      <?php
                      if ($type == 1) {
                        echo "Administrador";
                      }
                      if ($type == 2) {
                        echo "Afiliado";
                      }
                      if ($type == 4) {
                        echo "Cliente";
                      } ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Endereço</div>
                    <div class="col-lg-9 col-md-8">
                      <?php
                      if ($address == null) {
                        echo "não informado";
                      } else {
                        echo $address;
                      } ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Telefone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $whats; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $email; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Imagem do perfil</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="./uploads/usuarios/<?php echo $img; ?>" onerror="this.src='./assets/img/semperfil.png'" alt="Profile">
                        <div class="pt-2">
                          <input id="curriculo" class="file" data-theme="fas" type="file" name="user_image" accept="image/*">
                          <!-- <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome Completo</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="name" value="<?php echo $name; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Login</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="login" type="text" class="form-control" id="login" value="<?php echo $login; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Senha</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="pass" type="password" class="form-control" id="pass" value="<?php echo $pass; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Endereço</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="address" value="<?php echo $address; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Cidade</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="city" type="text" class="form-control" id="city" value="<?php echo $city; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Estado</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="state" type="text" class="form-control" id="state" value="<?php echo $state; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="text" class="form-control" id="email" value="<?php echo $email; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Telefone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="whats" type="text" class="form-control" id="whats" value="<?php echo $whats; ?>">
                      </div>
                    </div>
                    <?php
                    if ($_SESSION['type'] == 1) {
                    ?>
                      <div class="row mb-3">
                        <label for="Tipo de Usuário" class="col-md-4 col-lg-3 col-form-label">Tipo</label>
                        <div class="col-md-8 col-lg-9">
                          <select name="type" class="form-select" aria-label="Tipo">
                            <option value="<?php echo $type; ?>">
                              <?php
                              if ($type == 1) {
                                echo "Administrador";
                              }
                              if ($type == 2) {
                                echo "Afiliado";
                              }
                              if ($type == 4) {
                                echo "Cliente";
                              } ?> (selecionado)
                            </option>
                            <option value="1">Administrador</option>
                            <option value="2">Afiliado</option>
                            <option value="3">Marketing</option>
                            <option value="4">Cliente</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="Tipo de Usuário" class="col-md-4 col-lg-3 col-form-label">Status</label>
                        <div class="col-md-8 col-lg-9">
                          <select name="status" class="form-select" aria-label="Status">
                            <option value="<?php echo $status; ?>">
                              <?php
                              if ($type == 1) {
                                echo "Ativado";
                              }
                              if ($type == 2) {
                                echo "Desativado";
                              } ?> (selecionado)
                            </option>
                            <option value="1">Ativodo</option>
                            <option value="2">Desativado</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Link</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="link" type="text" class="form-control" id="link" value="<?php echo $link; ?>">
                      </div>
                    </div>
                    <?php } ?>
                    <div class="text-center">
                      <button type="submit" name="btnsave" class="btn btn-primary">Salvar</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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