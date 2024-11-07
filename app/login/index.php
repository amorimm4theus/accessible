<?php
require_once "../lib/session.php";
    if (validaSessao()) {
        header("Location: ../locations/");
    }
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
    <link rel="stylesheet" href="../../public/assets/css/login.css">
    <script defer src="../../public/assets/js/login.js"></script>

</head>

<body>
    <div class="main-container">
        <header>
            <h1>accessible</h1>
            <div class="links">
            </div>
        </header>

        <main>
            <div class="container">
                <div class="message">
                    Entre agora!
                </div>
                <div class="main">
                    <form action="login.php" method="post" class="form">
                            <div class="input-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" required name="email">
                        </div>
                            <div class="input-group">
                                <label for="senha">Senha:</label>
                                <input type="password" id="senha" required name="senha">
                            </div>
                        <div class="form-row" style="align-self: start;">
                            <a href="../register/">Criar uma conta</a>
                        </div>
                        <div class="form-row" style="align-self: center;">
                            <button class="btn-success">
                                Entrar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>

</body>

<?php
    if (isset($_GET["error"]) && trim($_GET["error"])) {
        echo "<script>alert('{$_GET["error"]}')</script>";
    }
?>

</html>