<?php
    // Objeto para alimentar página
    class Dashboard {
        public $data_inicio;
        public $data_fim;
        public $numero_vendas;
        public $total_vendas;

        public function __get($attr) {
            return $this->$attr;
        }

        public function __set($attr, $value) {
            $this->$attr = $value;
            return $this;
        }
    }

    // objeto para conexão com DB
    class Conexao {
        private $host = 'localhost';
        private $db_name = 'dashboard';
        private $user = 'root';
        private $pass = '';

        public function conectar() {
            try {
                $conexao = new PDO(
                    "mysql:host=$this->host;dbname=$this->db_name",
                    "$this->user",
                    "$this->pass",
                );

                // Indicando a codificação de caracteres
                $conexao->exec('set charset utf8');
                return $conexao;

            } catch(PDOException $e) {
                echo '<p>' . $e->getMessage() . '</p>';
            }
        }
    }

    // objeto para manipulção | model
    class Db {
        private $conexao;
        private $dashboard;

        public function __construct(Conexao $conexao, Dashboard $dashboard) {
            $this->conexao = $conexao->conectar();
            $this->dashboard = $dashboard;
        }
    }

    // instancias
    $dashboard = new Dashboard();
    $conexao = new Conexao();
    $db = new Db($conexao, $dashboard);
    
?>