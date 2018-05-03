<!--
  Last Modified: Spring 2018
  Function: Exports Excel file of users and their info
  Change Log: Added Page
-->

<?php

    include_once '../sql_connector.php';

    $result = $mysqli->query("SELECT UID, first_name, last_name, email, level, gender, address, city, state, zip, progress FROM user");

    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=\"user.csv\"");
    header("Content-Transfer-Encoding: binary");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);

    $output = fopen('php://output', 'w');

    fputcsv($output, array('UID','first_name','last_name','email','level','gender','address','city','state','zip','progress'));

    while ($row = mysqli_fetch_assoc($result))
    {
        fputcsv($output, $row);
    }

    fclose($output);
    mysqli_free_result($result);
?>
