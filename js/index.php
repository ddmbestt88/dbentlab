﻿<?php

include 'dbh.php';
include 'header.php';
$ruolo=$_GET['ruolo'];

echo "Modo: ".$ruolo."\r\n.";
$data="";
if(isset($_GET['datidacercare'])){
	$data = $_GET['datidacercare'];
}


?>
<body class="body">
</br>
<label>Ricerca Attrezzatura<label>
<label>in questa pagina &egrave; possibile ricercare attrezzature secondo determinati criteri di ricerca.</label>
<h3>Ricerca Attrezzatura per:</h3>

<div class="pricipalmenu">
	<form action="#" method="post">
</div>
<p>Filtri possibili di Ricerca:</p>
<!--<form action="" method="post">--><label>Modello</label></br><!--<button type="submit" name="multiple">Selezione Multipla</button></form></br>-->
<?if(isset($_GET['datidacercare'])){
	$modelli=$_GET['datidacercare'];
	echo"<input type=\"text\" name=\"modello\" value=\"".$modelli."\" placeholder=\"Inserisci un modello\"></input></br>";
}else{echo "<input type=\"text\" name=\"modello\" value=\"\" placeholder=\"Inserisci un modello\"></input></br>";}?>
<label>Formato</label></br>
<select name="formato" >
<option></option>
<option name="A4">A4</option>
<option name="A3">A3</option>
<option name="A4A3">A4 e A3</option>
</select></br>
<label>Colore</label></br>
<select name="colore" >
<option></option>
<option name="BK">Bianco e nero</option>
<option name="CYMK">Colori</option>
</select>
</br>
<label>Condizione</label></br>
<select name="condizione" >
<option></option>
<option name="REVISIONARE">REVISIONARE</option>
<option name="USO RICAMBI">USO RICAMBI</option>
</select></br>
</br>
</br>
<button type="submit" name="cerca" id="cerca">Avvia Ricerca</button><button type="submit" name="multiple">Selezione Multipla</button>
</form>
</body>
</html>

<?php
$class="table";
$modello="";
$formato="";
$colore="";
$condizione="";
$tableheader="<table class=".$class."><tr><th >Modello<br></th><th >Matricola</th><th >Colore</th><th >Configurazione</th><th >Provenienza</th><th >Contatore BK</th><th >Contatore CYMK</th><th >Condizione </th><th >Note</th></tr>";
if (isset($_POST['cerca'])){
	echo $_POST['formato'];
	$passaruolo=$ruolo;
	if(isset($_POST['modello'])){
		if($_POST['modello']!=""){
			if(isset($_GET['datidacercare'])){
			$pieces = explode("-", $modelli);
			for($i=0;$i<count($pieces);$i++){
			if($i==0){$modello="`MODELLO`='".$pieces[$i]."'";}
				else{$modello=$modello." OR `MODELLO`='".$pieces[$i]."'";}
				}
			}else{$modello="`MODELLO` LIKE '%".$_POST['modello']."%'";}}}
			
	if(isset($_POST['formato'])){if($_POST['formato']!=""){if($_POST['formato']=="A4"){if($modello!=""){$formato=" AND `A4`='SI' AND `A3`='NO'";}else{$formato="`A4`='SI' AND `A3`='NO'";}}if($_POST['formato']=="A3"){if($modello!=""){$formato=" AND `A3`='SI' AND `A4`='NO'";}else{$formato="`A3`='SI' AND `A4`='NO'";}}if($_POST['formato']=="A4 e A3"){if($modello!=""){$formato=" AND `A4`='SI' AND `A3`='SI'";}else{$formato="`A4`='SI' AND `A3`='SI'";}}}}
	//if(isset($_POST['contatore'])){if($_POST['contatore']!=""){if($modello!=""||$matricola!=""){$contatore="AND `CONTATOREBK` LIKE '%".$_POST['contatore']."%'";}else{$contatore=" `CONTATOREBK` LIKE '%".$_POST['contatore']."%'";}}}
	if(isset($_POST['colore'])){if($_POST['colore']!=""){if($_POST['colore']=="BK"){if($modello!=""||$formato!=""){$colore="AND `COLORE`='BK'";}else{$contatore=" `COLORE`='BK'";}}if($_POST['colore']=="CYMK"){if($modello!=""||$formato!=""){$colore="AND `COLORE`='CYMK'";}else{$contatore=" `COLORE`='CYMK'";}}}}
	//if($modello!=""||$matricola!=""){$contatore="AND `CONTATOREBK` LIKE '%".$_POST['contatore']."%'";}else{$contatore=" `CONTATOREBK` LIKE '%".$_POST['contatore']."%'";}
	if(isset($_POST['condizione'])){if($_POST['condizione']!=""){if($modello!=""||$matricola!=""||$contatore!=""){$condizione="AND `CONDIZIONE` LIKE '%".$_POST['condizione']."%'";}else{$condizione=" `CONDIZIONE` LIKE '%".$_POST['condizione']."%'";}}}
	//if($modello==""){ echo "\"Modello\" &egrave; un campo obbligatorio!";}
	//else{
		if($modello==""&&$formato==""&&$colore==""&&$condizione==""){$sql = "SELECT * FROM `Sql1062326_3`.`laboratorio`;";}
		else{$sql = "SELECT * FROM `Sql1062326_3`.`laboratorio` WHERE ".$modello." ".$formato." ".$colore." ".$condizione." ;";}
		echo "Query eseguita: ".$sql;
		$result = mysql_query($sql);
		echo "</br><label>Risultati Ricerca:</label>";
		echo $tableheader;
			while($userRow=mysql_fetch_array($result)){ 
			echo"<tr>";
			echo"<td >".$userRow['MODELLO']." </td>";
			echo"<td >".$userRow['MATRICOLA']." </td>";
			echo"<td >".$userRow['COLORE']." </td>";
			echo"<td >".$userRow['A4']." </td>";
			echo"<td >".$userRow['A3']." </td>";
			echo"<td >".$userRow['CONFIGURAZIONE']." </td>";
			echo"<td >".$userRow['PROVENIENZA']." </td>";
			echo"<td >".$userRow['CONTATOREBK']." </td>";
			echo"<td >".$userRow['CONTATORECYMK']." </td>";
			echo"<td >".$userRow['CONDIZIONE']." </td>";
			echo"<td >".$userRow['NOTE']." </td>";
			echo"<td ><a href=./convertfpdf.php?ID=".$userRow['ID']." target=”popup”><button type=”submit”>Apri Scheda</button></form></td>";
			if($ruolo=!""&&$ruolo=="administrator"){echo"<td ><a href=./editreport.php?ID=".$userRow['ID']."&ruolo=".$passaruolo." ><button type=”submit”>Modifica Record</button></form></td>";}
			if($ruolo=!""&&$ruolo=="administrator"){echo"<td ><a href=./deletereport.php?ID=".$userRow['ID']."&ruolo=".$passaruolo." ><button type=”submit”>Elimina Record</button></form></td>";}
			echo"</tr>"; 
			}
		echo "<table>";}else{if(isset($_POST['multiple'])){$passaruolo=$ruolo;header("refresh:1;url=./query.php?ruolo=".$passaruolo);}}

	//echo "Vai semp";
?>
