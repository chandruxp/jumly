<?php
error_reporting(E_ALL & ~E_NOTICE);
//phpinfo();die();
require('medoo.min.php');

$db = new medoo([
    'database_type' => 'mysql',
	'database_name' => 'c9',
	'server' => '127.0.0.1',
	'username' => 'chandruxp',
	'password' => '',
	'charset' => 'utf8'
    ]);
header("Content-type: application/json");
    
switch($_POST['action']) {
    
    case 'new':
    case 'edit':
        
        if($_POST['action']=='new' )
            $diagram_id = uniqid();
        else
            $diagram_id = $_POST['diagram_id'];
            
        $db->insert('revision', [
            'diagram_id' => $diagram_id,
            'title' => $_POST['title'],
            'code' => $_POST['code']
        ]);
        
        die('{"ok":0, "diagram_id": "'.$diagram_id.'"}');
        break;
        
    case 'delete':
        
        $db->delete('revision', [
            'diagram_id' => $_POST['diagram_id']
            ]);
            
        die('{"ok":0}');
        
        break;
}

if($_GET['diagram_id']) {
    $result = $db->select("revision", "*", ['diagram_id'=>$_GET['diagram_id']]);
    echo json_encode($result);
} else {
    $result = $db->select("revision", "*");
    echo json_encode($result);
}

?>