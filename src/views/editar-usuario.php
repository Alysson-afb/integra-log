<?php
    $tituloPagina = 'Editar Usuário';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Editar Usuário</h2>
    <form class="formulario" action="/projetos-php/integra-log/editar-usuario?id=<?= $usuario['idUsuario'] ?>" method="POST">

        <label for="containerNome">Nome:</label>
        <input type="text" id="containerNome" name="containerNome" value="<?= htmlspecialchars($usuario['nomeUsuario'] ?? '') ?>" required>

        <label for="containerEmail">E-mail:</label>
        <input type="email" id="containerEmail" name="containerEmail" value="<?= htmlspecialchars($usuario['emailUsuario'] ?? '') ?>" required>

        <label for="containerSenha">Nova senha (deixe em branco pra manter a atual):</label>
        <input type="password" id="containerSenha" name="containerSenha">

        <p>Cargo:</p>
        <label><input type="radio" name="containerCargo" value="1" <?= ($usuario['cargoUsuario'] ?? '') == 1 ? 'checked' : '' ?>> Administrador</label>
        <label><input type="radio" name="containerCargo" value="2" <?= ($usuario['cargoUsuario'] ?? '') == 2 ? 'checked' : '' ?>> Cliente</label>
        <label><input type="radio" name="containerCargo" value="3" <?= ($usuario['cargoUsuario'] ?? '') == 3 ? 'checked' : '' ?>> Motorista</label>
        <br>

        <button type="submit" class="botao">Salvar alterações</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-usuarios'">Voltar</button>

    </form>

<?php require 'src/views/footer.php'; ?>
