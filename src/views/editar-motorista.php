<?php
    $tituloPagina = 'Editar Motorista';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Editar Motorista</h2>
    <form class="formulario" action="/projetos-php/integra-log/editar-motorista?id=<?= urlencode($motorista['idMotorista'] ?? '') ?>" method="POST">

        <label for="nome">Nome:</label>
        <input type="text" id="containerNome" name="containerNome" value="<?= $motorista['nomeMotorista'] ?? '' ?>" required>

        <label for="email">E-mail:</label>
        <input type="email" id="containerEmail" name="containerEmail" value="<?= $motorista['emailMotorista'] ?? '' ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="containerCpf" name="containerCpf" value="<?= $motorista['cpfMotorista'] ?? '' ?>">

        <label for="cnh">CNH:</label>
        <input type="text" id="containerCnh" name="containerCnh" value="<?= $motorista['cnhMotorista'] ?? '' ?>">

        <label for="telefone">Telefone:</label>
        <input type="text" id="containerTelefone" name="containerTelefone" value="<?= $motorista['telefoneMotorista'] ?? '' ?>">

        <button type="submit" class="botao">Salvar alterações</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-motoristas'">Voltar</button>
        
    </form>

<?php require 'src/views/footer.php'; ?>
