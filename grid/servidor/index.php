<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Optimus</title>
        <meta http-equiv="content-language" content="br">

        <link rel="stylesheet" href="/deps/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <!-- JS, Popper.js, and jQuery -->
        <script src="/deps/js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="/deps/js/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="/deps/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


        <script type="module">
            import { LaTeXJSComponent } from "/deps/latex_mod.js"
            customElements.define("latex-js", LaTeXJSComponent)
        </script>

        <link rel="stylesheet" href="/deps/css/padrao.css">
        <script src="/deps/js/padrao.js"></script>

    </head>
    <body class="bg-dark">


        <div id="sidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/painel_esquerda.php'; ?>
        </div>


        <section id="main">
            <section id="top_nav" style="width: 100%;">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" onclick="trocarNav();" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <img class="d-none d-sm-block" src="/euclides.png" width="30" height="30" alt="" onclick="window.location = '/';">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/"> Inicio <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sobre"> Sobre </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://github.com/Sekva/primos" target="_blank"> Repositório </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/baixar"> Download </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </section>

            <div class="container-fluid bg-dark text-light" style="width: 100%;">
                <div class="row">
                    <div class="d-none d-sm-block col-sm-2 bg-dark" style="position: fixed;">
                        <br><br><br><br>
                        <div id="painel_esquerda_div" class="bg-dark list-group">
                            <?php include $_SERVER["DOCUMENT_ROOT"] . '/painel_esquerda.php'; ?>
                        </div>
                    </div>

                    <div class="d-none d-sm-block col-sm-2" style="visibility: hidden;"></div>

                    <!-- TODO: esse include conteudo ainda pode ficar dentro dum container, pra ficar como no laravel, ou deixa assim memo? -->
                    <div class="col-sm-7"> <?php include 'conteudo.php'; ?> </div>
                    <div class="col-sm-3"> <?php include $_SERVER["DOCUMENT_ROOT"] . '/painel_direita.php'; ?> </div>

                </div>
            </div>
        </section>

        <script>
            for(let link of document.getElementById("painel_esquerda_div").children) {
                link.classList.add("list-group-item");
                link.classList.add("list-group-item-action");
                link.classList.add("list-group-item-dark");

                if(window.location.pathname === link.attributes.href.textContent + "/") {
                    link.classList.add("active");
                }
            }
        </script>

    </body>
</html>
