<?php 

    class DBManager{

        private static string $host = "";
        private static string  $database = "";
        private static string $username = "";
        private static string $password = "";

        private static function connectToDB(){

            $conn = new mysqli(DBManager::$host, DBManager::$username, DBManager::$password, DBManager::$database);

            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }

            return $conn;
        }

        private static function setUpDB(){

            $conn = DBManager::connectToDB();
            $query = 
            "CREATE TABLE IF NOT EXISTS users (
                id INT(6) NOT NULL AUTO_INCREMENT,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            );";

            $query2 = "CREATE TABLE tests (
                id INT NOT NULL AUTO_INCREMENT,
                title VARCHAR(100) NOT NULL,
                content JSON NOT NULL,
                user_id INT,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );";

            if ($conn->query($query2) === TRUE)
            {
                echo "Table has been created.";
            }
            else
            {
                echo "Erorr" . $conn->error;
            }

            if ($conn->query($query) === TRUE)
            {
                echo "Table has been created.";
            }
            else
            {
                echo "Erorr" . $conn->error;
            }

            $conn->close();
        }

        public static function createUser($fullname, $password, $confirm_password)
        {
            $db = DBManager::connectToDB();
            
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $error = '';

        if($query = $db->prepare("SELECT * FROM users WHERE username = ?")) {
            $query->bind_param('s', $fullname);
            $query->execute();
            $query->store_result();
            if ($query->num_rows > 0) {
                $error .= '<p class="error">The login is already registered!</p>';
            } else {
                if (strlen($password ) < 6) {
                    $error .= '<p class="error">Password must have atleast 6 characters.</p>';
                }

                if (empty($confirm_password)) {
                    $error .= '<p class="error">Please enter confirm password.</p>';
                } else {
                    if (empty($error) && ($password != $confirm_password)) {
                        $error .= '<p class="error">Password did not match.</p>';
                    }
                }
                if (empty($error) ) {
                    $insertQuery = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
                    $insertQuery->bind_param("ss", $fullname, $password_hash);
                    $result = $insertQuery->execute();
                    if ($result) {
                        return TRUE;
                    } else {
                        $error .= '<p class="error">Something went wrong!</p>';
                    }
                    $insertQuery->close();
                }
            }
        }
        $query->close();
        mysqli_close($db);
            
        return $error;
            
        }

        public static function validateUser($fullname, $password)
        {

            $db = DBManager::connectToDB();
            $error = '';

            if (empty($fullname)) {
                $error .= '<p class="error">Please enter fullname$fullname.</p>';
            }
        
            // validate if password is empty
            if (empty($password)) {
                $error .= '<p class="error">Please enter your password.</p>';
            }
        
            if (empty($error)) {
                if($query = $db->prepare("SELECT * FROM users WHERE username = ?")) {
                    $query->bind_param('s', $fullname);
                    $query->execute();
                    $result = $query->get_result();
                    $row = $result->fetch_assoc();
                    if ($row) {
                        if (password_verify($password, $row['password'])) {
                            $_SESSION["userid"] = $row['id'];
                            $_SESSION["user"] = $row['username'];
                            return TRUE;
                        } else {
                            $error .= '<p class="error">The password is not valid.</p>';
                        }
                    } else {
                        $error .= '<p class="error">No User exist with this login.</p>';
                    }
                }
                $query->close();
            }
            mysqli_close($db);
            return $error;
        }

        public static function showTests ($begin, $id)
        {
            $db = DBManager::connectToDB();
            $begin *= 9;
            $query = 'SELECT * FROM tests 
                        WHERE user_id IN (?, ?) LIMIT ?, ?;';
            $result = $db->execute_query($query,[ 0, $id, $begin, $begin + 9]);
            $ans = array();
            foreach ($result as $row) {
                $temp = array($row['title'], $row['discription'], $row['id']);
                array_push($ans,$temp);
            }
            return $ans;
        }


        public static function createTest($name, $description, $dependencies, $userid)
        {
            $error = '';
            $db = DBManager::connectToDB();
            if($query = $db->prepare("SELECT title, user_id FROM tests WHERE title = ? AND user_id = ?")) {
            $query->bind_param('ss', $name, $userid);
            $query->execute();
            $query->store_result();
            if ($query->num_rows > 0) {
                $error .= 'Test with this name is already exist. ';
            } else {
                if (empty($error)) {
                    $insertQuery = $db->prepare("INSERT INTO tests (title, discription, content, user_id) VALUES (?, ?, ?, ?);");
                    $insertQuery->bind_param("ssss", $name, $description, $dependencies, $userid);
                    $result = $insertQuery->execute();
                    if ($result) {
                        return TRUE;
                    } else {
                        $error .= 'Something went wrong!';
                    }
                    $insertQuery->close();
                }
            }
        }
        $query->close();
        $db->close();
        return $error;
        }

    public static function getTest ($id)
        {
            $db = DBManager::connectToDB();
            $query = 'SELECT * FROM tests 
                        WHERE id = ?';
            $result = $db->execute_query($query, [$id]);
            if($result->num_rows == 0)
            {
                return FALSE;
            }
            $ans = json_decode($result->fetch_row()[3]);
            
            return $ans;
        }
    }
?>