
<?php

    /**
     * Estabelecimento de conexao do o banco de dados
     */
    class ConexaoDB {

        // Método de conexão com o banco de dados
        // utilizando informações postas no arquivo
        // de configurações .env
        public static function dbConnect() {
            require_once 'Configurar.php';
            $banco_config = Configurar::getConfigBancoPrincipal();
            $ip_dataBase = $banco_config['ip'];
            $user_dataBase = $banco_config['user_dataBase'];
            $pass_dataBase = $banco_config['pass_dataBase'];
            $nameDB_dataBase = $banco_config['nameDB_dataBase'];

            $connect = mysqli_connect($ip_dataBase, $user_dataBase, $pass_dataBase, $nameDB_dataBase);
            if (!$connect) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Não foi possível conectar ao MySQL;" . mysqli_connect_errno() . "; " . mysqli_connect_error() . ";";
                header($msg);
            }
            return $connect;
        }

        //

        // Método para desconectar do banco de dados
        public static function dbDisconect($connect) {
            mysqli_close($connect);
        }

    }

?>
