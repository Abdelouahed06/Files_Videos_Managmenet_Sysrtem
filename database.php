<?php

    class MyDatabase {

        function __construct($host, $dbname, $username, $password) {
            try {

                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $e) {

                die("failed: " . $e->getMessage());

            }
        }

        function getNumOfRows($table_name) {
    
            $q = "SELECT COUNT(*) as count FROM $table_name";
    
            $stmt = $this->pdo->prepare($q);
            $stmt->execute();
    
            $numOfClasses = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
            echo $numOfClasses;
        }

        function getRows($table_name) {

            $startingRow = @$_GET['row'];
            $limit = @$_GET['limit'];
    
            $q = "SELECT * FROM $table_name ORDER BY time_stamp DESC LIMIT $startingRow, $limit";
    
            $stmt = $this->pdo->prepare($q);
            $stmt->execute();
    
            $rows = $stmt->fetchAll();
    
            echo json_encode($rows);
        }

        function addClassSubject($table_name, $column_name) {
            try {
                $value = @$_GET['value'];

                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $table_name WHERE $column_name = :value_to_add");
                $stmt->bindValue(':value_to_add', $value);
                $stmt->execute();

                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    // The class already exists
                    echo "-1";
                } else {
                    // The class is unique
                    $q = "INSERT INTO $table_name($column_name) VALUES(:value_to_add)";

                    $stmt = $this->pdo->prepare($q);
                    $stmt->bindParam(':value_to_add', $value);
                    $stmt->execute();
                }
                
            } catch(PDOException $e) {
                echo $e;
            }

        }

        function deleteRow($table_name, $column_name) {

            try {
                $value = @$_GET['value'];
    
                $q = "DELETE FROM $table_name WHERE $column_name = :value_to_delete";
    
                $stmt = $this->pdo->prepare($q);
                $stmt->bindParam(':value_to_delete', $value);
                $stmt->execute();
                
            } catch(PDOException $e) {
                echo $e;
            }
        }

        function updateClassSubject($table_name, $column_name) {

            try {
    
                $oldValue = @$_GET['old_value'];
                $newValue = @$_GET['new_value'];
    
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $table_name WHERE $column_name = :new_value");
                $stmt->bindValue(':new_value', $newValue);
                $stmt->execute();
    
                $count = $stmt->fetchColumn();
    
                if ($count > 0) {
                    // The class already exists
                    echo "-1";
                } else {
                    // Update the class
                    $q = "UPDATE $table_name SET $column_name = :new_value WHERE $column_name = :old_value";
    
                    $stmt = $this->pdo->prepare($q);
                    $stmt->bindParam(':new_value', $newValue);
                    $stmt->bindParam(':old_value', $oldValue);
                    $stmt->execute();
                }
                
            } catch(PDOException $e) {
                echo $e;
            }
        }

        function getAll($table_name) {

            $q = "SELECT * FROM $table_name ORDER BY time_stamp DESC";
    
            $stmt = $this->pdo->prepare($q);
            $stmt->execute();
    
            $rows = $stmt->fetchAll();
    
            echo json_encode($rows);
        }







        
    }


?>