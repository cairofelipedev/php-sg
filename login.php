<?php
session_start();
require_once 'config/classes/Conexao.php';
require_once 'config/classes/Logar.php';
include 'config/AddLog.php';
require_once 'config/DatabaseConfig.php';

if (isset($_POST['ok'])) :
  $login = filter_input(INPUT_POST, "login");
  $password = filter_input(INPUT_POST, "password");
  $_1 = new Login;
  $_1->setLogin($login);
  $_1->setPassword($password);

  if ($_1->logar()) :
    $successMSG = "Entrando";
  else :
    $errMSG = "Usuário ou senha inválidos ...";
  endif;
endif;
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>SG Sports - Sistema de Streamers e Influenciadores</title>
  <meta content="SG Sports - Sistema de Streamers e Influenciadores" name="description">
  <meta content="SG Sports, Sistema de Streamers, Influenciadores" name="keywords">
  <!-- Favicons -->
  <link href="img/SG.png" rel="icon">
  <link href="img/SG.png" rel="apple-touch-icon">

</head>

<body>
  <div class="flex min-h-screen flex-col items-center bg-black justify-center py-2">
    <main class="flex w-full flex-1 flex-col items-center justify-center text-center">
      <div class="  flex flex-col justify-center sm:py-12">
        <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
          <section class="container max-w-screen-lg mx-auto pb-10">
            <img class="mx-auto" src="img/SG.png" width="100" alt="SG">
          </section>
          <h1 class="font-bold text-center text-white text-2xl mb-5">Entrar no Sistema</h1>
          <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="px-5 py-7">
              <form action="" method="POST">
                <label class="font-semibold text-sm text-gray-600 pb-1 block">Login</label>
                <input type="text" name="login" placeholder="Login" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                <label class="font-semibold text-sm text-gray-600 pb-1 block">Senha</label>
                <input type="password" name="password" placeholder="Senha" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                <button type="submit" name="ok" class="transition duration-200 bg-black hover:bg-white hover:text-black focus:bg-blue-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                  <span class="inline-block mr-2">Login</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                  </svg>
                </button>
              </form>
            </div>
            <?php
            if (isset($successMSG)) {
              if (isset($_SESSION['logado'])) :
              else :
                header("Location: login.php");
              endif;
            ?>
              <form action="" method="POST">
                <input type="hidden" class="form-control" type="text" name="name" value="<?php echo $_SESSION['name']; ?>" />
                <input type="hidden" class="form-control" type="text" name="type" value="login" />
                <button id="clickButton" type="submit" name="submit" style="background-color:transparent;" value="LOG"></button>
              </form>
              <div class="bg-green-200 mx-auto mt-6 p-2">
                <div class="flex justify-center space-x-2">
                  <svg role="status" class="mr-2 w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-green-900" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                  </svg>
                  <p class="text-green-900 text-center font-semibold"><?php echo $successMSG; ?></p>
                </div>
              </div>
            <?php
            }
            ?>
            <?php
            if (isset($errMSG)) {
            ?>
              <div class="bg-red-200 mx-auto mt-6 p-2">
                <div class="flex justify-center space-x-2">
                  <svg class="w-6 h-6 stroke-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-red-900 text-center font-semibold"> <?php echo $errMSG; ?></p>
                </div>
              </div>
            <?php
            }
            ?>
            <div class="py-5">
              <div class="grid grid-cols-2 gap-1">
                <div class="text-center sm:text-left whitespace-nowrap">
                  <button class="transition duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    <span class="inline-block ml-1">Esqueceu a senha?</span>
                  </button>
                </div>
                <div class="text-center sm:text-right whitespace-nowrap">
                  <button class="transition duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-bottom	">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="inline-block ml-1">Suporte</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="w-full items-center justify-center">
      <a class="flex items-center text-white justify-center gap-2" href="https://vercel.com?utm_source=create-next-app&utm_medium=default-template&utm_campaign=create-next-app" target="_blank" rel="noopener noreferrer">
        Sistema de Streamers e Influenciadores
      </a>
      <section class="container max-w-screen-lg mx-auto">
        <img class="mx-auto" src="img/SG.png" width="50" alt="SG">
        <a class="flex items-center text-white justify-center gap-2" href="https://instagram.com/cairofelipedev" target="_blank" rel="noopener noreferrer">
          Desenvolvido por: Cairo Felipe Dev
        </a>
      </section>
    </footer>
  </div>
  <script type="text/javascript">
    window.setTimeout(function() {
      document.getElementById("clickButton").click();
    }, 1500);
  </script>
</body>