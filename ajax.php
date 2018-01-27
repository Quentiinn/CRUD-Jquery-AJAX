<?php
/**
 * Created by PhpStorm.
 * User: quentincourvoisier
 * Date: 22/01/2018
 * Time: 14:26
 */


$bdd = new PDO('mysql:host=localhost;dbname=jquery;charset=utf8', 'root', 'quentin');



function getAll(){
    $bdd = new PDO('mysql:host=localhost;dbname=jquery;charset=utf8', 'root', 'quentin');
    $res = $bdd->query('SELECT * FROM `user`', PDO::FETCH_ASSOC)->fetchAll();
    return $res;
}



function get($id){
    $bdd = new PDO('mysql:host=localhost;dbname=jquery;charset=utf8', 'root', 'quentin');
    $res = $bdd->query('SELECT * FROM `user` WHERE id_user = '.$id, PDO::FETCH_ASSOC)->fetch();
    return $res;
}

function delete($id){
    $bdd = new PDO('mysql:host=localhost;dbname=jquery;charset=utf8', 'root', 'quentin');
    $bdd->exec("DELETE FROM user WHERE id_user = " . $id);
}


if ($_POST){
    if ($_POST['nomFonction'] == 'add'){
        //$date = date("Y-m-d", $_POST['date'] );
        $date = DateTime::createFromFormat('d/m/Y', $_POST['date']);
        $date=  $date->format('Y-m-d');
        $stmt = $bdd->prepare("INSERT INTO user (firstname, lastname , city , birthdate ) VALUES ('".$_POST['prenom']."', '".$_POST['nom']. "','" . $_POST['ville']."','".$date."')");
        $stmt->execute();
    }

    if ($_POST['nomFonction'] == "getAll"){
        $res = getAll();
        echo json_encode($res);
    }

    if ($_POST['nomFonction'] == "search"){
        $res = get($_POST['id']);
        echo json_encode($res);
    }

    if ($_POST['nomFonction'] == "delete"){
        echo "supprimer";
        delete($_POST['id']);
    }
}



?>