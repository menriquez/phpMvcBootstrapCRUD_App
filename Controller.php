<?php
function __autoload($className){
	include_once("models/$className.php");	
}

$users=new User("fdb5.125mb.com","1476821_credit","22work55!","1476821_credit");

if(!isset($_POST['action'])) {
	print json_encode(0);
	return;
}

// Almost spoiled my day 11th May 2013.
if(get_magic_quotes_gpc()){
    $userParams = stripslashes($_POST['user']);
} else {
    $userParams = $_POST['user'];
}

switch($_POST['action']) {
	case 'get_users':
		print $users->getUsers();
	break;
	
	case 'add_user':
		$user = new stdClass;
		$user = json_decode($userParams );
		print $users->add($user);		
	break;
	
	case 'delete_user':
		$user = new stdClass;
		$user = json_decode($userParams );
		print $users->delete($user);		
	break;
	
	case 'update_field_data':
		$user = new stdClass;
		$user = json_decode($userParams );
		print $users->updateValue($user);	
    break;	
    case 'get_score':
        $user = new stdClass;
        $user = json_decode($userParams );
        print $users->getScore($user);    		
	break;
}

exit();
