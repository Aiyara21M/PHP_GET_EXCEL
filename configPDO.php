<?
	ini_set('display_errors', 1);
	error_reporting(~0);

	//WIN-NCQCVCS7DQ7
    $serverName = "localhost";
    $userName = "sa";
    //$userPassword = "sysXXX1234";
	$userPassword = "sysXXX1234";
    $dbName = "hnimage";

    $conn = new PDO("sqlsrv:server=$serverName ; Database = $dbName", $userName, $userPassword);
	$conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);

   


?>
