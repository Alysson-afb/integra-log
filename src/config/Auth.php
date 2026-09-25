<?php
class Auth {
    public static function iniciar(): void {
        if (session_status() === PHP_SESSION_NONE) {

            session_set_cookie_params([
                'httponly' => true,   // o JavaScript nao consegue ler o cookie de sessao
                'samesite' => 'Lax',  // o cookie nao e enviado em requisicoes vindas de outros sites
                'secure'   => false   // trocar para true quando o sistema estiver em HTTPS
            ]);

            session_start();
        }
    }

    public static function exigirLogin(): void {
        if (!isset($_SESSION['idUsuario'])) {
            header('Location: /projetos-php/integra-log/login');
            exit();
        }
    }

    public static function exigirAdmin(): void {
        self::exigirLogin();

        if ($_SESSION['cargoUsuario'] != 1) {
            echo "Acesso negado.";
            exit();
        }
    }

    public static function exigirAdminOuCliente(): void {
        self::exigirLogin();

        if ($_SESSION['cargoUsuario'] != 1 && $_SESSION['cargoUsuario'] != 2) {
            echo "Acesso negado.";
            exit();
        }
    }
    
}
