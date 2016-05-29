<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Studio Medico</title>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="script/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="calendar/includes/jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script src="timepicker/jquery.timepicker.min.js"></script>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<link href="dynamicSheet.css" rel="stylesheet">
<script>
function onAppuntamentoModalEdit(id_a){
	$("#id_appuntamento").append(id_a);
	$("#id_appuntamento_edit").val(id_a);
	readEvent(id_a);
	readAppuntamento(id_a);
	$("#appuntamentoModalEdit").modal();
}

function onTerapistChange() {
		$("#id_terapista_sel").val(
			$("#id_terapista").val());
		$("#id_terapista2").val(
			$("#id_terapista").val());
	}
	
	function onTerapistChangeEdit() {
		$("#id_terapista_sel_edit").val(
			$("#id_terapista_edit").val());
		$("#id_terapista2_edit").val(
			$("#id_terapista_edit").val());
	}
	
	function readAppuntamento(id_a) {
		$.post('script/readAppuntamento.php', {
				id_evento: id_a
			}, function(data) {
				var dataJSON = $.parseJSON(data);
				
				if ($.isArray(dataJSON)) {
		
					$(dataJSON).each(function() {
						upd_ite(this[4]);
						upd_its(this[3]);
					});
					
				}
			});
	}
	function upd_ite(i) {
		$("#id_terapista_edit").val(i);
		onTerapistChangeEdit();
	}
	
	function upd_its(i) {
		$("#id_sala_edit").val(i);
		onSalaChangeEdit();
	}
	
	function readEvent(id_a) {
		$.post('script/readEvent.php', {
				id_appuntamento: id_a
			}, function(data) {
				var dataJSON = $.parseJSON(data);
				
				if ($.isArray(dataJSON)) {
		
					$(dataJSON).each(function() {
						$("#nomeAppuntamento_edit").val(this[1]);
						$("#descAppuntamento_edit").val(this[2]);
						d2e= this[3].split(" ")[0];
						d2e_Y= d2e.split("-")[0];
						d2e_m=  d2e.split("-")[1];
						d2e_d= d2e.split("-")[2];
						$("#datepicker2_edit").val(d2e_d + "-" + d2e_m + "-" + d2e_Y);
						$("#timepicker_edit").val(this[3].split(" ")[1].substr(0,5));
						$("#durataAppuntamento_edit").val(this[4]);
					});
					
				}
			});
	}
	
	function onSalaChange() {
		$("#id_sala_sel").val(
			$("#id_sala").val());
		$("#id_sala2").val(
			$("#id_sala").val());
	}
	function onSalaChangeEdit() {
		$("#id_sala_sel_edit").val(
			$("#id_sala_edit").val());
		$("#id_sala2_edit").val(
			$("#id_sala_edit").val());
	}
	function onDatePickerChange(){
		$("#datepicker2").val(
			$("#datepicker").val());
	}
	</script>
<script>
	$(document).ready(function(e) {
		var numCols= 0;
		var halfHours= true;
		
		d= new Date();
		month= d.getMonth()+1;
		if (month < 10)
			month_str= "0" + month;
		else
			month_str= month.toString();
		ds= <?php echo '"' . $_POST['data_sheet'] . '"' ?>;
		if (! ds.localeCompare('')){
			$("#datepicker").val(d.getDate() + "-" + month_str + "-" + d.getFullYear());
			$("#datepicker3").val(d.getDate() + "-" + month_str + "-" + d.getFullYear());
			$("#datepicker4").val(d.getDate() + "-" + month_str + "-" + d.getFullYear());
		}
		
		$("#datepicker").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});
		$("#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});
		$("#datepicker2_edit").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});
		$('#timepicker').timepicker({timeFormat: 'H:i'});
		
        $("#id_terapista").val(
			$("#id_terapista_sel").val());
		$("#id_sala").val(
			$("#id_sala_sel").val());
		
		$("#id_terapista2_edit").val(
			$("#id_terapista").val());
		$("#id_sala2_edit").val(
			$("#id_sala").val());
			
		$("#id_terapista2").val(
			$("#id_terapista").val());
		$("#id_sala2").val(
			$("#id_sala").val());
			
		$("#id_terapista_sel_edit").val(
			$("#id_terapista_edit option:selected").val());
		$("#id_sala_sel_edit").val(
			$("#id_sala_edit option:selected").val());
			
	    onDatePickerChange();
		addColumn("ora");
        
		v= $("#datepicker").val();
		addAllTerapists(v);
		
		
    });
</script>
<script>
	function addAllTerapists(day) {
		$.post('script/addAllTerapists.php', {
				giorno: day
			}, function(data) {
				var dataJSON = $.parseJSON(data);
				
				if ($.isArray(dataJSON)) {
					
					numCols= 0; //dataJSON.length;
					var halfHours= true;
					for (j=8;j<20;j++) {
						if (halfHours) {
							for (m=0;m<4;m+=3){
								addRow(numCols,"hour",j.toString()+":"+m+"0", true);
							}
						} else {
							addRow(numCols,"hour",j.toString()+":00", true);
						}
					}
					
					$(dataJSON).each(function() {
						addColumn(this[1],this[0]);
						readEventsFromDb(this[0],this[2]);
					});
					
				}
			});
	}

	function readAvailability(id_terapist, day_week) {
		dp= $("#datepicker").val();
		dp_y= dp.split("-")[2];
		dp_m= dp.split("-")[1];
		dp_d= dp.split("-")[0];
		dp_Ymd= dp_y + "-" + dp_m + "-" + dp_d;
		$.post('script/availability.php', {
				giorno_settimana: day_week,
				data_sheet: dp_Ymd,
				id_terapista: id_terapist
			}, function(data) {
				var dataJSON = $.parseJSON(data);
				
				if ($.isArray(dataJSON)) {
					$(dataJSON).each(function() {
						setCellBackgroundA(this[0], this[2].substr(0,5), this[3].substr(0,5));
					});
				}
			});
	}

	function readEventsFromDb(id_terapist, day) {
		readAvailability(id_terapist, day);
		$.post('script/dynamicSheet.php', {
				giorno: day,
				id_terapista: id_terapist
			}, function(data) {
				var dataJSON = $.parseJSON(data);
				
				if ($.isArray(dataJSON)) {
					$(dataJSON).each(function() {
						
						//setCellBackgroundA(this[4],"8:00","9:00");
						setCellHour(this[2].split(" ")[1].substr(0,5),this[4],this[0], this[1], this[6]);
						setCellHourExternalBorderD(this[2].split(" ")[1].substr(0,5),parseFloat(this[3]),this[4],"1px solid black", "1px solid black", "1px solid black", "1px solid black",true);
					});
				}
			});
	}
	
	 function addHourColumn(hStart, hEnd) {
		 var td= document.createElement("td");
		 
	 };
	 
	 function addColumn(title, id) {
		var th= document.createElement("th");
		th.innerHTML= title;
		
		$(th).css({width: 150,
		backgroundColor: '#AFAFAF'});
		
		$("#dynamicSheet thead").append(th);
		
		var td= document.createElement("td");
		$(td).attr("id_terapista",id);
		$(td).attr("terapist",title);
		$(td).css({border: "1px dotted gray", textAlign: "center"});
		$("#dynamicSheet tbody tr").append(td);
		
		
	};
	function addRow(tableCols, nameOfRow, valueOfRow, withHourHeading) {
		var tr=document.createElement("tr");
		if (withHourHeading) {
				var td2= document.createElement("td");
				td2.innerHTML= valueOfRow;
				$(td2).css({border: "1px dotted gray"});
				$(tr).append(td2);
			}
		tr.setAttribute(nameOfRow, valueOfRow);
		for (i=0;i<tableCols;i++) {
			var td= document.createElement("td");
			$(td).css({
						"border": "1px dotted gray"
						});
			
			
			$(tr).append(td);
		}
		$("#dynamicSheet tbody").append(tr);
	};
	
	function setCellContents(r, c, t) {	
		$("#dynamicSheet tbody tr:nth-child("+r+") td:nth-child("+c+")").append(t);
	};
	
	function setCellBackgroundA(id_terapista, dalleore, alleore) {
		if (dalleore.substr(0,1) == 0)
				dalleore= dalleore.substr(1,4);
		$("#dynamicSheet tbody tr[hour='"+dalleore+"'] td[id_terapista='"+id_terapista+"']").css({backgroundColor: "#8fef84"});
		
		h= dalleore;
		h= nextTime(h);
		while (h != alleore) {
			$("#dynamicSheet tbody tr[hour='"+h+"'] td[id_terapista='"+id_terapista+"']").css({backgroundColor: "#8fef84"});
			h= nextTime(h);
		}
	};
	
	function setCellBackground(r, c, b) {
		$("#dynamicSheet tbody tr:nth-child("+r+") td:nth-child("+c+")").css({backgroundColor: b});
	};
	
	function setCellBorder(r, c, top, left, right, bottom) {
		$("#dynamicSheet tbody tr:nth-child("+r+") td:nth-child("+c+")").css({borderTop: top,
																			borderLeft: left,
																			borderRight: right,
																			borderBottom: bottom});
	}
	function setCellHour(h, id, t, d, id_a) {
		if (h.substr(0,1) == 0)
				h= h.substr(1,4);
		ttip= '<a href="#" data-toggle="tooltip" title="' + d + '" data-container="body" data-placement="right" onclick="onAppuntamentoModalEdit(' + id_a + ')">'+ t +'</a>';
		$("#dynamicSheet tbody tr[hour='"+h+"'] td[id_terapista='"+id+"']").append(ttip);
	}
	function setCellHourBorder(fromHour, toHour, c, top, left, right, bottom, halfHours) {
		if (halfHours)
			step= 0.5;
		for (k=fromHour,b=0; k<=toHour; k+=step) {	
				if (b==0) {
					z=	parseInt(k) + ":00";
					b++;
				}
				else {
					z=	parseInt(k) + ":30";
					b=0;
				}
				
				$("#dynamicSheet tbody tr[hour='"+z+"'] td:nth-child("+c+")").css({borderTop: top,
																		borderLeft: left,
																		borderRight: right,
																		borderBottom: bottom});
			} 
		}
		function setCellHourExternalBorder(fromHour, toHour, c, top, left, right, bottom, halfHours) {
			if (halfHours)
				step= 0.5;
			if (parseFloat(fromHour)-parseInt(fromHour) == 0)
				b=0;
			else
				b=1;
			for (k=fromHour; k<toHour; k+=step) {	
				if (b==0) {
					z=	parseInt(k) + ":00";
					b++;
				}
				else {
					z=	parseInt(k) + ":30";
					b=0;
				}
				
				if (k==fromHour)
					$("#dynamicSheet tbody tr[hour='"+z+"'] td:nth-child("+c+")").css({borderTop: top,
																		borderLeft: left,
																		borderRight: right});
				if (k+step==toHour)
					$("#dynamicSheet tbody tr[hour='"+z+"'] td:nth-child("+c+")").css({borderBottom: bottom,
																		borderLeft: left,
																		borderRight: right});
				
					$("#dynamicSheet tbody tr[hour='"+z+"'] td:nth-child("+c+")").css({
																		borderLeft: left,
																		borderRight: right});
					
			} 
		}
		function setFullBorder(h,id,border) {
			$("#dynamicSheet tbody tr[hour='"+h+"'] td[id_terapista='"+id+"']").css({borderTop: border,
																		borderLeft: border,
																		borderRight: border,
																		borderBottom: border});
		}
		
		function setDoubleBorder(h,id,border) {
			$("#dynamicSheet tbody tr[hour='"+h+"'] td[id_terapista='"+id+"']").css({borderTop: border,
																		borderLeft: border,
																		borderRight: border});
			if (h.split(":")[1] == "00")
				hnext= (parseInt(h.substr(0,2))) +":30";
			else
				hnext= (parseInt(h.substr(0,2))+1) +":00";
				
			$("#dynamicSheet tbody tr[hour='"+hnext+"'] td[id_terapista='"+id+"']").css({borderBottom: border,
																		borderLeft: border,
																		borderRight: border});
		}
		
		function nextTime(h) {
			if (h.split(":")[1] == "00")
					h= (parseInt(h.substr(0,2))) +":30";
				else
					h= (parseInt(h.substr(0,2))+1) +":00";
			return h;
		}
		
		function setTripleBorder(h,id,duration,border) {
			$("#dynamicSheet tbody tr[hour='"+h+"'] td[id_terapista='"+id+"']").css({borderTop: border,
																		borderLeft: border,
																		borderRight: border});
			for(hnext=h,i=0.5;i<duration;i+=0.5){															
				
				hnext= nextTime(hnext);
				$("#dynamicSheet tbody tr[hour='"+hnext+"'] td[id_terapista='"+id+"']").css({
																			borderLeft: border,
																			borderRight: border});
			}
			$("#dynamicSheet tbody tr[hour='"+hnext+"'] td[id_terapista='"+id+"']").css({borderBottom: border,
																		borderLeft: border,
																		borderRight: border});
		}
		
		function setCellHourExternalBorderD(fromHour, duration, id, top, left, right, bottom, halfHours) {
			//fromHour= parseInt(fH.substr(0,2));
			//if (fH.substr(3,1) == "3")
			//	fromHour += 0.5;
			if (fromHour.substr(0,1) == 0)
				fromHour= fromHour.substr(1,4);
			
			if (duration == 0.5)
				setFullBorder(fromHour,id,top);
			else if (duration==1.0)
				setDoubleBorder(fromHour,id,top);
			else
				setTripleBorder(fromHour,id,duration,top);
			
		}
</script>
</head>

<body>
	
    
    <?php $nav_active="Home" ?>
    <?php require ("require/nav.php");?>
    <?php require ("require/db_settings.php");?>
	<?php
			// Create connection
			$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$sql = 'select * from anagrafica where id="' . $_POST['peopleSelectedId'] .'"';
					
			$result = $conn->query($sql);
			if ($result->num_rows > 0) { 
				while($row = $result->fetch_assoc()) {
					$name= $row['nome'];
					$surname= $row['cognome'];
					$tipo= $row['tipo'];
				}
			}
			$conn->close();
			?>
    <div class="container">
    	<?php if ($_POST['peopleSelectedId'] != "") {
			$h2="Paziente selezionato " . $name. " " . $surname . "<br>";
				if ($_POST['data_sheet'] != '')
					$h2= $h2 . " Giorno " . $_POST['data_sheet'];
			}
			else {
			$h2="Calendario - <span class='text-danger'><em>nessun paziente selezionato</em></span><br>";
			if ($_POST['data_sheet'] != '')
					$h2= $h2 . "Giorno " . $_POST['data_sheet'];
			}?>
        <?php  require("require/bodyHeader.php");?>
		<div class="right-align" style="display: inline-flex;
    width: 100%;
    flex-direction: row-reverse;">
            <form method="post" action="orari_modifica_disponibilita.php" style="padding-left: 12px;">
            	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
                <input type="hidden" name="peopleName" id="peopleName" value=<?php echo '"' . $_POST['peopleName'] . '"'?>>
            	<input type="hidden" name="peopleSurname" id="peopleSurname" value=<?php echo '"' . $_POST['peopleSurname'] . '"'?>>
                <input type="hidden" name="data_sheet" id="datepicker3" readonly  class="form-control clsDatePicker" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
                <button type="submit" class="btn btn-default">Modifica Orari</button>
            </form>
            <form method="post" action="orari_copia.php" >
            	<input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
                <input type="hidden" name="peopleName" id="peopleName" value=<?php echo '"' . $_POST['peopleName'] . '"'?>>
            	<input type="hidden" name="peopleSurname" id="peopleSurname" value=<?php echo '"' . $_POST['peopleSurname'] . '"'?>>
                <input type="hidden" name="data_sheet" id="datepicker4" readonly  class="form-control clsDatePicker" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
                <button type="submit" class="btn btn-default">Copia Orari</button>
            </form>
            </div>
        <div class="center-align">
            <form method="post" action="sale_richiama1.php" id="formAggiorna">
            <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
            <input type="hidden" name="peopleName" id="peopleName" value=<?php echo '"' . $_POST['peopleName'] . '"'?>>
            <input type="hidden" name="peopleSurname" id="peopleSurname" value=<?php echo '"' . $_POST['peopleSurname'] . '"'?>>
            <label class="left-align">Vai a Data: 
        	 <input type="text" name="data_sheet" id="datepicker" onchange="onDatePickerChange()" class="form-control clsDatePicker" value=<?php echo '"' . $_POST['data_sheet'] . '"' ?>>
        </label>
           <button type="submit" class="btn btn-default">Aggiorna</button> 
            <?php if ($_POST['peopleSelectedId'] != "") { ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            	Nuovo Appuntamento
			</button>
            <?php } ?>
            <br><span class="e"></span>
			</form>
        <br>
        <table id="dynamicSheet" style="width:100%">
            <thead>
            </thead>
            <tbody>
            
            </tbody>
        </table>
      </div>
    </div><!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuovo Appuntamento</h4>
      </div>
      <form method="post" action="appuntamento_doNew.php">
      <div class="modal-body left-align">
      <?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from anagrafica where tipo="T" order by cognome, nome';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
        
            <label>Terapista
                <select class="form-control" name="id_terapista" id="id_terapista" onChange="onTerapistChange()">
					<option value="" disabled="disabled">Scegli...</option>
					<?php while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'] ?>" ><?php echo $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="hidden" name="id_terapista_sel" id="id_terapista_sel" value="<?php echo $_POST['id_terapista_sel']?>">
			<?php
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
				?>
      <?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from sale order by nome';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
        
            <label >Sala
                <select class="form-control" name="id_sala" id="id_sala" onChange="onSalaChange()">
                	<option value="" disabled="disabled">Scegli...</option>
					<?php while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="hidden" name="id_sala_sel" id="id_sala_sel" value="<?php echo $_POST['id_sala_sel']?>">
            <input type="hidden" name="peopleSelectedId" id="peopleSelectedId" value="<?php echo $_POST['peopleSelectedId']?>">
			<?php
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
				?><br>
        <input type="hidden" name="peopleSelectedId2" id="peopleSelectedId2" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
        <input type="hidden" name="id_sala2" id="id_sala2" value="">
        <input type="hidden" name="id_terapista2" id="id_terapista2" value="">
        <label>Nome: 
        	<input type="text" name="nomeAppuntamento" id="nomeAppuntamento" class="form-control clsDatePicker">
        </label>
        <label>Descrizione: 
        	<input type="text" name="descAppuntamento" id="descAppuntamento" class="form-control clsDatePicker">
        </label>
        <label>Data: 
        	<input type="text" name="dataAppuntamento" id="datepicker2" readonly class="form-control clsDatePicker">
        </label>
        <label>Ora: 
        	<input type="text" name="oraAppuntamento" id="timepicker" class="form-control clsTimePicker">
        </label>
        <label>Durata (ore): 
        	<input type="text" name="durataAppuntamento" id="durataAppuntamento" class="form-control clsTimePicker">
        </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
        <button type="submit" class="btn btn-primary">Nuovo</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="appuntamentoModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modifica Appuntamento</h4>
      </div>
      <div id="id_appuntamento" style="display: none"></div>
      <form method="post" action="appuntamento_doEdit.php">
      <div class="modal-body left-align">
      <?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from anagrafica where tipo="T" order by cognome, nome';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
        
            <label>Terapista
                <select class="form-control" name="id_terapista_edit" id="id_terapista_edit" onChange="onTerapistChangeEdit()">
					<option value="" disabled="disabled">Scegli...</option>
					<?php while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'] ?>" ><?php echo $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="hidden" name="id_terapista_sel_edit" id="id_terapista_sel_edit" value="<?php echo $_POST['id_terapista_sel']?>">
			<?php
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
				?>
      <?php
				// Create connection
				$conn = new mysqli("$db_server:$db_port", $db_login, $db_password, $db_dbName);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$sql = 'select * from sale order by nome';
						
				$result = $conn->query($sql);
				if ($result->num_rows > 0) { ?>
        
            <label >Sala
                <select class="form-control" name="id_sala_edit" id="id_sala_edit" onChange="onSalaChangeEdit()">
                	<option value="" disabled="disabled">Scegli...</option>
					<?php while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nome'] ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="hidden" name="id_sala_sel_edit" id="id_sala_sel_edit" value="<?php echo $_POST['id_sala_sel']?>">
            <input type="hidden" name="peopleSelectedId_edit" id="peopleSelectedId_edit" value="<?php echo $_POST['peopleSelectedId']?>">
			<?php
					 } else { ?>
				<br><span class="text-danger text-bold">Nessun record trovato</span> <?php $conn->error;
			}
			
			$conn->close();
				?><br>
        <input type="hidden" name="peopleSelectedId2_edit" id="peopleSelectedId2_edit" value=<?php echo '"' . $_POST['peopleSelectedId'] . '"'?>>
        <input type="hidden" name="id_sala2_edit" id="id_sala2_edit" value="<?php echo $_POST['id_sala_sel']?>">
        <input type="hidden" name="id_terapista2_edit" id="id_terapista2_edit" value="<?php echo $_POST['id_terapista_sel']?>">
        <input type="hidden" name="data_sheet" id="data_sheet_edit" value="<?php echo $_POST['data_sheet']?>">
        <input type="hidden" name="id_appuntamento_edit" id="id_appuntamento_edit" value=""> 
        <label>Nome: 
        	<input type="text" name="nomeAppuntamento_edit" id="nomeAppuntamento_edit" class="form-control clsDatePicker">
        </label>
        <label>Descrizione: 
        	<input type="text" name="descAppuntamento_edit" id="descAppuntamento_edit" class="form-control clsDatePicker">
        </label>
        <label>Data: 
        	<input type="text" name="dataAppuntamento_edit" id="datepicker2_edit" readonly class="form-control clsDatePicker">
        </label>
        <label>Ora: 
        	<input type="text" name="oraAppuntamento_edit" id="timepicker_edit" class="form-control clsTimePicker">
        </label>
        <label>Durata (ore): 
        	<input type="text" name="durataAppuntamento_edit" id="durataAppuntamento_edit" class="form-control clsTimePicker">
        </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
        <button type="submit" class="btn btn-primary">Modifica</button>
      </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>