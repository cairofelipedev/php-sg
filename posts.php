<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once 'config/DatabaseConfig.php';
ini_set('default_charset', 'utf-8');
if (isset($_SESSION['logado'])) :
else :
  header("Location:login.php");
endif;
error_reporting(~E_ALL);

if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM posts WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: posts.php");
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
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Usuários / Painel Administrativo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/icon-semfundo.png" rel="icon">
  <link href="../assets/img/icon-semfundo.png" rel="apple-touch-icon">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <?php include "components/header.php" ?>
  <?php include "components/sidebar.php" ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Postagens</h1>
      <div class="d-flex justify-content-between">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Posts</li>
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

            <div class="col-lg-2">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center"><?php echo $name; ?></h5>
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
                  <img class="img-fluid" src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'">
                  <div class="d-flex justify-content-between pt-2">
                    <a href="perfil.php?edit_id=<?php echo $row['id']; ?>">
                      <button type="button" class="btn btn-success">Editar</button>
                    </a>
                    <a href="?delete_id=<?php echo $row['id']; ?>">
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
          <div class="bg-yellow-500 px-4 py-4 rounded">
            <div>
              <p class="text-blueGray-600 font-bold">Sem Usuários Cadastrado ...</p>
            </div>
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