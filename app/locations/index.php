<?php
require_once "../lib/session.php";
$logado = validaSessao();
        // header("Location: ../login/");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accessible.io</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/css/locations.css">
    <link rel="stylesheet" href="../../public/assets/css/modal.css">
    <script defer src="../../public/assets/js/locations.js"></script>
    <script defer src="../../public/assets/js/modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="main-container">
        <header>
            <h1>accessible</h1>
            <div class="links">
                <?php
                echo !$logado ?  "<a href='../login/'>Entrar</a>" :
                '<a href="javascript:void(0);" onclick="openModal()">Cadastrar um Local <img width="15" src="../../public/assets/img/usuario.svg" tooltip="Sair" onClick="window.location = \'../lib/sair.php\'" alt="">  </a>' ?>
            </div>
        </header>

        <main>
            <div class="container">
                <div class="message">
                    Encontre agora locais acessíveis perto de você!
                </div>
                <div class="main">
                    <div class="filters">
                        <select name="estado" id="estado">
                            <option value="">UF</option>
                        </select>
                        <select name="cidade" id="cidade">
                            <option value="">Selecione a Cidade</option>
                        </select>
                        <input type="search" name="search" placeholder="Ex: MUSEU, TEATRO" id="search">
                        <button class="pesquisar" id="pesquisa"><img width="50" src="../../public/assets/img/search.svg" alt="" srcset=""></button>
                    </div>
                    <div class="results">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        Local
                                    </th>
                                    <th>
                                        Endereço
                                    </th>
                                    <th colspan="2">
                                        Acessibilidades
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <!-- Modal Structure -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Cadastrar um local</h2>
            <form id="form" method="post" class="form">
                <div class="main-modal">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="nome">Nome do local:</label>
                            <input type="text" id="nome" required name="nome">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" required name="cep" maxlength="9" placeholder="00000-000" oninput="mascaraCEP(this)" onkeypress="return apenasNumeros(event)">
                        </div>
                        <div class="input-group">
                            <label for="endereco">Endereco:</label>
                            <input type="text" id="endereco" required name="endereco">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="estado">Estado:</label>
                            <select name="estado" id="estado-form">
                                <option value="">UF</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="cidade">Cidade:</label>
                            <select name="cidade" id="cidade-form">
                                <option value="">Selecione uma cidade</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="accessibilidades">Acessibilidades:</label>
                            <input name='input-custom-dropdown' class='tagify--custom-dropdown' placeholder='Pesquise por acessibilidades disponíveis'>
                        </div>
                    </div>
                </div>
                <button class="btn-success" >Cadastrar</button>
            </form>

        </div>
    </div>
</body>

<?php
    if (isset($_GET["error"]) && trim($_GET["error"])) {
        echo "<script>alert('{$_GET["error"]}')</script>";
    }
?>

</html>