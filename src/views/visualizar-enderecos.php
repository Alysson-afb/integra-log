<?php
    $tituloPagina = 'Visualizar Endereços';
    $botaoNovoTexto = '+ Novo Endereço';
    $botaoNovoLink = '/projetos-php/integra-log/cadastrar-endereco';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Endereços</h2>

    <table class="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Logradouro</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>CEP</th>
                <th>Kg Consumo (R$)</th>
                <th>Kg Permanente (R$)</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enderecos)) : ?>
                <?php foreach ($enderecos as $endereco) : ?>
                    <tr>
                        <td><?= htmlspecialchars($endereco['nomeEndereco']) ?></td>
                        <td><?= htmlspecialchars($endereco['logradouroEndereco']) ?></td>
                        <td><?= htmlspecialchars($endereco['bairroEndereco']) ?></td>
                        <td><?= htmlspecialchars($endereco['cidadeEndereco']) ?></td>
                        <td><?= htmlspecialchars($endereco['estadoEndereco']) ?></td>
                        <td><?= htmlspecialchars($endereco['cepEndereco']) ?></td>
                        <td><?= number_format((float) ($endereco['valorConsumo'] ?? 0), 2, ',', '.') ?></td>
                        <td><?= number_format((float) ($endereco['valorPermanente'] ?? 0), 2, ',', '.') ?></td>
                        <td><a href="/projetos-php/integra-log/editar-endereco?id=<?= $endereco['idEndereco'] ?>">Editar</a></td>
                        <td><a href="/projetos-php/integra-log/excluir-endereco?id=<?= $endereco['idEndereco'] ?>">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="11">Nenhum endereço cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php require 'src/views/footer.php'; ?>
