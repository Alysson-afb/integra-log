<?php
    $tituloPagina = 'Visualizar Motoristas';
    $botaoNovoTexto = '+ Novo Motorista';
    $botaoNovoLink = '/projetos-php/integra-log/cadastrar-motorista';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Motoristas</h2>

    <table class="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>CNH</th>
                <th>Telefone</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($motoristas)) : ?>
                <?php foreach ($motoristas as $motorista) : ?>
                    <tr>
                        <td><?= htmlspecialchars($motorista['nomeMotorista']) ?></td>
                        <td><?= htmlspecialchars($motorista['emailMotorista']) ?></td>
                        <td><?= htmlspecialchars($motorista['cpfMotorista']) ?></td>
                        <td><?= htmlspecialchars($motorista['cnhMotorista']) ?></td>
                        <td><?= htmlspecialchars($motorista['telefoneMotorista']) ?></td>
                        <td><a href="/projetos-php/integra-log/editar-motorista?id=<?= $motorista['idMotorista'] ?>">Editar</a></td>
                        <td><a href="/projetos-php/integra-log/excluir-motorista?id=<?= $motorista['idMotorista'] ?>">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">Nenhum motorista cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php require 'src/views/footer.php'; ?>
