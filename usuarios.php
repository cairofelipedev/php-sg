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
  header("Location:login.php");
endif;
error_reporting(~E_ALL);

if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM users WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: usuarios");
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
  <?php include "components/Header.php" ?>
  <?php include "components/SideBar.php" ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Usuários</h1>
      <div class="d-flex justify-content-between">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Usuários</li>
          </ol>
        </nav>
        <a href="add-usuario">
          <button class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Adicionar Usuário</button>
        </a>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <?php
        $stmt = $DB_con->prepare('SELECT * FROM users ORDER BY id DESC');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        ?>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center"><?php echo $name; ?></h5>
                  <?php
                  if ($type == 1) {
                    echo "<h5 class='card-title-2 text-center'>Administrador</h5>";
                  }
                  if ($type == 2) {
                    echo "<h5 class='card-title-2 text-center'>Stremear</h5>";
                  }
                  ?>
                  <img class="img-fluid rounded" src="./uploads/usuarios/<?php echo $row['img']; ?>" onerror="this.src='./assets/img/semperfil.png'">
                  <h5 class="card-title text-center">Pontos: <?php echo $points; ?></h5>
                  <div class="d-flex justify-content-between pt-2">
                    <a href="perfil.php?edit_id=<?php echo $row['id']; ?>">
                      <button type="button" class="btn btn-success">Editar</button>
                    </a>
                    <a href="usuarios.php?delete_id=<?php echo $row['id']; ?>">
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