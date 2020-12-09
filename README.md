# Api do teste QlickDev
Api feita para o teste da QlickDev

## Instructions
* Link api em produção: [https://api-filmow.herokuapp.com](https://api-filmow.herokuapp.com)
* Rodar localmente: ```php -S localhost:3030 -t public/```
* O frontend da aplicação pode ser acessado em: 
    * [Produção](http://app-filmow.herokuapp.com)
    * [Repositório](https://github.com/mateusdreher/app.test_QuickDev)

## Explanation

A api consite em consultar a api do [TMBD](https://developers.themoviedb.org/3/), tratar os dados e retornar. Consiste em 5 simples endpoints:

* Endpoint incial e lista todos os filmes : ```/api/movies```

* Endpoint para pegar detalhes de um filme : ```/api/movies/{movieId}```

* Endpoint listar todos os generos de filmes : ```/api/movies/genres```

* Endpoint para filtrar filmes por gênero: ```/api/movies/filter/genre/{genreId}

* Endpoint para filtrar filmes pelo nome: ```/api/movies/filter/name/{movieName}```