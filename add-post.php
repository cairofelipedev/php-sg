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
  /* twitter */
  $impressions = $_POST['impressions'];
  $mentions = $_POST['mentions'];
  $followers_tt = $_POST['followers_tt'];
  $views_tt = $_POST['views_tt'];
  /* facebook */
  $reach_fb = $_POST['reach_fb'];
  $views_fb = $_POST['views_fb'];
  $likes_fb = $_POST['likes_fb'];
  /* instagram */
  $views_insta = $_POST['views_insta'];
  $followers_insta = $_POST['followers_insta'];
  $reach_insta = $_POST['reach_insta'];
  /* tiktok */
  $number_videos = $_POST['number_videos'];
  $number_lives = $_POST['number_lives'];
  $followers_tiktok = $_POST['followers_tiktok'];
  $likes_tiktok = $_POST['likes_tiktok'];
  $views_video = $_POST['views_video'];
  $views_profile = $_POST['views_profile'];
  $shares = $_POST['shares'];
  $comments = $_POST['comments'];
  /* twitch */
  $media = $_POST['media'];
  $minutes = $_POST['minutes'];
  $unique_participants = $_POST['unique_participants'];
  $followers_twitch = $_POST['followers_twitch'];

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
    $stmt = $DB_con->prepare('INSERT INTO posts (title,description,link,status,img,img2,user_create,type,network,comments,likes_fb,likes_tiktok,views_insta,views_tt,views_fb,impressions,mentions,followers_tt,followers_insta,followers_tiktok,followers_twitch,reach_insta,reach_fb,views_video,views_profile,shares,number_videos,number_lives,media,minutes,unique_participants) VALUES(:utitle,:udescription,:ulink,:ustatus,:upic,:upic2,:uuser_create,:utype,:unetwork,:ucomments,:ulikes_fb,:ulikes_tiktok,:uviews_insta,:uviews_tt,:uviews_fb,:uimpressions,:umentions,:ufollowers_tt,:ufollowers_insta,:ufollowers_tiktok,:ufollowers_twitch,:ureach_insta,   :ureach_fb,:uviews_video,:uviews_profile,:ushares,:unumber_videos, :unumber_lives,:umedia,:uminutes,:uunique_participants)');

    $stmt->bindParam(':utitle', $title);
    $stmt->bindParam(':udescription', $description);
    $stmt->bindParam(':ulink', $link);
    $stmt->bindParam(':ustatus', $status);
    $stmt->bindParam(':upic', $userpic);
    $stmt->bindParam(':upic2', $userpic2);
    $stmt->bindParam(':uuser_create', $user_create);
    $stmt->bindParam(':utype', $type);
    $stmt->bindParam(':unetwork', $network);
    /* twitter */
    $stmt->bindParam(':uimpressions', $impressions);
    $stmt->bindParam(':umentions', $mentions);
    $stmt->bindParam(':uviews_tt', $views_tt);
    $stmt->bindParam(':ufollowers_tt', $followers_tt);
    /* facebook */
    $stmt->bindParam(':uviews_fb', $views_fb);
    $stmt->bindParam(':ureach_fb', $reach_fb);
    $stmt->bindParam(':ulikes_fb', $likes_fb);
    /* instagram */
    $stmt->bindParam(':uviews_insta', $views_insta);
    $stmt->bindParam(':ufollowers_insta', $followers_insta);
    $stmt->bindParam(':ureach_insta', $reach_insta);
    /* tiktok */
    $stmt->bindParam(':unumber_videos', $number_videos);
    $stmt->bindParam(':unumber_lives', $number_lives);
    $stmt->bindParam(':ufollowers_tiktok', $followers_tiktok);
    $stmt->bindParam(':ulikes_tiktok', $likes_tiktok);
    $stmt->bindParam(':ucomments', $comments);
    $stmt->bindParam(':ushares', $shares);
    $stmt->bindParam(':uviews_video', $views_video);
    $stmt->bindParam(':uviews_profile', $views_profile);
    /* twitch */
    $stmt->bindParam(':ufollowers_twitch', $followers_twitch);
    $stmt->bindParam(':umedia', $media);
    $stmt->bindParam(':uminutes', $minutes);
    $stmt->bindParam(':uunique_participants', $unique_participants);

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
  <style>
    .twitter,
    .facebook,
    .instagram,
    .tiktok,
    .twitch {
      display: none;
    }
  </style>
  <?php include "components/Header.php"; ?>
  <?php include "components/SideBar.php"; ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Adicionar Post</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
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
              <form method="POST" enctype="multipart/form-data">
                <div class="row">
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
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select name="network" class="form-select" id="SelectOptions" required>
                            <option value="">SELECIONE A REDE SOCIAL</option>
                            <option value="twitter">TWITTER</option>
                            <option value="facebook">FACEBOOK</option>
                            <option value="instagram">INSTAGRAM</option>
                            <option value="tiktok">TIKTOK</option>
                            <option value="twitch">TWITCH</option>
                          </select>
                          <label for="floatingSelect">REDE SOCIAL</label>
                        </div>
                      </div>
                      <div class="col-md-6 pb-2">
                        <div class="form-floating mb-2">
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
                    <h5 class="card-title">Engajamento</h5>
                    <div class="DivPai">
                      <div class="twitter">
                        <div class="row">
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="impressions" placeholder="Visualização do post">
                              <label for="">Impressões</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="views_tt" placeholder="Visitas do perfil">
                              <label for="">Visitas ao perfil</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="mentions" placeholder="Menções do post">
                              <label for="">Menções</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="followers_tt" placeholder="Seguidores">
                              <label for="">Seguidores</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="facebook">
                        <div class="row">
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="reach_fb" placeholder="Visualização do post">
                              <label for="">Alcance na página</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="views_fb" placeholder="Visitas do perfil">
                              <label for="">Visitas ao perfil</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="likes_fb" placeholder="Novas curtidas">
                              <label for="">Curtidas</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="instagram">
                        <div class="row">
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="reach_insta" placeholder="Visualização do post">
                              <label for="">Alcance</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="views_insta" placeholder="Visitas do perfil">
                              <label for="">Visitas ao perfil</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="followers_insta" placeholder="Novos seguidores">
                              <label for="">Novos seguidores</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="tiktok">
                        <div class="row">
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="views_video" placeholder="Visualização do post">
                              <label for="">Visualizações de vídeo</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="views_profile" placeholder="Visitas do perfil">
                              <label for="">Visualizações de perfil</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="likes_tiktok" placeholder="Novos seguidores">
                              <label for="">Curtidas</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="comments" placeholder="Novos seguidores">
                              <label for="">Comentários</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="shares" placeholder="Novos seguidores">
                              <label for="">Compartilhamentos</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="followers_tiktok" placeholder="Novos seguidores">
                              <label for="">Seguidores</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="number_videos" placeholder="Número de vídeos">
                              <label for="">Número de vídeos publicados</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="number_lives" placeholder="Número de lives">
                              <label for="">Número de lives realizadas</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="twitch">
                        <div class="row">
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="media" placeholder="Média de espectadores">
                              <label for="">Média de espectadores</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="minutes" placeholder="Minutos Gerados">
                              <label for="">Minutos gerados</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="followers_twitch" placeholder="Novos seguidores">
                              <label for="">Novos seguidores</label>
                            </div>
                          </div>
                          <div class="col-md-6 pb-3">
                            <div class="form-floating">
                              <input type="text" class="form-control" value="" name="unique_participants" placeholder="Participantes Unicos">
                              <label for="">Paticipantes únicos do chat</label>
                            </div>
                          </div>
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
  <script>
    $(document).ready(function() {
      //Select para mostrar e esconder divs
      $('#SelectOptions').on('change', function() {
        var SelectValue = '.' + $(this).val();
        $('.DivPai .twitter').hide();
        $('.DivPai .facebook').hide();
        $('.DivPai .instagram').hide();
        $('.DivPai .tiktok').hide();
        $('.DivPai .twitch').hide();
        $(SelectValue).toggle();
      });
    });
  </script>
</body>

</html>