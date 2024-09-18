<?php
require "configPDO.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
$StartDateArr = explode("/", $_POST["StartDate"]);
$EndDateArr = explode("/", $_POST["EndDate"]);

$setStartDate = $StartDateArr[2] . "-" . $StartDateArr[1] . "-" . $StartDateArr[0];
$setEndDateArr = $EndDateArr[2] . "-" . $EndDateArr[1] . "-" . $EndDateArr[0];

if($_POST["data"]=='P1'){
    $strSQL = "SELECT * FROM QScanOCard ";
    $strSQL .= "WHERE  (QScDate >= '" . $setStartDate . "' ";
    $strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate,QScVN ASC;";
}
else if($_POST["data"]=='P2'){
    $strSQL = "SELECT * FROM QScanOCard2 ";
    $strSQL .= "WHERE  (QScDate >= '" . $setStartDate . "' ";
    $strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate,QScVN ASC;";
}
else if($_POST["data"]=='P3'){
    $strSQL = "SELECT * FROM QScanICard ";
    $strSQL .= "WHERE  (QScDate >= '" . $setStartDate . "' ";
    $strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate,QScVN ASC;";
}
else if($_POST["data"]=='A1'){
    $strSQL = "SELECT * FROM QScanSocOld ";
    $strSQL .= "WHERE  (QScDate >= '" . $setStartDate . "' ";
    $strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate,QScVN ASC;";
}
else if($_POST["data"]=='B1'){
    $strSQL = "SELECT * FROM QScanPayOld ";
    $strSQL .= "WHERE  (QScDate >= '" . $setStartDate . "' ";
    $strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate,QScVN ASC;";
}
$stmt = $conn->prepare($strSQL);
$stmt->execute();
echo "
<thead>
<tr>
    <th  style='width: 80px;'>ลำดับ</th>
    <th  style='width: 80px;'>วันที่</th>
    <th style='width: 80px;'>HN</th>
    <th  style='width: 90px;'>VN</th>
    <th  style='width: 160px;'>ชื่อ-นามสกุล</th>
    <th style='width: 160px;'>แพทย์</th>
    <th  style='width: 120px;'>หมายเหตุ1</th>
    <th  style='width: 160px;'>ผู้บันทึก</th>
    <th  style='width: 120px;'>หมายเหตุ2</th>
    <th style='width: 160px;'>ผู้บันทึก</th>
    <th  style='width:80px;'>เกิดPE</th>
</tr>
</thead><tbody> ";
$no=1;
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($result['QPhaChkRmk1'] != "" || $result['QPhaChkRmk2'] != "") {

        $url = 'http://192.168.5.246:8081/DoctorPrimary/'.$result['QScVN'].'';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //jsondata
        $doctor = curl_exec($ch);

        curl_close($ch);

        $doctor_utf8 = mb_convert_encoding($doctor, 'UTF-8', 'UTF-8');
        //arraydata
        $data = json_decode($doctor_utf8, true);
        //data
        if(isset($data['data']['DoctorFullName'])){
        $DoctorFullName = $data['data']['DoctorFullName'];}
        else{
        $DoctorFullName='';
        }
        $SSdate = substr($result['QScDate'], 0, 10);

        if(isset($result['QPhaChkMe'])){
            $QPhaChkMe=$result['QPhaChkMe'];
        }
        else{
            $QPhaChkMe="";
        }
       
        echo '<tr>
                <td >' . $no++ . '
                </td>
                <td>' .$SSdate. '
                </td>
                <td>' . $result['QScHN'] . '
                </td>
                <td>' . $result['QScVN'] . '
                </td>
                <td>' . $result['QPtName'] . '
                </td>
                <td>' . $DoctorFullName . '
                </td>
                <td>' . $result['QPhaChkRmk1'] . '
                </td>
                <td>' . $result['QPhaChkRmkUser1'] . '
                </td>
                <td>' . $result['QPhaChkRmk2'] . '
                </td>
                <td>' . $result['QPhaChkRmkUser2'] . '
                </td>
                <td>' .  $QPhaChkMe . '
                </td>
                </tr>';
    }
    
}
echo "</tbody>";
?>