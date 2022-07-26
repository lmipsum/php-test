<?php
session_start();
header('Location: /');
define('ACTION', TRUE);

require( "../config/config.php" );

if ( !empty( $_POST["db_a"] ) ) {
	$a_value = $_POST["db_a"];
}
if ( !empty( $_POST["db_b"] ) && filter_var($_POST["db_b"], FILTER_VALIDATE_INT) ) {
	$b_value = intval($_POST["db_b"]);
}
if ( !empty( $_POST["db_c"] ) ) {
	$c_value = $_POST["db_c"];
}

$sql = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME.";charset=utf8mb4";
$dsn = [
	PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

try {
	$db_connection = new PDO($sql, DB_USER, DB_PASSWORD, $dsn);
} catch ( PDOException $error ) {
	die( "Connection failed" );
}

function insert( $table, $val ) {
	global $db_connection;

	$insert_to_db = $db_connection->prepare("INSERT INTO " . $table . " (" . $table . "_content) VALUES (:value)");

	$insert_to_db->bindParam(':value', $val);
	return $insert_to_db->execute();
}

function select( $table, $order = NULL ) {
	global $db_connection;
	if ( $order ) {
		$order = " ORDER BY " . $table . "_content " . $order;
	}
	$select_from_db = $db_connection->prepare("SELECT " . $table . "_content FROM " . $table . $order);
	$select_from_db->execute();
	return array_column($select_from_db->fetchAll(PDO::FETCH_ASSOC), $table . "_content");
}

if ( isset( $_POST['first'] ) ) {
	$_SESSION['values'] = select('a');
} else if ( isset( $_POST['second'] ) ) {
	$_SESSION['values'] = array_merge(select('a'), select('b'), select('c'));
} else if ( isset( $_POST['third'] ) ) {
	$_SESSION['values'] = array_merge(select('c'), select('b'));
} else if ( isset( $_POST['fourth'] ) ) {
	$_SESSION['values'] = select('b', "ASC");
} else if ( isset( $_POST['fifth'] ) ) {
	$_SESSION['values'] = select('b', "DESC");
}
exit();