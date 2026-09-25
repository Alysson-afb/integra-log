<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar - Integra-Log</title>
    <link rel="stylesheet" href="/projetos-php/integra-log/assets/css/style.css">
</head>
<body class="tela-login">

    <div class="caixa-login">

        <img src="/projetos-php/integra-log/assets/img/logo.png" alt="Integra-Log">

        <?php if (!empty($erro)) : ?>
            <p class="mensagem mensagem-erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form class="formulario" action="/projetos-php/integra-log/login" method="POST">

            <label for="containerEmail">E-mail</label>
            <input type="email" id="containerEmail" name="containerEmail" value="<?= htmlspecialchars($emailLembrado ?? '') ?>" autocomplete="username" required>

            <label for="containerSenha">Senha</label>
            <input type="password" id="containerSenha" name="containerSenha" autocomplete="current-password" required>

            <label class="lembrar-email">
                <input type="checkbox" name="containerLembrarEmail" value="1" <?= !empty($emailLembrado) ? 'checked' : '' ?>>
                Lembrar meu e-mail neste computador
            </label>

            <button type="submit" class="botao">Entrar</button>

        </form>

    </div>

</body>
</html>
