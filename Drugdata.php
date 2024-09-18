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
echo "<table id='dataon' >
<thead id='tt'>
<tr>
    <th id='lefta' class='bg2 tbh1' >ลำดับ</th>
    <th id='lefta' class='bg2 tbh2' >วันที่</th>
    <th id='lefta' class='bg2 tbh3' >HN</th>
    <th id='lefta' class='bg2 tbh4' >VN</th>
    <th id='lefta' class='bg2 tbh5' >ชื่อ-นามสกุล</th>
    <th id='lefta' class='bg2 tbh6' >แพทย์</th>
    <th id='lefta' class='bg2 tbh7' >หมายเหตุ1</th>
    <th id='lefta' class='bg2 tbh8' >ผู้บันทึก</th>
    <th id='lefta' class='bg2 tbh9' >หมายเหตุ2</th>
    <th id='lefta' class='bg2 tbh10' >ผู้บันทึก</th>
    <th class='bg2' class='tbh11' >เกิดPE</th>
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
        if($no%2==0){
                $classcase="casecolor";
        }
        else
        {
            $classcase="";
        }
        if(isset($result['QPhaChkMe'])){
                $QPhaChkMe=$result['QPhaChkMe'];
        }
        else{
            $QPhaChkMe="";
        }

        $SSdate = substr($result['QScDate'], 0, 10); 
        echo '<tr class="'.$classcase.'">
                <td id="leftb">' . $no++ . '
                </td>
                <td id="leftb">' .date("d/m/Y", strtotime($result['QScDate'])). '
                </td>
                <td id="leftb">' . $result['QScHN'] . '
                </td>
                <td id="leftb">' . $result['QScVN'] . '
                </td>
                <td id="leftb">' . $result['QPtName'] . '
                </td>
                <td id="leftb">' . $DoctorFullName . '
                </td>
                <td id="leftb">' . $result['QPhaChkRmk1'] . '
                </td>
                <td id="leftb">' . $result['QPhaChkRmkUser1'] . '
                </td>
                <td id="leftb">' . $result['QPhaChkRmk2'] . '
                </td>
                <td id="leftb">' . $result['QPhaChkRmkUser2'] . '
                </td>
                <td>' .  $QPhaChkMe . '
                </td>
                </tr>';
    }
}
echo "</tbody></table>";
?>