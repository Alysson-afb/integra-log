<?php
    if ($guia['pesoGuia'] > 0) {
        $valorKgAtual = number_format($guia['valorFrete'] / $guia['pesoGuia'], 2, '.', '');
    } else {
        $valorKgAtual = '0.00';
    }
?>
<?php
    $tituloPagina = 'Editar Guia';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Editar Guia</h2>
    <form class="formulario" action="/projetos-php/integra-log/editar-guia?id=<?= urlencode($guia['idGuia'] ?? '') ?>" method="POST">

        <label for="containerNumeroGuia">Número da Guia:</label>
        <input type="text" id="containerNumeroGuia" name="containerNumeroGuia" value="<?= $guia['numeroGuia'] ?? '' ?>" required>

        <label for="containerDataEmissaoGuia">Data de Emissão:</label>
        <input type="date" id="containerDataEmissaoGuia" name="containerDataEmissaoGuia" value="<?= $guia['dataEmissaoGuia'] ?? '' ?>" required>

        <label for="containerDestinoGuia">Destino:</label>
        <select id="containerDestinoGuia" name="containerDestinoGuia" onchange="atualizarValorFrete()" required>
            <?php foreach ($enderecos as $endereco) : ?>
                <option value="<?= $endereco['idEndereco'] ?>"
                        data-consumo="<?= $endereco['valorConsumo'] ?>"
                        data-permanente="<?= $endereco['valorPermanente'] ?>"
                        <?= ($guia['destinoGuia'] ?? '') == $endereco['idEndereco'] ? 'selected' : '' ?>>
                    <?= $endereco['nomeEndereco'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="containerTipoTransporteGuia">Tipo de Transporte:</label>
        <select id="containerTipoTransporteGuia" name="containerTipoTransporteGuia" required>
            <option value="1" <?= ($guia['tipoTransporteGuia'] ?? '') == 1 ? 'selected' : '' ?>>Remessa</option>
            <option value="2" <?= ($guia['tipoTransporteGuia'] ?? '') == 2 ? 'selected' : '' ?>>Recolhimento</option>
        </select>

        <label for="containerMotoristaGuia">Motorista:</label>
        <select id="containerMotoristaGuia" name="containerMotoristaGuia" required>
            <?php foreach ($motoristas as $motorista) : ?>
                <option value="<?= $motorista['idMotorista'] ?>" <?= ($guia['motoristaGuia'] ?? '') == $motorista['idMotorista'] ? 'selected' : '' ?>>
                    <?= $motorista['nomeMotorista'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="containerModalidadeGuia">Modalidade:</label>
        <select id="containerModalidadeGuia" name="containerModalidadeGuia" onchange="atualizarValorFrete()" required>
            <option value="1" <?= ($guia['modalidadeGuia'] ?? '') == 1 ? 'selected' : '' ?>>Consumo</option>
            <option value="2" <?= ($guia['modalidadeGuia'] ?? '') == 2 ? 'selected' : '' ?>>Permanente</option>
        </select>

        <label for="containerPesoGuia">Peso (kg):</label>
        <input type="number" step="0.01" min="0" id="containerPesoGuia" name="containerPesoGuia" value="<?= $guia['pesoGuia'] ?? '' ?>" oninput="atualizarValorFrete()" required>

        <label for="valorKgFrete">Valor do Kg:</label>
        <input type="number" step="0.01" min="0" id="valorKgFrete" name="valorKgFrete" value="<?= $valorKgAtual ?>" readonly>

        <label for="valorTotalFrete">Valor Total do Frete:</label>
        <input type="number" step="0.01" min="0" id="containerValorTotalFrete" name="containerValorTotalFrete" value="<?= $guia['valorFrete'] ?? '' ?>" readonly>

        <label for="containerStatusGuia">Status:</label>
        <select id="containerStatusGuia" name="containerStatusGuia" required>
            <option value="1" <?= ($guia['statusGuia'] ?? '') == 1 ? 'selected' : '' ?>>Coletada</option>
            <option value="2" <?= ($guia['statusGuia'] ?? '') == 2 ? 'selected' : '' ?>>Transferência</option>
            <option value="3" <?= ($guia['statusGuia'] ?? '') == 3 ? 'selected' : '' ?>>Rota</option>
            <option value="4" <?= ($guia['statusGuia'] ?? '') == 4 ? 'selected' : '' ?>>Entregue</option>
            <option value="5" <?= ($guia['statusGuia'] ?? '') == 5 ? 'selected' : '' ?>>Divergência</option>
        </select>

        <label for="containerObservacaoHistorico">Observação (registrada apenas se o status mudar):</label>
        <input type="text" id="containerObservacaoHistorico" name="containerObservacaoHistorico" maxlength="255">

        <button type="submit" class="botao">Salvar alterações</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-guias'">Voltar</button>

    </form>

    <script src="/projetos-php/integra-log/assets/js/valor-frete.js"></script>

<?php require 'src/views/footer.php'; ?>
