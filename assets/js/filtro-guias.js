// Filtra a lista de guias que ja esta na tela, sem recarregar a pagina.
// A busca e o filtro de motorista funcionam junto com o chip de situacao selecionado.

var statusSelecionado = 'todos';

function filtrarGuias() {

    var busca = document.getElementById('campoBusca').value.toLowerCase();
    var motorista = document.getElementById('campoMotorista').value;
    var linhas = document.querySelectorAll('.linha-guia');
    var encontradas = 0;

    for (var i = 0; i < linhas.length; i++) {

        var linha = linhas[i];
        var mostrar = true;

        if (busca != '' && linha.getAttribute('data-busca').indexOf(busca) == -1) {
            mostrar = false;
        }

        if (motorista != '' && linha.getAttribute('data-motorista') != motorista) {
            mostrar = false;
        }

        if (statusSelecionado != 'todos' && linha.getAttribute('data-status') != statusSelecionado) {
            mostrar = false;
        }

        if (mostrar) {
            linha.style.display = '';
            encontradas = encontradas + 1;
        } else {
            linha.style.display = 'none';
        }
    }

    if (encontradas == 0) {
        document.getElementById('avisoVazio').style.display = '';
    } else {
        document.getElementById('avisoVazio').style.display = 'none';
    }
}

function selecionarStatus(status, chipClicado) {

    statusSelecionado = status;

    var chips = document.querySelectorAll('.chip');

    for (var i = 0; i < chips.length; i++) {
        chips[i].classList.remove('ativo');
    }

    chipClicado.classList.add('ativo');

    filtrarGuias();
}
