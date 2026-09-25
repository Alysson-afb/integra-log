<?php

require_once 'src/config/Auth.php';
require_once 'src/controllers/UsuarioController.php';
require_once 'src/controllers/EnderecoController.php';
require_once 'src/controllers/MotoristaController.php';
require_once 'src/controllers/GuiaController.php';

Auth::iniciar();

$requisicao = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requisicao = rtrim($requisicao, '/');

switch ($requisicao) {

    //Usuarios
    case '/projetos-php/integra-log/login':
        UsuarioController::login();
        break;

    case '/projetos-php/integra-log/logout':
        UsuarioController::logout();
        break;

    case '/projetos-php/integra-log/home':
        Auth::exigirLogin();
        UsuarioController::home();
        break;

    case '/projetos-php/integra-log/visualizar-usuarios':
        Auth::exigirAdmin();
        UsuarioController::listarUsuarios();
        break;

    case '/projetos-php/integra-log/cadastrar-usuario':
        Auth::exigirAdmin();
        UsuarioController::cadastrarUsuario();
        break;

    case '/projetos-php/integra-log/editar-usuario':
        Auth::exigirAdmin();
        UsuarioController::editarUsuario($_GET['id']);
        break;

    case '/projetos-php/integra-log/excluir-usuario':
        Auth::exigirAdmin();
        UsuarioController::excluirUsuario($_GET['id']);
        break;


    //Guias
    case '/projetos-php/integra-log/visualizar-guias':
        Auth::exigirAdminOuCliente();
        GuiaController::listarGuias();
        break;

    case '/projetos-php/integra-log/cadastrar-guia':
        Auth::exigirAdmin();
        GuiaController::cadastrarGuia();
        break;

    case '/projetos-php/integra-log/editar-guia':
        Auth::exigirAdmin();
        GuiaController::editarGuia($_GET['id']);
        break;

    case '/projetos-php/integra-log/historico-guia':
        Auth::exigirAdminOuCliente();
        GuiaController::visualizarHistorico($_GET['id']);
        break;

    case '/projetos-php/integra-log/excluir-guia':
        Auth::exigirAdmin();
        GuiaController::excluirGuia($_GET['id']);
        break;
        
    case '/projetos-php/integra-log/mudar-status-guia':
        Auth::exigirAdmin();
        GuiaController::mudarStatus($_GET['id'], $_GET['status']);
        break;
        
    case '/projetos-php/integra-log/portal-motorista':
        Auth::exigirLogin();
        if ($_SESSION['cargoUsuario'] != 3) { 
            header('Location: /projetos-php/integra-log/home'); 
            exit(); 
        }
        GuiaController::portalMotorista();
        break;


    //Endereços
    case '/projetos-php/integra-log/visualizar-enderecos':
        Auth::exigirAdmin();
        EnderecoController::listarEnderecos();
        break;

    case '/projetos-php/integra-log/cadastrar-endereco':
        Auth::exigirAdmin();
        EnderecoController::cadastrarEndereco();
        break;

    case '/projetos-php/integra-log/editar-endereco':
        Auth::exigirAdmin();
        EnderecoController::editarEndereco($_GET['id']);
        break;

    case '/projetos-php/integra-log/excluir-endereco':
        Auth::exigirAdmin();
        EnderecoController::excluirEndereco($_GET['id']);
        break;


    //Motoristas
    case '/projetos-php/integra-log/visualizar-motoristas':
        Auth::exigirAdmin();
        MotoristaController::listarMotoristas();
        break;

    case '/projetos-php/integra-log/cadastrar-motorista':
        Auth::exigirAdmin();
        MotoristaController::cadastrarMotorista();
        break;

    case '/projetos-php/integra-log/editar-motorista':
        Auth::exigirAdmin();
        MotoristaController::editarMotorista($_GET['id']);
        break;

    case '/projetos-php/integra-log/excluir-motorista':
        Auth::exigirAdmin();
        MotoristaController::excluirMotorista($_GET['id']);
        break;


    //Erros
    default:
        echo "<h1>404 - Página não encontrada</h1>";
        break;

}
