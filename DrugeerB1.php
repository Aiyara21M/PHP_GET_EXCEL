<?php
require "configPDO.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ห้องยา B1 ข้อมูล Prescripbing error </title>
	<link rel="icon" type="image/png" href="./Pharmacy.png" >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./jquery-ui-1.13.2.custom/jquery-ui.css">
	<!-- <link rel="stylesheet" href="./css.css"> -->
	<link
      rel="stylesheet"
      media="screen and (max-width: 600px)"
      href="cssmb.css"
    />
    <link
      rel="stylesheet"
      media="screen and (min-width: 601px) and (max-width: 1000px)"
      href="csstab.css"
    />
	<link
      rel="stylesheet"
      media="screen and (min-width: 1001px) "
      href="css.css"
    />

	<script src="./jquery-ui-1.13.2.custom/jquery/jquery.js"></script>
	<script src="./jquery-ui-1.13.2.custom/jquery/jquery.min.js"></script>
	<script src="./jquery-ui-1.13.2.custom/jquery-ui.js"></script>
	<script src="xlsx.full.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#datepicker1").datepicker({ dateFormat: 'dd/mm/yy' });
			$("#datepicker2").datepicker({ dateFormat: 'dd/mm/yy' });
			$("#datepicker3").datepicker({ dateFormat: 'dd/mm/yy' });
			$("#datepicker4").datepicker({ dateFormat: 'dd/mm/yy' });

			$("#dataload").css("visibility", "hidden");
			
				//  width="60px;" height="60px;" 
			$("#swaptable").html('<img src="./database-search-icon.png " width="60px;" height="60px;"  > <h1 id="textalert">กรุณาใส่วันที่เพื่อค้นหาข้อมูล</h1>');
			$('#loaddata').click(async function () {
				const Sdate = $("#datepicker1").val();
				const Edate = $("#datepicker2").val();
				const dataBase = 'B1'
				if (Sdate == "" || Edate == "") {
					$("#expex").css("transform", "scale(0)");
					$("#warp").css("justify-content", "center");
					$("#swaptable").css("top", "0");
					$("#swaptable").css("overflow-y", "hidden");
					$("#swaptable").html('<img src="./database-search-icon.png " width="60px;" height="60px;"  > <h1 id="textalert">กรุณาใส่วันที่เพื่อค้นหาข้อมูล</h1>');
				}
				else {
					$("#expex").css("transform", "scale(0)");
					$("#warp").css("justify-content", "center");
					$("#swaptable").css("overflow-y", "hidden");
					$("#swaptable").css("top", "0");
					$("#swaptable").html('<img src="./loading-7528_256.gif" id="picload">');
					const rs1 = await $.ajax({
						url: "Drugdata.php",
						method: "post",
						data: {
							StartDate: Sdate, EndDate: Edate,data:dataBase
						},
						dataType: "text",
						success: async function (data) {
							const sc1 = await $("#swaptable").html(data);
							$("#swaptable").css("position", "relative");
							$("#warp").css("justify-content", "flex-start");
							$("#swaptable").css("top", "85px");
							$("#swaptable").css("overflow-y", "scroll");
							$("#swaptable").css("height", "auto");
							$("#swaptable").css("max-height", "85%");
							$("#expex").css("transform", "scale(1)");
							$("#menu").css("transform", "scale(0)");
							$("#datepicker1").val(Sdate);
							$("#datepicker2").val(Edate);
							$("#datepicker3").val(Sdate);
							$("#datepicker4").val(Edate);
						}
					});
				}
			});

			$('#loaddata2').click(async function () {
				const Sdate = $("#datepicker3").val();
				const Edate = $("#datepicker4").val();
				const dataBase = 'B1'
				if (Sdate == "" || Edate == "") {
					$("#expex").css("transform", "scale(0)");
					$("#warp").css("justify-content", "center");
					$("#swaptable").css("top", "0");
					$("#swaptable").css("overflow-y", "hidden");
					$("#swaptable").html('<img src="./database-search-icon.png " width="60px;" height="60px;"  > <h1 id="textalert">กรุณาใส่วันที่เพื่อค้นหาข้อมูล</h1>');
				}
				else {
					$("#expex").css("transform", "scale(0)");
					$("#warp").css("justify-content", "center");
					$("#swaptable").css("overflow-y", "hidden");
					$("#swaptable").css("top", "0");
					$("#swaptable").html('<img src="./loading-7528_256.gif" id="picload">');
					
					const rs1 = await $.ajax({
						url: "Drugdata.php",
						method: "post",
						data: {
							StartDate: Sdate, EndDate: Edate,data:dataBase
						},
						dataType: "text",
						success: async function (data) {
							const sc1 = await $("#swaptable").html(data);
							$("#swaptable").css("position", "relative");
							$("#warp").css("justify-content", "flex-start");
							$("#swaptable").css("top", "80px");
							$("#swaptable").css("overflow-y", "scroll");
							$("#swaptable").css("height", "auto");
							
							$("#expex").css("transform", "scale(1)");
							$("#datepicker1").val(Sdate);
							$("#datepicker2").val(Edate);
							$("#datepicker3").val(Sdate);
							$("#datepicker4").val(Edate);
						}
					});
				}
			});




			$('#expex').click(async function () {
				const Sdate = $("#datepicker1").val();
				const Edate = $("#datepicker2").val();
				const dataBase = 'B1'
				const rs1 = await $.ajax({
						url: "Drugdata_excel.php",
						method: "post",
						data: {
							StartDate: Sdate, EndDate: Edate,data:dataBase
						},
						dataType: "text",
						success: async function (data) {
						const sc2 = await $("#dataload").html(data);
						exportToExcel()
						}
					});
			});
			$('#menuicon').click(async function () {
				$("#menu").css("transform", "scale(1)");
			});
			$('#icclose').click(async function () {
				$("#menu").css("transform", "scale(0)");
			});
		});

	</script>
</head>

<body>
	<nav>
	
		
	</nav>


		<div id="warp">
	<div id="menu">	
		<p id='ht'>ใส่วันที่เพื่อค้นหา   </p>
			<p id='ht'>จากวันที่:  </p>
			<p><input type="text" id="datepicker1"></p>
			<p id='ht'>ถึงวันที่:  </p>
			<p><input type="text" id="datepicker2"></p>
			<p id="iconload"><img src="./search (2).png" id="loaddata" width="30px;" height="30px;"></p>
			<p id='icclose'><img src="./close.png" id="loaddata" width="30px;" height="30px;"> </p>
	</div>

	<div id="menu2">	
		<p id='ht'>ใส่วันที่เพื่อค้นหา   </p>
			<p id='ht'>จากวันที่:  </p>
			<p><input type="text" id="datepicker3"></p>
			<p id='ht'>ถึงวันที่:  </p>
			<p><input type="text" id="datepicker4"></p>
			<p id="iconload"><img src="./search (2).png" id="loaddata2" width="30px;" height="30px;"></p>
	</div>



<hr id="hr1">
<div id="menuicon"><img src="./menu.png" width="30px;" height="30px;" ></div>
<div id="expex">Export Excel</div>
				<div class="headtext">
					<h2>ข้อมูล Prescripbing error ห้องยา B1</h2>
				</div >
<div id="swaptable">
				
					
</div>
				
		<table id="dataload" >
		</table>

</div>
		

</body>
<script>
		function exportToExcel() {
			var date1 = document.getElementById("datepicker1").value;
			var date2 = document.getElementById("datepicker2").value;
			var table = document.getElementById("dataload");
			var wb = XLSX.utils.table_to_book(table);
			XLSX.writeFile(wb, "B1_F_"+date1+"_T_"+date2+".xlsx");
		}
	</script>
</html>