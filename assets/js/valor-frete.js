function atualizarValorFrete() {

    var destino = document.getElementById('containerDestinoGuia');
    var peso = document.getElementById('containerPesoGuia').value;
    var valorKg = document.getElementById('valorKgFrete');
    var valorTotal = document.getElementById('containerValorTotalFrete');
    var campoModalidade = document.querySelector('input[name="containerModalidadeGuia"]:checked');

    if (campoModalidade == null) {
        campoModalidade = document.getElementById('containerModalidadeGuia');
    }
    
    if (destino.value == '') {
        valorKg.value = '';
        valorTotal.value = '';
        return;
    }

    var opcao = destino.options[destino.selectedIndex];

    if (campoModalidade.value == 2) {
        valorKg.value = opcao.getAttribute('data-permanente');
    } else {
        valorKg.value = opcao.getAttribute('data-consumo');
    }

    valorTotal.value = (peso * valorKg.value).toFixed(2);
}
