<?php
    include("conection.php");
    include("functions.php");

    date_default_timezone_set('America/Mazatlan');
    

    $return = array();
    $query = "SELECT * FROM users";

    if(isset($_POST["search"]["value"])){
        $query .= ' WHERE name like "%' . $_POST["search"]["value"] . '%" OR last_names like "%' . $_POST["search"]["value"] . '%"';
        // $query .= 'OR last_names like "%' . $_POST["search"]["value"] . '%"';
    }

    if(isset($_POST["order"])){
        $query .= ' ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $query .= ' ORDER BY id DESC';
    }

    if($_POST["length"] != -1){
        $query .= ' LIMIT ' . $_POST["start"] . ', ' . $_POST["length"];
    }

    $stmt = $connection->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $data = array();
    $filteredRows = $stmt->rowCount();

    foreach($result as $row){
        $image = '';
        if($row["image"] != ''){
            $image = '<img src="img/' . $row["image"] . '" class="img-thumbnail" width="50" height="50"/>';
        } else {
            $image = '';
        }

        $sub_array = array();
        $sub_array[] = $row["id"];
        $sub_array[] = $row["name"];
        $sub_array[] = $row["last_names"];
        $sub_array[] = $row["phone"];
        $sub_array[] = $row["email"];
        $sub_array[] = $image;
        $sub_array[] = $row["date"];
        $sub_array[] = '<button type"button" name="edit" id="' . $row["id"] . '" class="btn btn-primary bnt-xs edit">Edit</button>';
        $sub_array[] = '<button type"button" name="delete" id="' . $row["id"] . '" class="btn btn-danger bnt-xs delete">delete</button>';
    
        $data[] = $sub_array;
    }

    $return = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filteredRows,
        "recordsFiltered" => getAllRegisters(),
        "data" => $data
    );

    // print_r($return); exit;

    echo json_encode($return);
?>