<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
	header('Location: /');
}
session_start();
if ( !empty( $_SESSION['values'] ) ) {
	echo "<div id=\"values\"><ul>";
	foreach ( array_values($_SESSION['values']) as $value ) {
		echo "<li>" . $value . "</li>";
	}
	echo "</ul></div>";
}
session_unset();