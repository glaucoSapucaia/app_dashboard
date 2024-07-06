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

        // numero vendas data
        public function getNumVendas() {
            $query = '
                SELECT
                    count(*) as num_vendas
                FROM
                    tb_vendas
                WHERE
                    data_venda BETWEEN :data_inicio and :data_fim
            ';

            $stmt = $this->conexao->prepare($query);

            // Recuperando valores do dashboard
            $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
            $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));

            $stmt->execute();

            // Retornamos um objeto, mas focamos apenas em seu valor
            return $stmt->fetch(PDO::FETCH_OBJ)->num_vendas;
        }

        // total vendas data
        public function getTotalVendas() {
            $query = '
                SELECT
                    SUM(total) as total_vendas
                FROM
                    tb_vendas
                WHERE
                    data_venda BETWEEN :data_inicio and :data_fim
            ';

            $stmt = $this->conexao->prepare($query);

            // Recuperando valores do dashboard
            $stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
            $stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));

            $stmt->execute();

            // Retornamos um objeto, mas focamos apenas em seu valor
            return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;
        }
    }

    // instancias
    $dashboard = new Dashboard();
    $conexao = new Conexao();

    // resgatando competencia do front end
    // explode() -> Usamos apra separar ano e mês a partir do caractere '-'
    $competencia = explode('-', $_GET['competencia']);
    $ano = $competencia[0];
    $mes = $competencia[1];

    // Formando janela de dias num mês
    // cal_days_in_month() -> Calcula qtd de dias num Mês
    // param 1 -> opção de calendario
    // param 2 -> mes selecionado
    // param 3 -> ano selecionado
    $dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

    $db = new Db($conexao, $dashboard);

    // Atribuindo valores do DB ao dashboard
    $dashboard->__set('data_inicio', $ano . '-' . $mes . '-01');
    $dashboard->__set('data_fim', $ano . '-' . $mes . '-' . $dias_do_mes);

    $dashboard->__set('numero_vendas', $db->getNumVendas());
    $dashboard->__set('total_vendas', $db->getTotalVendas());

    // print_r($dashboard);
    // print_r($ano . '/' . $mes . '/' . $dias_do_mes);

    // Após configurar o dataType da request AJAX, precisamo converter os dados.
    // json_encode() -> Converte dados para o tipo json
    echo json_encode($dashboard);
    
?>