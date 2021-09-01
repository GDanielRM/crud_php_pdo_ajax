<?php
include("conection.php");
include("functions.php");

if (isset($_POST['id_user'])) {
    $image = getImageName($_POST['id_user']);

    if ($image != '') {
        $image = unlink('img/' . $image);
    }


    $stmt = $connection->prepare("DELETE FROM users WHERE id = :id");

    $result = $stmt->execute(
        array(
            'id' => $_POST["id_user"]
        )
    );

    if (!empty($result)) {
        echo 'Registro Eliminado';
    }
}
