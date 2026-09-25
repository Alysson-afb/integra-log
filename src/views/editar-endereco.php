<?php
    $tituloPagina = 'Editar Endereço';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Editar Endereço</h2>
    <form class="formulario" action="/projetos-php/integra-log/editar-endereco?id=<?= urlencode($endereco['idEndereco'] ?? '') ?>" method="POST">

        <label for="containerNome">Nome do Local:</label>
        <input type="text" id="containerNome" name="containerNome" value="<?= htmlspecialchars($endereco['nomeEndereco'] ?? '') ?>" required>

        <label for="containerLogradouro">Logradouro:</label>
        <input type="text" id="containerLogradouro" name="containerLogradouro" value="<?= htmlspecialchars($endereco['logradouroEndereco'] ?? '') ?>" required>

        <label for="containerBairro">Bairro:</label>
        <input type="text" id="containerBairro" name="containerBairro" value="<?= htmlspecialchars($endereco['bairroEndereco'] ?? '') ?>" required>

        <label for="containerCidade">Cidade:</label>
        <input type="text" id="containerCidade" name="containerCidade" value="<?= htmlspecialchars($endereco['cidadeEndereco'] ?? '') ?>" required>

        <label for="containerEstado">Estado:</label>
        <input type="text" id="containerEstado" name="containerEstado" maxlength="2" value="<?= htmlspecialchars($endereco['estadoEndereco'] ?? '') ?>" required>

        <label for="containerCep">CEP:</label>
        <input type="text" id="containerCep" name="containerCep" value="<?= htmlspecialchars($endereco['cepEndereco'] ?? '') ?>" required>

        <label for="containerValorConsumo">Valor do Kg - Consumo (R$):</label>
        <input type="number" step="0.01" min="0" id="containerValorConsumo" name="containerValorConsumo" value="<?= htmlspecialchars($endereco['valorConsumo'] ?? '0.00') ?>" required>

        <label for="containerValorPermanente">Valor do Kg - Permanente (R$):</label>
        <input type="number" step="0.01" min="0" id="containerValorPermanente" name="containerValorPermanente" value="<?= htmlspecialchars($endereco['valorPermanente'] ?? '0.00') ?>" required>

        <button type="submit" class="botao">Salvar alterações</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-enderecos'">Voltar</button>

    </form>

<?php require 'src/views/footer.php'; ?>
