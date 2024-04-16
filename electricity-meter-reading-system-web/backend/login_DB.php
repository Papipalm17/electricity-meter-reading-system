<?php

require_once '../DB/connect.php';
session_start();

$errors = array();


if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        $_SESSION['error'] = "username required";
    } else if (empty($password)) {
        $_SESSION['error'] = "password required";
    } else if ($username and $password and (count($errors) == 0)) {
        try {
            $stmt = $db->prepare("SELECT * FROM tb_user WHERE trim(user_username)=:username AND trim(user_password)=:password");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $db_id = $row['user_id'];
                $db_username = $row['user_username'];
                $db_password = $row['user_password'];
                $dbrole = $row['role_id'];
            }
            if ($username != null and $password != null) {
                if ($stmt->rowCount() > 0) {
                        switch ($dbrole) {
                            case 1:
                                $_SESSION['success'] = "User successfully";
                                $user = $db->prepare("SELECT * FROM tb_user WHERE user_id = $db_id");
                                $user->execute();
                                while ($row = $user->fetch(PDO::FETCH_BOTH)) {
                                    $_SESSION['login'] = 1;
                                    $_SESSION['user_login_id'] = $row[0];
                                    $_SESSION['user_login'] = $row['user_id'];
                                    $_SESSION['meter'] = $row['user_meter_id'];
                                    $_SESSION['pea'] = $row['user_pea_id'];
                                    $_SESSION['firstname'] = $row['user_first_name'];
                                    $_SESSION['lastname'] = $row['user_last_name'];
                                    $_SESSION['email'] = $row['user_email'];
                                    $_SESSION['phone'] = $row['user_phone'];
                                    $_SESSION['role'] = $row['role_id'];
                                }
                                header("location: ../frontend/User/Home.php");
                                break;

                            case 2:
                                $_SESSION['success'] = "Admin successfully";
                                $admin = $db->prepare("SELECT * FROM tb_user WHERE user_id = $db_id");
                                $admin->execute();
                                while ($row = $admin->fetch(PDO::FETCH_BOTH)) {
                                    $_SESSION['login'] = 1;
                                    $_SESSION['user_login_id'] = $row[0];
                                    $_SESSION['user_login'] = $row['user_id'];
                                    $_SESSION['meter'] = $row['user_meter_id'];
                                    $_SESSION['pea'] = $row['user_pea_id'];
                                    $_SESSION['firstname'] = $row['user_first_name'];
                                    $_SESSION['lastname'] = $row['user_last_name'];
                                    $_SESSION['email'] = $row['user_email'];
                                    $_SESSION['phone'] = $row['user_phone'];
                                    $_SESSION['role'] = $row['role_id'];
                                }
                                header("location: ../frontend/Admin/HomeAdmin.php");
                                break;

                            default:
                                $_SESSION['error'] = "Wrong username or password";
                                header("location: ../frontend/Login.php");
                        }
                    
                }else{
                    $_SESSION['error'] = "Wrong username or password";
                    header("location: ../frontend/Login.php");
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
} else {
    header("location: ./Login.php");
}
