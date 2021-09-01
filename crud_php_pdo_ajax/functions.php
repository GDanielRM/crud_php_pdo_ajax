<?php
    function uploadImage($image)
    {
        // print_r($image); exit;
        if($image){
            $extension = explode('.', $image['name']);
            $newName = rand() . '.' . $extension[1];
            $location = 'img/' . $newName;
            move_uploaded_file($image['tmp_name'], $location);
            
            return $newName;
        }
    }

    function getImageName($idUser)
    {
        include('conection.php');

        $stmt = $connection->prepare("SELECT image FROM users WHERE id = '$idUser'");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $file){
            return $file["image"];
        }
    }

    function getAllRegisters()
    {
        include('conection.php');

        $stmt = $connection->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $stmt->rowCount();
    }
?>