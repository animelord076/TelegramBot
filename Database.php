
<?php
    class Database {
        private static $instance = null;
        private $pdo;
        private $logFile = 'database.log';

        private function __construct() {
            $config = require 'config.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
            $this->initializeLogFile();
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        private function initializeLogFile() {
            if (!file_exists($this->logFile)) {
                file_put_contents($this->logFile, "Database Log File Created\n", FILE_APPEND);
            }
        }

        private function log($message) {
            $timestamp = date('Y-m-d H:i:s');
            file_put_contents($this->logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
        }

        public function select($table, $conditions = [], $params = []) {
            $sql = "SELECT * FROM $table";
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->log("Executed SELECT query: $sql with params: " . json_encode($params));
            return $stmt->fetchAll();
        }

        public function insertIfNotExists($table, $data, $uniqueColumn) {  
            // بررسی وجود رکورد  
            $conditions = "$uniqueColumn = :uniqueValue";  
            $params = [':uniqueValue' => $data[$uniqueColumn]];  
            $existingRecord = $this->select($table, [$conditions], $params);  
        
            if (empty($existingRecord)) {  
                $columns = implode(", ", array_keys($data));  
                $placeholders = ":" . implode(", :", array_keys($data));  
                $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";  
                
                $stmt = $this->pdo->prepare($sql);  
                
                try {  
                    $result = $stmt->execute($data);  
                    $this->log("Executed INSERT query: $sql with data: " . json_encode($data));  
                    return $result;  
                } catch (PDOException $e) {  
                    $this->log("Error in INSERT query: " . $e->getMessage());  
                    return false; // یا می‌توانید throw کنید  
                }  
            } else {  
                $this->log("Record already exists for $uniqueColumn: " . json_encode($data));  
                return false; // یا شما می‌توانید true برگردانید  
            }  
        }

        public function update($table, $data, $conditions) {
            $set = "";
            foreach ($data as $column => $value) {
                $set .= "$column = :$column, ";
            }
            $set = rtrim($set, ", ");
            $sql = "UPDATE $table SET $set WHERE " . implode(' AND ', $conditions);
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($data);
            $this->log("Executed UPDATE query: $sql with data: " . json_encode($data));
            return $result;
        }

        public function delete($table, $conditions) {
            $sql = "DELETE FROM $table WHERE " . implode(' AND ', $conditions);
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute();
            $this->log("Executed DELETE query: $sql");
            return $result;
        }
    }

    // // مثال استفاده از کلاس
    // $db = Database::getInstance();
    // // اضافه کردن داده اگر وجود نداشته باشد
    // $data = ['channel_id' => '123', 'column2' => 'value2'];
    // $db->insertIfNotExists('channels', $data, 'channel_id');
    ?>
