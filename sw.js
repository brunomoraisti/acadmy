
// esse é o nome que seu cache terá na caches API
var CACHE_NAME = 'acadmy.v27.04.2019.09.45';

// aqui você escolhe quais arquivos serão cacheados,
//  basicamente todos os arquivos podem ser cacheados
/*'/toaqui/',
    '/toaqui/login.php',
    '/toaqui/files/img/logonavegador.png'*/
var FILES_CACHE = [

];

// evento de INSTALAÇÃO do service worker,
//  nós só conseguimos salvar arquivos em cache
//  após o service worker ter sido instalado,
//  ou seja, após não acontecer nenhum problema.
self.addEventListener('install', function (event) {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(FILES_CACHE);
        })
    );
});

// evento de ATIVAÇÃO do service worker,
//  esse evento é chamado quando seu service worker
//  ja foi instalado previamente, ou seja, não é a
//  primeira vez que o seu usuário entra em seu site.
self.addEventListener('activate', function(e) {
    e.waitUntil(
        caches.keys()
            .then(function(keyList) {
                return Promise.all(keyList.map(function(key) {
                    // para manter nosso cache sempre atualizado e
                    //  sem arquivos desnecessários/versões antigas,
                    //  o indicado é verificarmos se no cache do nosso
                    //  service worker, as versões que estão lá são
                    //  diferentes das atuais, caso seja nós deletamos
                    //  a antiga para deixar somente a versão mais atual.
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                }));
            })
    );
    // a linha abaixo é para resolver um problema
    //  do service worker não retornar as informações
    //  mais recentes da aplicação no momento que seu
    //  usuário acessa a página, issso acontece por que
    //  seu service worker ainda não foi ativado, dessa forma
    //  nós fazemos ele ativar mais rápido com as informações
    //  mais novas que ele possuir.
    return self.clients.claim();
});

// evento de FETCHING do service worker,
//  ele verificará quando alguma requisição corresponde
//  a algum arquivo que ja está no cache,
//  caso esteja ele retornará o arquivo do cache,
//  se não estiver, fará a requisição do arquivo
//  e retornará o resultado dessa requisição.
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (cachedResponse) {
            return cachedResponse || fetch(event.request);
        })
    );
});

