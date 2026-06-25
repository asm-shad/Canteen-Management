
<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	  spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });
	
	$db = new cls_dbconfig();
	
	$cls_message = new cls_meassage();
	
$supplier_code   = htmlspecialchars($_POST['supplier_code'], ENT_QUOTES, 'UTF-8');
$description     = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
$shortDescription = htmlspecialchars($_POST['short_description'], ENT_QUOTES, 'UTF-8');
$address         = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
$origin          = htmlspecialchars($_POST['origin'], ENT_QUOTES, 'UTF-8');
$contact_person  = htmlspecialchars($_POST['contact_person'], ENT_QUOTES, 'UTF-8');
$contact_no      = htmlspecialchars($_POST['contact_no'], ENT_QUOTES, 'UTF-8');
$mail            = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');

// For items_name (multiple select array), sanitize each element before imploding
// $items_name_array = $_POST['items_name'] ?? [];
// $sanitized_items = array_map(function($item) {
//     return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
// }, $items_name_array);
// $items_name      = implode(",", $sanitized_items);

$active          = htmlspecialchars($_POST['active'], ENT_QUOTES, 'UTF-8');
$remarks         = htmlspecialchars($_POST['remarks'], ENT_QUOTES, 'UTF-8');
$status          = 0;

// SAVE using class function
echo $cls_message->add_supplier(
    $supplier_code,
    $description,
    $shortDescription,
    $address,
    $origin,
    $contact_person,
    $contact_no,
    $mail,
    $active,
    $remarks,
    $status,
    $username
);

// redirect back to create_supplier.php
header("Location: create_supplier.php?success=1");
exit();

print_r($_POST);
	
?>