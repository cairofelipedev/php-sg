<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="flex min-h-screen flex-col items-center bg-black justify-center py-2">
    <main class="flex w-full flex-1 flex-col items-center justify-center text-center">
      <div class="min-h-screen  flex flex-col justify-center sm:py-12">
        <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
          <section class="container max-w-screen-lg mx-auto pb-10">
            <img class="mx-auto" src="img/SG.png" width="100" alt="SG">
          </section>
          <h1 class="font-bold text-center text-white text-2xl mb-5">Entrar no Sistema</h1>
          <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="px-5 py-7">
              <label class="font-semibold text-sm text-gray-600 pb-1 block">E-mail</label>
              <input type="text" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
              <label class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
              <input type="text" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
              <button type="button" class="transition duration-200 bg-black hover:bg-white hover:text-black focus:bg-blue-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                <span class="inline-block mr-2">Login</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </button>
            </div>
            <div class="py-5">
              <div class="grid grid-cols-2 gap-1">
                <div class="text-center sm:text-left whitespace-nowrap">
                  <button class="transition duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    <span class="inline-block ml-1">Esqueciu a senha?</span>
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

    <footer class="h-24 w-full items-center justify-center">
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
</body>