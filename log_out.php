
<?php ob_start();
include 'config/header.php';
require_once('../sql_connector.php');

$_SESSION = array();
//Killing cookies Code taken from php.net
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

$sessionID = session_id();

$mysqli->query("DELETE FROM `session_users` WHERE session_id = '$sessionID'");

session_destroy();
header("location:index.php");
?>
