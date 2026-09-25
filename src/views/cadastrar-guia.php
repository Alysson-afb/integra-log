<?php
    $tituloPagina = 'Cadastrar Guia';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Cadastrar Guia</h2>
    <form class="formulario" action="/projetos-php/integra-log/cadastrar-guia" method="post">

        <label for="numeroGuia">Número da Guia:</label>
        <input type="text" id="containerNumeroGuia" name="containerNumeroGuia" placeholder="Informe o número da guia" required>

        <input type="hidden" id="containerDataEmissaoGuia" name="containerDataEmissaoGuia" value="<?= date('Y-m-d') ?>">

        <label for="destinoGuia">Endereço de Destino:</label>
        <select id="containerDestinoGuia" name="containerDestinoGuia" onchange="atualizarValorFrete()" required>
            <option value="">Selecione o endereço</option>
            <?php foreach ($enderecos as $endereco): ?>
                <option value="<?= $endereco['idEndereco'] ?>"
                        data-consumo="<?= $endereco['valorConsumo'] ?>"
                        data-permanente="<?= $endereco['valorPermanente'] ?>">
                    <?= $endereco['nomeEndereco'] ?> - <?= $endereco['cidadeEndereco'] ?>/<?= $endereco['estadoEndereco'] ?>
                </option>
            <?php endforeach; ?>
        </select>
   
       <p><strong>Tipo de Transporte:</strong></p>
        <label><input type="radio" name="containerTipoTransporteGuia" value="1" checked> Remessa</label>
        <label><input type="radio" name="containerTipoTransporteGuia" value="2"> Recolhimento</label>
  
        <p><strong>Modalidade de Transporte:</strong></p>
        <label><input type="radio" name="containerModalidadeGuia" value="1" onchange="atualizarValorFrete()" checked> Consumo</label>
        <label><input type="radio" name="containerModalidadeGuia" value="2" onchange="atualizarValorFrete()"> Permanente</label>
        <br>
   
        <label for="pesoGuia">Peso (kg):</label>
        <input type="number" step="0.01" min="0" id="containerPesoGuia" name="containerPesoGuia" placeholder="Informe o peso da guia" oninput="atualizarValorFrete()" required>
     
        <label for="valorKgFrete">Valor do Kg:</label>
        <input type="number" step="0.01" min="0" id="valorKgFrete" name="valorKgFrete" readonly>

        <label for="valorTotalFrete">Valor Total do Frete:</label>
        <input type="number" step="0.01" min="0" id="containerValorTotalFrete" name="containerValorTotalFrete" readonly>

       <p><strong>Status da Carga:</strong></p>
        <label><input type="radio" name="containerStatusGuia" value="1" checked> Coletada</label>
        <label><input type="radio" name="containerStatusGuia" value="2"> Transferencia</label>
        <label><input type="radio" name="containerStatusGuia" value="3"> Rota</label>
        <label><input type="radio" name="containerStatusGuia" value="4"> Entregue</label>
        <label><input type="radio" name="containerStatusGuia" value="5"> Divergencia</label>
        <br>

        <label for="motoristaGuia">Motorista:</label>
        <select id="containerMotoristaGuia" name="containerMotoristaGuia" required>
            <option value="">Selecione o motorista</option>
            <?php foreach ($motoristas as $motorista): ?>
                <option value="<?= $motorista['idMotorista'] ?>">
                    <?= $motorista['nomeMotorista'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="botao">Cadastrar Guia</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-guias'">Voltar</button>

    </form>

    <script src="/projetos-php/integra-log/assets/js/valor-frete.js"></script>

    <script>atualizarValorFrete();</script>

<?php require 'src/views/footer.php'; ?>
