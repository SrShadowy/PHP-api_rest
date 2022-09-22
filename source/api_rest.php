<?php

class API_REST {

    // DADOS DE INFORMAÇÃO
    private $_deleted;
    private $_type;
    private $_order_by;
    private $_offset;
    private $_limit;
    private $_message;
    private $_is_indentified;
    private $_whistleblower_name;
    private $_whistleblower_birth;
    private $_created_at;
    private $_id;

    // FUNÇÕES DE FACILITAÇÃO DE TAREFA
    private function get_message($message, $code) {

        http_response_code($code);
        echo json_encode($message); 
        die();
    }

    private function get_lastId($pdo) {

        $stmt = $pdo->prepare("SELECT * FROM registros ORDER BY id DESC limit 1");
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row[0]['id']; 
    }

    public function get_id($pdo) : int
    {
        return $this->get_lastId($pdo);
    }

    private function show_last_modify($pdo, $id) {

        $stmt = $pdo->prepare("SELECT * FROM registros WHERE id=:id");
        $stmt->bindValue(":id", $id);
        if (!$stmt->execute())
            exit();
        
        $row = $stmt->fetchAll();
        return json_encode($row);
    }


    // TIPO DE REQUEST
    function get_($pdo) {

        $this->_deleted     = $_GET['deleted'];
        $this->_type        = $_GET['type'];
        $this->_order_by    = $_GET['order_by'];
        $this->_offset      = $_GET['offset'];
        $this->_limit       = $_GET['limit'];
        $this->_id          = $_GET['id'];

        $acpt_command = false;

        $command_sql;
        if (isset($this->_deleted)) 
        {
            $command_sql .= " deleted = " . $this->_deleted;
            $acpt_command = true;
        }

        if (isset($this->_type)) 
        {
            $command_sql .= (Strlen( $command_sql) > 0) ? " AND type = '" . $this->_type . "'":  " type = '" . $this->_type. "'";
            $acpt_command = true;
        }

        if (isset($this->_id))
            $command_sql .= (Strlen( $command_sql) > 0) ? " AND id = " . $this->_id:  " type = " . $this->_id;
        
        
        if (isset($this->_order_by) && $acpt_command) 
            $command_sql .= " ORDER BY ID " . $this->_order_by; 
        
        if (isset($this->_limit) && $acpt_command) 
            $command_sql .= " LIMIT " . $this->_limit;
        
        if (isset($this->_offset) && isset($this->_limit) && $acpt_command)
            $command_sql .= " OFFSET " . $this->_offset;  

        if (strlen($command_sql) > 0) {
            $command_sql = "SELECT * FROM registros WHERE {$command_sql}";
        } else {
            $command_sql = "SELECT * FROM registros"; 
        }
     
        $stmt = $pdo->prepare($command_sql);
        if (!$stmt->execute()) {
            $this->get_message("Not Acceptable", 406); 
        }

        $data = $stmt->fetchAll();
     
        
        if (Count($data) <= 0) {
            $this->get_message("Not found", 404);
        }

        $this->get_message($data, 200);
    }

    function post_($pdo) {
        
        $this->_message             = $_POST['message'];
        $this->_type                = $_POST['type'];
        $this->_whistleblower_name  = $_POST['user'];
        $this->_whistleblower_birth = $_POST['birth'];

        if (!isset($this->_message) || !isset($this->_type )) {
            $this->get_message("No Content", 204);
        }

        if ($this->_type != "duvida" && $this->_type != "sugestao" && $this->_type != "denuncia" ){
            $this->get_message("Bad Request", 400);
        }


        $today = date("Y-m-d H:i:s");
        $declared = 0;
        if (isset($this->_whistleblower_name) && isset($this->_whistleblower_birth)) {
            $declared = 1;
        }

        $id = $this->get_lastId($pdo);
        $id = $id + 1;

        $stmt = $pdo->prepare("INSERT INTO registros (id, `type`,`message`, is_identified, whistleblower_name, whistleblower_birth, created_at, deleted) 
            VALUES ( ? ,? , ?, ?, ?, ?, ?, 0)");

        if (!$stmt->execute(array($id,  $this->_type, $this->_message, $declared, $this->_whistleblower_name, $this->_whistleblower_birth, $today))) {
            $this->get_message("Not Acceptable", 406); 
        }

        if ($stmt->rowCount() <= 0) {
            $this->get_message("Not found", 404);
        }

        $this->get_message($id, 201);
    }

    function put_($pdo) {

        $form_page;
        parse_str(file_get_contents("php://input"), $form_page);

        $this->_deleted             = $form_page['deleted'];
        $this->_message             = $form_page['message'];
        $this->_whistleblower_birth = $form_page['birth'];
        $this->_type                = $form_page['type'];
        $this->_whistleblower_name  = $form_page['user'];
        $this->_id                  = $form_page['id'];

        $today = date("Y-m-d H:i:s");
        $indentified = 0;
        if (isset($this->_whistleblower_birth) && isset($this->_whistleblower_name)) {
            $indentified = 1;
        }

        $stmt = $pdo->prepare("SELECT * FROM registros WHERE id=:id");
        $stmt->bindValue(":id", $this->_id);
        if (!$stmt->execute())
            $this->get_message("Not Acceptable", 406);
        
        $row = $stmt->fetchAll();

        if (!isset($this->_deleted)) {
            $this->_deleted = $row[0]['deleted'];
        }

        if (!isset($this->_message)) {
            $this->_message = $row[0]['message'];
        }

        if (!isset($this->_type)) {
            $this->_type = $row[0]['type'];
        }

        if (Count($row) <= 0) {
            $this->get_message("Not found", 404);
        }

        $stmt = $pdo->prepare("UPDATE registros SET `type` = :tp ,`message` = :msg , is_identified = :ii, whistleblower_name = :wn, whistleblower_birth = :wb, created_at = :c_at, deleted = :deleted WHERE id = :id");
        $stmt->bindValue(":id", $this->_id);
        $stmt->bindValue(":deleted", $this->_deleted);
        $stmt->bindValue(":c_at", $today);
        $stmt->bindValue(":wb", $this->_whistleblower_birth);
        $stmt->bindValue(":wn", $this->_whistleblower_name);
        $stmt->bindValue(":ii", $indentified);
        $stmt->bindValue(":msg",  $this->_message);
        $stmt->bindValue(":tp", $this->_type);

        if (!$stmt->execute(array($this->_type, $this->_message, $indentified, $this->_whistleblower_name, $this->_whistleblower_birth, $today, $this->_deleted, $this->_id)))
            $this->get_message("Not Acceptable", 406);

        $this->get_message($this->_id, 200);
    }

    function delete_($pdo) {

        $form_page;
        parse_str(file_get_contents("php://input"), $form_page );

        $this->_id                  = $form_page['id'];

        $stmt = $pdo->prepare("SELECT * FROM registros WHERE id=:id");
        $stmt->bindValue(":id", $this->_id);
        if (!$stmt->execute()) {
            $this->get_message("Not Acceptable", 406); //406 Not Acceptable
        }

        $row = $stmt->fetchAll();
        if ($row[0]['deleted'] == 0) {
            $this->get_message("Cannot be delete item", 401);
        }

        if (Count($row) <= 0) {
            $this->get_message("Not found", 404);
        }

        $row = $this->show_last_modify($pdo, $id);
        $stmt = $pdo->prepare("DELETE FROM registros WHERE id = :id");
        $stmt->bindValue(":id", $this->_id);
        if (!$stmt->execute()) {
            $this->get_message("Not Acceptable", 406);
        }

        $this->get_message($this->_id  , 200);
    }

    function patch_($pdo) {
        $form_page;
        parse_str(file_get_contents("php://input"), $form_page );
        $this->_id                  = $form_page['id'];

        $stmt = $pdo->prepare("SELECT * FROM registros WHERE id=:id");
        $stmt->bindValue(":id", $this->_id);

        if (!$stmt->execute()) {
            $this->get_message("Not Acceptable", 406); //406 Not Acceptable
        }

   
        $row = $stmt->fetchAll();
        if ($row[0]['deleted'] != 0) {
            $this->get_message("deleted status row is true", 200);
        }

        if (Count($row) <= 0) {
            $this->get_message("not found", 404);
        }

        $stmt = $pdo->prepare("UPDATE registros SET deleted = 1 WHERE id = :id");
        $stmt->bindValue(":id", $this->_id);
        if ($stmt->execute())
            $row = $stmt->fetchAll();

        $this->get_message($this->_id, 200);
    }

    //CONTROLADOR
    function getters_param($pdo) {

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->get_($pdo);
            return false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->post_($pdo);
            return false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $this->delete_($pdo);
            return false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            $this->put_($pdo);
            return false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
            $this->patch_($pdo);
            return false;
        }

        return true;
    }
}
