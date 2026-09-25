<?php
    $tituloPagina = 'Histórico da Guia';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Histórico da Guia <?= htmlspecialchars($guia['numeroGuia'] ?? '') ?></h2>

    <table class="tabela">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>De</th>
                <th>Para</th>
                <th>Responsável</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($historico)) : ?>
                <?php foreach ($historico as $registro) : ?>
                    <?php $situacoes = [1 => 'Coletada', 2 => 'Transferência', 3 => 'Rota', 4 => 'Entregue', 5 => 'Divergente']; ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($registro['dataHoraMudanca'])) ?></td>
                        <td>
                            <?php
                                if ($registro['statusAnterior'] == null) {
                                    echo 'Cadastro da guia';
                                } else {
                                    echo htmlspecialchars($situacoes[$registro['statusAnterior']] ?? 'Indefinido');
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($situacoes[$registro['statusNovo']] ?? 'Indefinido') ?></td>
                        <td><?= htmlspecialchars($registro['nomeUsuario'] ?? 'Usuário removido') ?></td>
                        <td><?= htmlspecialchars($registro['observacaoHistorico'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Nenhuma movimentação registrada para esta guia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="/projetos-php/integra-log/visualizar-guias">Voltar para as guias</a>

<?php require 'src/views/footer.php'; ?>
