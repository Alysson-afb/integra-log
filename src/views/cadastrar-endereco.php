<?php
    $tituloPagina = 'Cadastrar Endereço';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Cadastrar Endereço</h2>
    <form class="formulario" action="/projetos-php/integra-log/cadastrar-endereco" method="POST">

        <label for="containerNome">Nome do Local:</label>
        <input type="text" id="containerNome" name="containerNome"  placeholder="Informe o nome do local" required>
    
        <label for="containerLogradouro">Logradouro:</label>
        <input type="text" id="containerLogradouro" name="containerLogradouro" placeholder="Informe o logradouro" required>
 
        <label for="containerBairro">Bairro:</label>
        <input type="text" id="containerBairro" name="containerBairro" placeholder="Informe o bairro" required>
     
        <label for="containerCidade">Cidade:</label>
        <input type="text" id="containerCidade" name="containerCidade" placeholder="Informe a cidade" required>
    
        <label for="containerEstado">Estado:</label>
        <input type="text" id="containerEstado" name="containerEstado" placeholder="Informe a UF" maxlength="2" required>
       
        <label for="containerCep">CEP:</label>
        <input type="text" id="containerCep" name="containerCep" placeholder="Informe o CEP" required>
     
        <label for="containerValorConsumo">Valor do Kg - Consumo (R$):</label>
        <input type="number" step="0.01" min="0" id="containerValorConsumo" name="containerValorConsumo" placeholder="Informe o valor do kg de consumo" required>
    
        <label for="containerValorPermanente">Valor do Kg - Permanente (R$):</label>
        <input type="number" step="0.01" min="0" id="containerValorPermanente" name="containerValorPermanente" placeholder="Informe o valor do kg de permanente" required>

        <button type="submit" class="botao">Cadastrar Endereço</button>
        <button type="button" class="botao botao-cancelar" onclick="window.location.href='/projetos-php/integra-log/visualizar-enderecos'">Voltar</button>

    </form>

<?php require 'src/views/footer.php'; ?>
