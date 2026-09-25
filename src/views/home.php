<?php
    $tituloPagina = 'Início';
    require 'src/views/header.php';
?>

    <h2 class="titulo-pagina">Bem-vindo, <?= htmlspecialchars($nomeUsuario ?? '') ?>!</h2>

    <?php if ($cargoUsuario == 1) : ?>

        <div class="cartao">
            <h3>Guias</h3>
            <a href="/projetos-php/integra-log/visualizar-guias">Visualizar Guias</a> &nbsp;|&nbsp;
            <a href="/projetos-php/integra-log/cadastrar-guia">Cadastrar Guia</a>
        </div>

        <div class="cartao">
            <h3>Endereços</h3>
            <a href="/projetos-php/integra-log/visualizar-enderecos">Visualizar Endereços</a> &nbsp;|&nbsp;
            <a href="/projetos-php/integra-log/cadastrar-endereco">Cadastrar Endereço</a>
        </div>

        <div class="cartao">
            <h3>Motoristas</h3>
            <a href="/projetos-php/integra-log/visualizar-motoristas">Visualizar Motoristas</a> &nbsp;|&nbsp;
            <a href="/projetos-php/integra-log/cadastrar-motorista">Cadastrar Motorista</a>
        </div>

        <div class="cartao">
            <h3>Usuários</h3>
            <a href="/projetos-php/integra-log/visualizar-usuarios">Visualizar Usuários</a> &nbsp;|&nbsp;
            <a href="/projetos-php/integra-log/cadastrar-usuario">Cadastrar Usuário</a>
        </div>

    <?php elseif ($cargoUsuario == 2) : ?>

        <div class="cartao">
            <h3>Guias</h3>
            <a href="/projetos-php/integra-log/visualizar-guias">Visualizar Guias</a>
        </div>

    <?php else : ?>

        <div class="cartao">
            <p>Portal do motorista em desenvolvimento.</p>
        </div>

    <?php endif; ?>

<?php require 'src/views/footer.php'; ?>
