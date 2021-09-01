<?php
    include("conection.php");
    include("functions.php");

    if($_POST["operation"] == "create"){
        $image = '';
        if($_FILES["user_image"]["name"] != ''){
            $image =  uploadImage($_FILES["user_image"]);
        }

        $datetime = new DateTime();
        $now = $datetime->format("Y-m-d H:i:s");

        $stmt = $connection->prepare("INSERT INTO users (name, last_names, image, phone, email, date) VALUES (:name, :last_names, :image, :phone, :email, :date)");

        $result = $stmt->execute(
            array(
                ':name' => $_POST["name"],
                ':last_names' => $_POST["last_names"],
                ':image' => $image,
                ':phone' => $_POST["phone"],
                ':email' => $_POST["email"],
                ':date' => $now
            )
        );

        if(!empty($result)){
            echo 'Registro Creado';
        }
    }

    if($_POST["operation"] == "edit"){
        $image = '';
        if($_FILES["user_image"]["name"] != ''){
            $image =  uploadImage($_FILES["user_image"]);
        } else {
            $image = $_POST['user_image_hidden'];
        }

        $datetime = new DateTime();
        $now = $datetime->format("Y-m-d H:i:s");

        $stmt = $connection->prepare("UPDATE users SET name = :name, last_names = :last_names, image = :image, phone = :phone, email = :email, date = :date WHERE id = :id");

        $result = $stmt->execute(
            array(
                ':name' => $_POST["name"],
                ':last_names' => $_POST["last_names"],
                ':phone' => $_POST["phone"],
                ':email' => $_POST["email"],
                ':image' => $image,
                'id' => $_POST["id_user"],
                ':date' => $now
            )
        );

        if(!empty($result)){
            echo 'Registro Creado';
        }
    }
?>