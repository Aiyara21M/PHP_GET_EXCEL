<?php
require "configPDO.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
$StartDateArr = explode("/", $_POST["StartDate"]);
$EndDateArr = explode("/", $_POST["EndDate"]);

$setStartDate = $StartDateArr[2] . "-" . $StartDateArr[1] . "-" . $StartDateArr[0];
$setEndDateArr = $EndDateArr[2] . "-" . $EndDateArr[1] . "-" . $EndDateArr[0];

$strSQL = "SELECT * FROM QScanPayOld WHERE  (QScDate >= '" . $setStartDate . "' ";
$strSQL .= "AND QScDate <='" . $setEndDateArr . "') ORDER BY QScDate ASC;";
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
        $DoctorFullName = $data['data']['DoctorFullName'];

        $SSdate = substr($result['QScDate'], 0, 10);
   
       
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
                <td>' . $result['QPhaChkMe'] . '
                </td>
                </tr>';
    }
    
}
echo "</tbody>";
?>