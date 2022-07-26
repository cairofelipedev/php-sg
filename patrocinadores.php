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
  $stmt_delete = $DB_con->prepare('DELETE FROM categorys WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  header("Location: categorias.php");
}

if (isset($_POST['btnsave'])) {
  $name = $_POST['name'];
  $type = $_POST['type'];
  $status = $_POST['status'];


  if (empty($name)) {
    $errMSG = "Por favor Insira o nome";
  }

  if (!isset($errMSG)) {
    $stmt = $DB_con->prepare('INSERT INTO categorys (name,type,status) VALUES(:uname,:utype,:ustatus)');
    $stmt->bindParam(':uname', $name);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':ustatus', $status);
    if ($stmt->execute()) {
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
      <h1>Patrocinadores</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="painel-controle.php">Home</a></li>
          <li class="breadcrumb-item active">Patrocinadores</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row justify-content-center">
        <div class="col-lg-12">

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
              <form method="POST" class="row">
                <div class="col-md-12">
                  <h5 class="card-title">Adicionar Patrocinador</h5>
                  <div class="row">
                    <div class="col-md-4 pb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" value="<?php echo $name; ?>" name="name" placeholder="Insira o nome da categoria">
                        <label for="">Nome</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                        <select name="type" class="form-select" id="floatingSelect" aria-label="Exibir preço particular">
                          <option value="1">Marca</option>
                        </select>
                        <label for="floatingSelect">Tipo</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3">
                        <select name="status" class="form-select" id="floatingSelect" aria-label="Status da categoria">
                          <option value="1">Ativado</option>
                          <option value="2">Desativado</option>
                        </select>
                        <label for="floatingSelect">Status</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center pt-2">
                  <button type="submit" name="btnsave" class="btn btn-primary">Adicionar</button>
                </div>
              </form><!-- Vertical Form -->
              <h5 class="card-title">Patrocinadores</h5>
              <?php
              $stmt = $DB_con->prepare("SELECT * FROM categorys where type='1' ORDER BY id DESC");
              $stmt->execute();
              if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
              ?>
                  <div class="d-flex justify-content-between pb-2">
                    <h6 class="">
                      <?php echo $name ?> -
                      <?php
                      if ($type == "1") {
                        echo "Marca";
                      }
                      ?> -
                      <?php
                      if ($status == "1") {
                        echo "<span class='text-success'>ATIVADA</span>";
                      }
                      if ($status == "2") {
                        echo "<span class='text-danger'>DESATIVADA</span>";
                      }
                      ?>
                    </h6>
                    <div>
                      <a href="categorias.php?delete_id=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-danger">Excluir</button>
                      </a>
                      <a href="editar-categoria.php?edit_id=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-success">Editar</button>
                      </a>
                    </div>
                  </div>
                <?php
                }
              } else {
                ?>
                <div class="alert alert-warning col-md-12">
                  <span class="fw-bolder"> Sem Patrocinador Cadastrado ...</span>
                </div>
              <?php
              }
              ?>
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