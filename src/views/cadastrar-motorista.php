<?php
    $tituloPagina = 'Cadastrar Motorista';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Cadastrar Motorista</h2>
    <form class="formulario" action="/projetos-php/integra-log/cadastrar-motorista" method="POST">

        <label for="nome">Nome:</label>
        <input type="text" id="containerNome" name="containerNome" placeholder="Informe o nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="containerEmail" name="containerEmail" placeholder="Informe o e-mail" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="containerCpf" name="containerCpf" placeholder="Informe o CPF" required>

        <label for="cnh">CNH:</label>
        <input type="text" id="containerCnh" name="containerCnh" placeholder="Informe a CNH" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="containerTelefone" name="containerTelefone" placeholder="Informe o telefone" required>

        <button type="submit" class="botao">Cadastrar Motorista</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-motoristas'">Voltar</button>

    </form>

<?php require 'src/views/footer.php'; ?>
