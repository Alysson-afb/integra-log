    <?php
    $tituloPagina = 'Portal do Motorista';
    require 'src/views/header.php';

    $situacoes = [1 => 'Coletada', 2 => 'Transferência', 3 => 'Rota', 4 => 'Entregue', 5 => 'Divergente'];
?>

<div class="motorista-container">
    <!-- Barra de Pesquisa -->
    <div class="motorista-busca">
        <input type="text" id="buscaMotorista" placeholder="Pesquisar nº da guia ou destino..." oninput="filtrarMotorista()">
    </div>

    <!-- Listagem de Guias -->
    <div class="motorista-lista" id="listaGuias">
        <?php if (!empty($guias)) : ?>
            <?php foreach ($guias as $guia) : ?>
                <!-- O data-status ajuda o JavaScript a filtrar entre Disponíveis e Entregues -->
                <div class="card-guia" 
                     data-status="<?= $guia['statusGuia'] ?>" 
                     data-busca="<?= htmlspecialchars(strtolower($guia['numeroGuia'] . ' ' . $guia['nomeEndereco'])) ?>">
                    
                    <div class="card-corpo">
                        <p><strong>Destino:</strong> <?= htmlspecialchars($guia['nomeEndereco']) ?> - <?= htmlspecialchars($guia['cidadeEndereco']) ?></p>
                        <p><strong>Peso:</strong> <?= number_format($guia['pesoGuia'], 2, ',', '.') ?> kg</p>
                    </div>
                    
                    <div class="card-corpo">
                        <p><strong>Destino:</strong> <?= htmlspecialchars($guia['nomeEndereco']) ?> - <?= htmlspecialchars($guia['cidadeEndereco']) ?></p>
                        <p><strong>Peso:</strong> <?= number_format($guia['pesoGuia'], 2, ',', '.') ?> kg</p>
                    </div>
                    
                    <div class="card-acao">
                        <a href="/projetos-php/integra-log/historico-guia?id=<?= $guia['idGuia'] ?>" class="botao btn-largo">Atualizar Entrega</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="aviso-vazio">Nenhuma guia atribuída no momento.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Barra de Navegação Inferior (App-like Footer) -->
<nav class="bottom-nav">
    <button class="nav-tab ativo" id="tabDisponiveis" onclick="mudarAbaMotorista('disponiveis')">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
        </svg>
        <span>Disponíveis</span>
    </button>
    <button class="nav-tab" id="tabEntregues" onclick="mudarAbaMotorista('entregues')">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>Entregues</span>
    </button>
</nav>

<script>
    let abaAtual = 'disponiveis'; // 'disponiveis' ou 'entregues'

    function mudarAbaMotorista(aba) {
        abaAtual = aba;
        
        // Atualiza estilo dos botões do rodapé
        document.getElementById('tabDisponiveis').classList.remove('ativo');
        document.getElementById('tabEntregues').classList.remove('ativo');
        
        if (aba === 'disponiveis') {
            document.getElementById('tabDisponiveis').classList.add('ativo');
        } else {
            document.getElementById('tabEntregues').classList.add('ativo');
        }
        
        filtrarMotorista(); // Reaplica o filtro com a nova aba
    }

    function filtrarMotorista() {
        let termoBusca = document.getElementById('buscaMotorista').value.toLowerCase();
        let cards = document.querySelectorAll('.card-guia');

        cards.forEach(card => {
            let status = parseInt(card.getAttribute('data-status'));
            let textoBusca = card.getAttribute('data-busca');
            let mostrar = true;

            // Filtro da Aba (Entregue = 4)
            if (abaAtual === 'disponiveis' && status === 4) mostrar = false;
            if (abaAtual === 'entregues' && status !== 4) mostrar = false;

            // Filtro da Barra de Pesquisa
            if (termoBusca !== '' && textoBusca.indexOf(termoBusca) === -1) mostrar = false;

            // Aplica a exibição
            card.style.display = mostrar ? 'block' : 'none';
        });
    }

    // Executa ao carregar para mostrar apenas as disponíveis
    document.addEventListener("DOMContentLoaded", function() {
        filtrarMotorista();
    });
</script>

<?php require 'src/views/footer.php'; ?>
