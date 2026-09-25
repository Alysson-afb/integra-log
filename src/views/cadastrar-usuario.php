<?php
    $tituloPagina = 'Cadastrar Usuário';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Cadastrar Usuário</h2>
    <form class="formulario" action="/projetos-php/integra-log/cadastrar-usuario" method="POST">

        <label for="containerNome">Nome:</label>
        <input type="text" id="containerNome" name="containerNome" placeholder="Digite o nome" required>

        <label for="containerEmail">E-mail:</label>
        <input type="email" id="containerEmail" name="containerEmail" placeholder="Digite o e-mail" required>

        <label for="containerSenha">Senha:</label>
        <input type="password" id="containerSenha" name="containerSenha" placeholder="Digite a senha" required>

        <p>Cargo:</p>
        <label><input type="radio" name="containerCargo" value="1" checked> Administrador</label>
        <label><input type="radio" name="containerCargo" value="2"> Cliente</label>
        <label><input type="radio" name="containerCargo" value="3"> Motorista</label>
        <br>

        <button type="submit" class="botao">Cadastrar</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-usuarios'">Voltar</button>

    </form>

<?php require 'src/views/footer.php'; ?>
