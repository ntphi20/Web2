<?php
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$id = NULL;

if (isset($_GET['btcsrf']) && $_SESSION["csrf_token"]) {
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        // kiểm tra uuid có trên csdl không.

        // Có: thực hiện quy trình xóa
            // kiểm tra người dùng này được quyền xóa bài post này không.
                // Có: xóa luôn bài post
                $userModel->deleteUserById($id); //Delete existing user
                // Không: Thông báo không được phép xóa

        // không: thông báo.

    } else {
        echo "Unique user id doesn't match!";
        die;
    }
} else {
    echo "Token doesn't match!";
    die;
}
header('location: list_users.php');
?>