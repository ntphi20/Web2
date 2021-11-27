<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel {
    public $key = "ksghd09kjjhih";

    public function findUserById($newid) {
        $sql = 'SELECT * FROM users WHERE id = '.$newid;
        $user = $this->select($sql);

        return $user;
    }

    public function findUser($keyword) {
        $sql = 'SELECT * FROM users WHERE user_name LIKE %'.$keyword.'%'. ' OR user_email LIKE %'.$keyword.'%';
        $user = $this->select($sql);

        return $user;
    }

    public function auth($userName, $password) {
        $md5Password = $password;
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$md5Password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($newid) {
        $sql = 'DELETE FROM users WHERE id = '.$newid;
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input) {

        $name = htmlspecialchars($input['name']);
        $fullname = htmlspecialchars($input['fullname']);
        $password = md5(htmlspecialchars($input['password']));
        $email = htmlspecialchars($input['email']);
        $type = htmlspecialchars($input['type']);
        $version = $input['version'] + 1;
        $id = htmlspecialchars($input['id']);
        $uuid = md5($name . $fullname . $email . $type . $password) . rand(0, 1);

        $sql = 'UPDATE users SET 
                name = "' . $input['name'] .'", 
                 fullname = "' . $input['fullname'] .'",
                 email = "' . $input['email'] .'",
                 type = "' . $input['type'] .'",
                 password="'. md5($input['password']) .'"
                WHERE id = ' . $input['id'];
        $user = $this->update($sql);

        return $user;
    }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {

        $name = htmlspecialchars($input['name']);
        $fullname = htmlspecialchars($input['fullname']);
        $email = htmlspecialchars($input['email']);
        $type = htmlspecialchars($input['type']);
        $password = md5($input['password']);
        $uuid = md5($name . $fullname . $email . $type . $password) . rand(0, 1);

        $sql = "INSERT INTO `app_web1`.`users` (`name`, `fullname`, `email`, `type`, `password`) VALUES (" .
                "'" . $input['name'] . "','".$input['fullname']."', '".$input['email']."','".$input['type']."', '".$input['password']."')";

        $user = $this->insert($sql);

        return $user;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM users WHERE name LIKE "%' . $params['keyword'] .'%"';
        } else {
            $sql = 'SELECT * FROM users';
        }

        $users = $this->select($sql);

        return $users;
    }

    public function sumb($a, $b)
    {
        return $a + $b;
    }

    public static function GenerateToken() {
        $token = base64_encode(md5(time()) . rand());
        return $token;
      }
  
      public static function CompareTokens($field_token, $session_token) {
        if ($field_token === $session_token) {
          return true;
          die();
        }
        return false;
      }
}