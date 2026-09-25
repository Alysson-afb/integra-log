<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $tituloPagina ?? 'Integra-Log' ?></title>
    <link rel="stylesheet" href="/projetos-php/integra-log/assets/css/style.css">
</head>
<body>

    <div class="fundo-menu" id="fundoMenu" onclick="alternarMenu()"></div>

    <nav class="menu-lateral" id="menuLateral">

        <img src="/projetos-php/integra-log/assets/img/logo.png" alt="Integra-Log">

        <a href="/projetos-php/integra-log/home">Início</a>

        <?php if ($_SESSION['cargoUsuario'] == 1) : ?>

            <p class="grupo">Cadastros</p>
            <a href="/projetos-php/integra-log/visualizar-guias">Guias</a>
            <a href="/projetos-php/integra-log/visualizar-enderecos">Endereços</a>
            <a href="/projetos-php/integra-log/visualizar-motoristas">Motoristas</a>
            <a href="/projetos-php/integra-log/visualizar-usuarios">Usuários</a>

        <?php elseif ($_SESSION['cargoUsuario'] == 2) : ?>

            <p class="grupo">Cadastros</p>
            <a href="/projetos-php/integra-log/visualizar-guias">Guias</a>

        <?php endif; ?>

    </nav>

    <header class="topo">
            <button class="botao-menu" onclick="alternarMenu()">&#9776;</button>
            <a href="/projetos-php/integra-log/home" class="marca">
                <img src="/projetos-php/integra-log/assets/img/marca.png" alt="IntegraLog">
                <div>
                    <div class="marca-nome">Integra<span>Log</span></div>
                    <div class="marca-descricao">Controle de Entregas</div>
                </div>
            </a>

            <div class="topo-direita">

        <div class="topo-direita">

            <span class="usuario-logado">Olá, <strong><?= htmlspecialchars($_SESSION['nomeUsuario'] ?? '') ?></strong></span>

            <?php if ($_SESSION['cargoUsuario'] == 1 && !empty($botaoNovoLink)) : ?>
                <a class="botao" href="<?= $botaoNovoLink ?>"><?= $botaoNovoTexto ?></a>
            <?php endif; ?>

            <div class="separador"></div>

            <a class="botao-sair" href="/projetos-php/integra-log/logout">Sair</a>

        </div>

    </header>

    <main class="conteudo">
