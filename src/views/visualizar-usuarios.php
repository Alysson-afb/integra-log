<?php
    $tituloPagina = 'Visualizar Usuários';
    $botaoNovoTexto = '+ Novo Usuário';
    $botaoNovoLink = '/projetos-php/integra-log/cadastrar-usuario';
    require 'src/views/header.php';
?>
    <h2 class="titulo-pagina">Usuários</h2>

    <table class="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Cargo</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)) : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nomeUsuario']) ?></td>
                        <td><?= htmlspecialchars($usuario['emailUsuario']) ?></td>
                        <td>
                            <?php
                                $cargos = [1 => 'Administrador', 2 => 'Cliente', 3 => 'Motorista'];
                                echo htmlspecialchars($cargos[$usuario['cargoUsuario']] ?? 'Indefinido');
                            ?>
                        </td>
                        <td><a href="/projetos-php/integra-log/editar-usuario?id=<?= $usuario['idUsuario'] ?>">Editar</a></td>
                        <td><a href="/projetos-php/integra-log/excluir-usuario?id=<?= $usuario['idUsuario'] ?>">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">Nenhum usuário cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php require 'src/views/footer.php'; ?>
