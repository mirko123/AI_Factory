<!DOCTYPE html>
<html lang="en">
<?php require_once("php/templates.php");
    mainTemplate::head();
 ?>
<body id="page">
    <?php mainTemplate::header(); ?>

    <section id="container" class="container-fluid text-center">

<?php         
require_once("php/DB_traffic_system.php");
function generateCol($content, $size = 2, $bordered = true, $paddingTop = true) {
	$borderedClass = $bordered ? " border" : "";
	$paddingClass = $paddingTop ? " pt-2" : "";
	$classes = $borderedClass . $paddingClass;
	if($size == NULL) {
		return '<div class="col '.$classes.'">'.(string)$content.'</div>';
	}
  	return '<div class="col-'.(string)$size.' '.$classes.'">'.(string)$content.'</div>'. PHP_EOL;
}
function createPlatnoAddForm($systemId) {
	echo '		<div class="container">
			<h2>Добавяне на светофарна система</h2>
			<form class="form-horizontal" action="php/system.php" method="POST">
			    <div class="form-group">
			      	<label class="control-label col-sm-2" for="email">Име на светофарната система</label>
			      	<div class="col-sm-9">
  					<input type="hidden" id="custId" name="systemId" value="'.$systemId.'>
			        <input name="idname" id="tb-idname" class="form-control" placeholder="Име" type="text">
			      	</div>
			        </label>
			    </div>
			    <div class="form-group">        
			      	<div class="col-sm-offset-2 col-sm-10">
			        	<input type="submit" class="btn btn-default" value="Добави"/>
			      	</div>
			    </div>
			</form>
		</div>';
}

function generateAddPlatnoButton($systemId) {
	$content = '
	<div class="row border-bottom pt-2">
		<form class="col" action="addPlatno.php" method="POST">
				    <div class="form-group">
				        <input name="systemId" id="tb-idname" class="form-control d-inline" value="'.$systemId.'" type="hidden">
				        <input type="submit" class="col-sm btn btn-success d-inline" value="Add"/>
				    </div>
				</form>
				<div class="col"> </div>
	</div>';
	return $content;		
}


function generateAddLaneButton($platnoId) {
	$content = '
	<div class="row pt-2">
		<form class="col" action="addLane.php" method="POST">
				    <div class="form-group">
				        <input name="platnoId" id="tb-idname" class="form-control d-inline" value="'.$platnoId.'" type="hidden">
				        <input type="submit" class="col-sm btn btn-success d-inline" value="Add"/>
				    </div>
				</form>
	</div>';
	return $content;		
}


function generateSystemRemoveButton($systemId) {
	$content = '
		<form class="col-sm-1" action="systems.php" method="POST">
		    <div class="form-group">
		        <input name="systemId" id="tb-idname" class="form-control d-inline" value="'.$systemId.'" type="hidden">
		        <input name="queryType" id="tb-idname" class="form-control d-inline" value="removeSystem" type="hidden">
		        <button class="btn btn-danger btn-xs btn-delete-esp" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
		    </div>
		</form>';
	return $content;		
}

function generatePlatnoRemoveButton($platnoId) {
	$content = '
		<form class="col-sm-1" action="systems.php" method="POST">
		    <div class="form-group">
		        <input name="platnoId" id="tb-idname" class="form-control d-inline" value="'.$platnoId.'" type="hidden">
		        <input name="queryType" id="tb-idname" class="form-control d-inline" value="removePlatno" type="hidden">
		        <button class="btn btn-danger btn-xs btn-delete-esp" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
		    </div>
		</form>';
	return $content;		
}

function generateLaneRemoveButton($laneId) {
	$content = '
		<form class="col-sm-1" action="systems.php" method="POST">
		    <div class="form-group">
		        <input name="laneId" id="tb-idname" class="form-control d-inline" value="'.$laneId.'" type="hidden">
		        <input name="queryType" id="tb-idname" class="form-control d-inline" value="removeLane" type="hidden">
		        <button class="btn btn-danger btn-xs btn-delete-esp" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
		    </div>
		</form>';
	return $content;		
}

function directionToText($dir) {
	if($dir == "mid") {
		return "Само направо";
	} else if($dir == "mid/right") {
		return "Направо и надясно";
	} else if($dir == "left/mid") {
		return "Наляво и направо";
	} else if($dir == "left/right") {
		return "Наляво и надясно";
	} else if($dir == "left") {
		return "Само наляво";
	} else if($dir == "right") {
		return "Само надясно";
	} else if($dir == "out") {
		return "Изход";
	} else {
		return "Грешка";
	}
}


if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1)     {



	$methodName = $_SERVER['REQUEST_METHOD'];
	$_METHOD;
	if($methodName == "GET") $_METHOD = $_GET;
	else if($methodName == "POST") $_METHOD = $_POST;

	if($_METHOD && array_key_exists('queryType',$_METHOD))
	{
		$queryType = $_METHOD['queryType'];	

		if($queryType == "newSystem") {
			$newSystemName = $_METHOD['newSystemName'];
			$dbTrafficSystem = new DBTrafficSystem();
			$dbTrafficSystem->add($newSystemName);
		}
		else if($queryType == "newPlatno") {

			$currentSystemId = $_METHOD['systemId'];
			$platnoDiscription = $_METHOD['discription'];
			$dbPlatna = new DBPlatna();
			$dbPlatna->add($currentSystemId, $platnoDiscription);
		}
		else if($queryType == "newLane") {

			$platnoId = $_METHOD['platnoId'];
			$laneDirection = $_METHOD['direction'];
			$dbLanes = new DBLanes();
			$dbLanes->add($platnoId, $laneDirection);
		}

		else if($queryType == "removeSystem") {

			$systemId = $_METHOD['systemId'];
			$dbTrafficSystem = new dbTrafficSystem();
			$dbTrafficSystem->remove($systemId);
		}
		else if($queryType == "removePlatno") {

			$platnoId = $_METHOD['platnoId'];
			$dbPlatna = new dbPlatna();
			$dbPlatna->remove($platnoId);
		}
		else if($queryType == "removeLane") {

			$laneId = $_METHOD['laneId'];
			$dbLanes = new DBLanes();
			$dbLanes->remove($laneId);
		}
		
	}
?>

		<div class="container">
			<h2>Добавяне на светофарна система</h2>
			<form class="form-horizontal" action="systems.php" method="POST">
			    <div class="form-group">
			      	<label class="control-label col-sm-3" for="newSystemName">Име на светофарната система</label>
			      	<div class="col-sm-7">
			        <input name="newSystemName" id="tb-idname" class="form-control" placeholder="Име" type="text" required>
			        <input name="queryType" id="tb-idname" class="form-control" type="hidden" value="newSystem">
			      	</div>
			        </label>
		<!-- 	    </div>
			    <div class="form-group">        --> 
			      	<div class="	col-sm-1">
			        	<input type="submit" class="btn btn-success" value="Добави"/>
			      	</div>
			    </div>
			</form>
		</div>
		</br></br>


	<div class="container-fluid">
	  <div class="row  ">
	    <div class="col-1 border pt-1">#</div>
	    <div class="col-2 border pt-1">Име</div>
	    <div class="col-2 border pt-1">Платна</div>
	    <div class="col-2 border pt-1">Ленти</div>
	    <div class="col-5 border pt-1">Визуализация</div>
	  </div>
  		<?php 
			
			$dbTrafficSystem = new DBTrafficSystem();
			$dbPlatna = new DBPlatna();
			$dbLanes = new DBLanes();
			$systems = $dbTrafficSystem->getAll();
			foreach ($systems as $key => $system) {
				echo "<div class='row'>". PHP_EOL;

				echo generateCol($system["id"], 1);
				echo generateCol('<div class="col-sm-10 ">'.$system["name"].'</div>'.generateSystemRemoveButton($system["id"]), 2);
				$platna = $dbPlatna->getBySystem($system["id"]);
				$combinatedColumnsContent = "";
				foreach ($platna as $key => $platno) {

					$combinatedColumnsContent .= '<div class="row border-bottom">'. PHP_EOL;
					$discriptionContainer = '<div class="col-sm-10">'.$platno["discription"].'</div>'. generatePlatnoRemoveButton($platno["id"]);
					// $addPlatnoButton = generateAddPlatnoButton($system["id"]);
					$combinatedColumnsContent .= generateCol($discriptionContainer,NULL);

					// $combinatedColumnsContent .= generateAddPlatnoButton($system["id"]);


					$lanes = $dbLanes->getByPlatnoId($platno["id"]);
					$nastedColContent = "";
					foreach ($lanes as $key => $lane) {

						$nastedColContent .= '<div class="row border-bottom">'. PHP_EOL;
						$directionText = '<div class="col-sm-10">'.directionToText($lane["direction"])    .'</div>';
						// $directionText = "";
						$nastedColContent .= generateCol($directionText . generateLaneRemoveButton($lane["id"]), NULL, false);

						
						$nastedColContent .= '</div>'. PHP_EOL;

					}
					$nastedColContent .= generateAddLaneButton($platno["id"]). PHP_EOL;
					$combinatedColumnsContent .= generateCol($nastedColContent,NULL, false). PHP_EOL;

					$combinatedColumnsContent .= '</div>'. PHP_EOL;
					// echo generateCol($combinatedColumnsContent, 4);
					// echo $combinatedColumnsContent;	

				}
				if(empty($platna)) {
					echo generateCol(generateAddPlatnoButton($system["id"]), 4, false, false);
				} else {
					$combinatedColumnsContent .= generateAddPlatnoButton($system["id"]);
					echo generateCol($combinatedColumnsContent, 4, false, false);
				}



				// echo "ppp";
				// echo generateCol($combinatedColumnsContent, 4);
				// echo "ppp";
				echo generateCol("Визуализация", NULL);
				echo "</div>". PHP_EOL;
			}
	    ?>
	</div>


    



<?php         
}
?>
</section>
</body>

</html>