<?php

class UsuarioController {

    public static function login(): void {
        if (isset($_SESSION['idUsuario'])) {
            // Se já estiver logado, redireciona conforme o cargo
            if ($_SESSION['cargoUsuario'] == 3) {
                header('Location: /projetos-php/integra-log/portal-motorista');
            } else {
                header('Location: /projetos-php/integra-log/home');
            }
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'src/models/UsuarioModel.php';
            $model = new UsuarioModel();
            $email = $_POST['containerEmail'];
            $senha = $_POST['containerSenha'];
            $lembrarEmail = isset($_POST['containerLembrarEmail']);

            $usuario = $model->verificarLogin($email, $senha);

            if ($usuario) {
                // troca o id da sessao no momento do login (evita session fixation)
                session_regenerate_id(true);
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
                $_SESSION['cargoUsuario'] = $usuario['cargoUsuario'];
                
                // Salva no $_SESSION também o email para podermos filtrar as guias dele depois
                $_SESSION['emailUsuario'] = $usuario['emailUsuario'];

                // guarda apenas o e-mail no navegador, por 30 dias, para preencher o campo depois.
                if ($lembrarEmail) {
                    setcookie('emailLembrado', $email, [
                        'expires'  => time() + (30 * 24 * 60 * 60),
                        'path'     => '/projetos-php/integra-log/',
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                } else {
                    setcookie('emailLembrado', '', [
                        'expires' => time() - 3600,
                        'path'    => '/projetos-php/integra-log/'
                    ]);
                }

                // Redirecionamento baseado no cargo do usuário que acabou de logar
                if ($usuario['cargoUsuario'] == 3) {
                    header('Location: /projetos-php/integra-log/portal-motorista');
                } else {
                    header('Location: /projetos-php/integra-log/home');
                }
                exit();
            }
            $erro = 'E-mail ou senha inválidos.';
        }
        $emailLembrado = $_COOKIE['emailLembrado'] ?? '';
        require 'src/views/login.php';
    }

    public static function logout(): void {
        session_destroy();
        header('Location: /projetos-php/integra-log/login');
        exit();
    }

    public static function home(): void {
        $nomeUsuario = $_SESSION['nomeUsuario'];
        $cargoUsuario = $_SESSION['cargoUsuario'];
        require 'src/views/home.php';
    }

    public static function getUsuarioById($id): array {
        require_once 'src/models/UsuarioModel.php';
        $model = new UsuarioModel();
        return $model->getUsuarioById($id);
    }

    public static function listarUsuarios(): void {
        require_once 'src/models/UsuarioModel.php';
        $model = new UsuarioModel();
        $usuarios = $model->listarUsuarios();
        require 'src/views/visualizar-usuarios.php';
    }

    public static function cadastrarUsuario(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'src/models/UsuarioModel.php';
            $model = new UsuarioModel();

            $nome = $_POST['containerNome'];
            $email = $_POST['containerEmail'];
            $senha = $_POST['containerSenha'];
            $cargo = $_POST['containerCargo'];

            if ($model->existeEmailUsuario($email)) {
                echo "Já existe um usuário cadastrado com esse e-mail.";
                return;
            }

            if ($model->cadastrarUsuario($nome, $email, $senha, $cargo)) {
                header('Location: /projetos-php/integra-log/home');
                exit();
            } else {
                echo "Erro ao cadastrar usuário.";
            }
            return;
        }

        require 'src/views/cadastrar-usuario.php';
    }

    public static function editarUsuario($id): void {
        require_once 'src/models/UsuarioModel.php';
        $model = new UsuarioModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['containerNome'];
            $email = $_POST['containerEmail'];
            $senha = $_POST['containerSenha'];
            $cargo = $_POST['containerCargo'];

            if ($model->existeEmailUsuario($email, $id)) {
                echo "Já existe um usuário cadastrado com esse e-mail.";
                return;
            }

            if ($model->editarUsuario($id, $nome, $email, $cargo, $senha)) {
                header('Location: /projetos-php/integra-log/visualizar-usuarios');
                exit();
            } else {
                echo "Erro ao atualizar usuário.";
            }
            return;
        }

        $usuario = $model->getUsuarioById($id);
        require 'src/views/editar-usuario.php';
    }

    public static function excluirUsuario($id): void {
        require_once 'src/models/UsuarioModel.php';
        $model = new UsuarioModel();

        if ($model->excluirUsuario($id)) {
            header('Location: /projetos-php/integra-log/visualizar-usuarios');
            exit();
        } else {
            echo "Erro ao excluir usuário.";
        }
    }

}
