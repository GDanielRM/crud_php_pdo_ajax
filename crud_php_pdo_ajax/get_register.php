<?php
    include("conection.php");
    include("functions.php");

    // print_r($_POST); exit;
    if(isset($_POST['id_user'])){
        $return = array();
        $stmt = $connection->prepare("SELECT * FROM users WHERE id = '" . $_POST['id_user'] . "' LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row){
            $return['name'] = $row['name'];
            $return['lastNames'] = $row['last_names'];
            $return['phone'] = $row['phone'];
            $return['email'] = $row['email'];
            if($row['image'] != ''){
                $return['userImage'] = '<img src="img/' . $row['image'] . '" class="img-thumbnail" width="100" height="50"/><input type="hidden" name="user_image_hidden" value="' . $row['image'] . '">';
            } else {
                $return['userImage'] = '<input type="hidden" name="user_image_hidden" value="' . $row['image'] . '">';
            }
        }

        // print_r($return); exit;

        echo json_encode($return);
    }
?>