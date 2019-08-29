<?php



## 名前空間を指定(同一関数呼び出し可能)
namespace MyApp;

class Todo {
    private $_db;

    public function __construct() {
        $this->_createToken();

        try {
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    private function _createToken() {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }

    public function getAll() {
        $stmt = $this->_db->query("select * from user_table");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getParticipant($ATT) {
        $inClause = substr(str_repeat(',?', count($ATT)), 1);
        $sql = sprintf('select * from user_table where id IN (%s)', $inClause);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($ATT);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public function post() {
        $this->_validateToken();
        if (!isset($_POST['mode'])) {
            throw new \Exception('mode not set!');
        }
        switch ($_POST['mode']) {
            case 'update':
                return $this->_update();
            case 'create':
                return $this->_create();
            case 'delete':
                return $this->_delete();
        }
    }

    private function _validateToken() {
        if (
            !isset($_SESSION['token']) || 
            !isset($_POST['token']) ||
            $_SESSION['token'] !== $_POST['token']
        ){
            throw new \Exception('oinvalid token!');
        }
    }

    private function _update() {
        if (!isset($_POST['id'])) {
            throw new \Exception('[update] id not set!');
        }
        $this->_db->beginTransaction();
        $sql = sprintf("update user_table set name = '%s', gender = %d, birthday = '%s' where id = %d", $_POST['name'],$_POST['gender'],$_POST['birthday'],$_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $sql = sprintf("select gender from user_table where id = %d", $_POST['id']);
        $stmt = $this->_db->query($sql);
        $gender = $stmt->fetchColumn();

        $this->_db->commit();

        return [
            'gender' => $gender
        ];
    }

    private function _create() {
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            throw new \Exception('[create] name not set!');
        }
        $sql = "insert into user_table (name,gender,birthday) values (:name,:gender,:birthday)";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(array(':name' => $_POST['name'],':gender' => $_POST['gender'],':birthday' => $_POST['birthday']));
        // $stmt->execute([':name' => $_POST['name']]);

        return [
            'id' => $this->_db->lastInsertId()
        ];
    }

    private function _delete() {
        if (!isset($_POST['id'])) {
            throw new \Exception('[delete] id not set!');
        }
        $sql = sprintf("delete from user_table where id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        return [];
    }
}
