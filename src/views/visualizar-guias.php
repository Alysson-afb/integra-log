<?php

    $meses = [1 => 'JANEIRO', 2 => 'FEVEREIRO', 3 => 'MARÇO', 4 => 'ABRIL', 5 => 'MAIO', 6 => 'JUNHO', 7 => 'JULHO', 8 => 'AGOSTO', 9 => 'SETEMBRO', 10 => 'OUTUBRO', 11 => 'NOVEMBRO', 12 => 'DEZEMBRO'];
    $mesAtual = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
    $anoAtual = isset($_GET['ano']) ? (int)$_GET['ano'] : (int)date('Y');

    // Lógica do botão "Voltar"
    $mesAnterior = $mesAtual - 1;
    $anoAnterior = $anoAtual;
    if ($mesAnterior < 1) { $mesAnterior = 12; $anoAnterior--; }

    // Lógica do botão "Avançar"
    $mesSeguinte = $mesAtual + 1;
    $anoSeguinte = $anoAtual;
    if ($mesSeguinte > 12) { $mesSeguinte = 1; $anoSeguinte++; }


    $tituloPagina = 'Guias';
    $botaoNovoTexto = '+ Nova Guia';
    $botaoNovoLink = '/projetos-php/integra-log/cadastrar-guia';

    $situacoes = [1 => 'Coletada', 2 => 'Transferência', 3 => 'Rota de entrega', 4 => 'Entregue', 5 => 'Divergente'];
    $modalidades = [1 => 'Consumo', 2 => 'Permanente'];
    $tiposTransporte = [1 => 'Remessa', 2 => 'Recolhimento'];

    // conta quantas guias e quanto em frete existe em cada situacao
    $contagem = [];
    $soma = [];

    foreach ($situacoes as $numero => $nome) {
        $contagem[$numero] = 0;
        $soma[$numero] = 0;
    }

    $totalGuias = 0;
    $totalValor = 0;
    $nomesMotoristas = [];

    foreach ($guias as $guia) {
        $contagem[$guia['statusGuia']] = $contagem[$guia['statusGuia']] + 1;
        $soma[$guia['statusGuia']] = $soma[$guia['statusGuia']] + $guia['valorFrete'];

        $totalGuias = $totalGuias + 1;
        $totalValor = $totalValor + $guia['valorFrete'];

        if (!in_array($guia['nomeMotorista'], $nomesMotoristas)) {
            $nomesMotoristas[] = $guia['nomeMotorista'];
        }
    }

    require 'src/views/header.php';
?>

    <div class="barra-filtros">
    <!-- 1. NOVO SELETOR DE MÊS -->
    <div class="seletor-mes">
        <a href="/projetos-php/integra-log/visualizar-guias?mes=<?= $mesAnterior ?>&ano=<?= $anoAnterior ?>" class="seta-mes">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        
        <span class="texto-mes"><?= $meses[$mesAtual] ?> DE <?= $anoAtual ?></span>
        
        <a href="/projetos-php/integra-log/visualizar-guias?mes=<?= $mesSeguinte ?>&ano=<?= $anoSeguinte ?>" class="seta-mes">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </a>
    </div>

    <!-- 2. BARRA DE PESQUISA (Restaurada) -->
    <input type="text" id="campoBusca" class="campo-busca" placeholder="Pesquisar nº da guia ou destino" oninput="filtrarGuias()">
    
    <!-- 3. FILTRO DE MOTORISTA (Restaurado) -->
    <select id="campoMotorista" class="campo-filtro" onchange="filtrarGuias()">
        <option value="">Todos os motoristas</option>
        <?php foreach ($nomesMotoristas as $nomeMotorista) : ?>
            <option value="<?= htmlspecialchars($nomeMotorista) ?>"><?= htmlspecialchars($nomeMotorista) ?></option>
        <?php endforeach; ?>
    </select>
    
    <!-- 4. BOTÃO ATUALIZAR (Restaurado) -->
    <a class="botao botao-claro" href="/projetos-php/integra-log/visualizar-guias">Atualizar</a>
</div>

    <div class="lista-chips">

        <a class="chip ativo" href="javascript:void(0)" onclick="selecionarStatus('todos', this)">
            <span class="chip-nome">Todas</span>
            <span class="chip-valor"><?= $totalGuias ?> | R$ <?= number_format($totalValor, 2, ',', '.') ?></span>
        </a>

        <?php foreach ($situacoes as $numero => $nome) : ?>
            <a class="chip" href="javascript:void(0)" onclick="selecionarStatus('<?= $numero ?>', this)">
                <span class="chip-nome"><?= $nome ?></span>
                <span class="chip-valor"><?= $contagem[$numero] ?> | R$ <?= number_format($soma[$numero], 2, ',', '.') ?></span>
            </a>
        <?php endforeach; ?>

    </div>
    
    <div class="lista-guias">

        <?php if (!empty($guias)) : ?>
            <?php foreach ($guias as $guia) : ?>

                <div class="linha-guia"
                     data-status="<?= $guia['statusGuia'] ?>"
                     data-motorista="<?= htmlspecialchars($guia['nomeMotorista']) ?>"
                     data-busca="<?= htmlspecialchars(strtolower($guia['numeroGuia'] . ' ' . $guia['nomeEndereco'])) ?>">

                    <div class="guia-numero">
                        <a href="/projetos-php/integra-log/historico-guia?id=<?= $guia['idGuia'] ?>"><?= htmlspecialchars($guia['numeroGuia']) ?></a>
                    </div>

                    <div class="guia-destino">
                        <?= htmlspecialchars($guia['nomeEndereco']) ?>
                    </div>

                    <div class="guia-motorista">
                        <?= htmlspecialchars($guia['nomeMotorista']) ?>
                    </div>

                    <div class="guia-data">
                        Emissão: <?= date('d/m/Y', strtotime($guia['dataEmissaoGuia'])) ?>
                        <br>
                        <?= $tiposTransporte[$guia['tipoTransporteGuia']] ?? 'Indefinido' ?>
                    </div>

                    <div class="guia-valores">
                        <span class="selo <?= $guia['modalidadeGuia'] == 2 ? 'selo-permanente' : '' ?>">
                            <?= $modalidades[$guia['modalidadeGuia']] ?? 'Indefinido' ?>
                        </span>
                        <div class="peso-valor">
                            <?= number_format($guia['pesoGuia'], 2, ',', '.') ?> Kg |
                            <strong>R$ <?= number_format($guia['valorFrete'], 2, ',', '.') ?></strong>
                        </div>
                    </div>

                    <div class="guia-botoes-status">
                        <?php if ($guia['statusGuia'] != 4 && $guia['statusGuia'] != 5) : ?>

                            <!-- 1. Coletada -->
                            <a href="/projetos-php/integra-log/mudar-status-guia?id=<?= $guia['idGuia'] ?>&status=1" 
                            class="btn-status btn-status-coletada <?= $guia['statusGuia'] == 1 ? 'ativo' : '' ?>" 
                            title="Marcar como Coletada">
                                <img src="/projetos-php/integra-log/assets/img/icons/IconeColetado.png" alt="Coletada">
                            </a>

                            <!-- 2. Transferência -->
                            <a href="/projetos-php/integra-log/mudar-status-guia?id=<?= $guia['idGuia'] ?>&status=2" 
                            class="btn-status btn-status-transferencia <?= $guia['statusGuia'] == 2 ? 'ativo' : '' ?>" 
                            title="Marcar como Transferência">
                                <img src="/projetos-php/integra-log/assets/img/icons/IconeTransferencia.png" alt="Transferência">
                            </a>

                            <!-- 3. Em Rota de entrega -->
                            <a href="/projetos-php/integra-log/mudar-status-guia?id=<?= $guia['idGuia'] ?>&status=3" 
                            class="btn-status btn-status-rota <?= $guia['statusGuia'] == 3 ? 'ativo' : '' ?>" 
                            title="Marcar como Em Rota de entrega">
                                <img src="/projetos-php/integra-log/assets/img/icons/IconeEmRota.png" alt="Em Rota de entrega">
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="guia-status">
                        <span class="situacao situacao-<?= $guia['statusGuia'] ?>">
                            <?= $situacoes[$guia['statusGuia']] ?? 'Indefinido' ?>
                        </span>
                    </div>

                    <div class="guia-acoes">
                        <?php if ($_SESSION['cargoUsuario'] == 1) : ?>
                            <!-- Ícone Editar (Lápis Azul) -->
                            <a href="/projetos-php/integra-log/editar-guia?id=<?= $guia['idGuia'] ?>" title="Editar guia" class="acao-icone">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#1d6ef2" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                </svg>
                            </a>

                            <!-- Ícone Excluir (Lixeira Vermelha) -->
                            <a href="/projetos-php/integra-log/excluir-guia?id=<?= $guia['idGuia'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta guia?');" title="Excluir guia" class="acao-icone">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    <line x1="10" y1="11" x2="10" y2="17"/>
                                    <line x1="14" y1="11" x2="14" y2="17"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php endif; ?>

        <div class="aviso-vazio" id="avisoVazio" <?= !empty($guias) ? 'style="display: none;"' : '' ?>>
            Nenhuma guia encontrada.
        </div>

    </div>

    <script src="/projetos-php/integra-log/assets/js/filtro-guias.js"></script>

<?php require 'src/views/footer.php'; ?>
