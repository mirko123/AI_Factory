<!DOCTYPE html>
<html lang="en">
<?php require_once("php/templates.php");
    mainTemplate::head();

    class SystemObj {
	    public $id;
	    public $name;
	    public $roadways;
		function __construct($id, $name, $roadways = array()) {
			$this->id = $id;
			$this->name = $name;
			$this->roadways = $roadways;
		}
	}
	class RoadwayObj {
	    public $id;
	    public $discription;
	    public $lanes;
		function __construct($id, $discription, $lanes = array()) {
			$this->id = $id;
			$this->discription = $discription;
			$this->lanes = $lanes;
		}
	}
	class LanesObj {
	    public $id;
	    public $direction;
		function __construct($id, $direction) {
			$this->id = $id;
			$this->direction = $direction;
		}
	}

	function generateSystemTree() {
		$dbTrafficSystem = new DBTrafficSystem();
		$dbRoadway = new DBRoadway();
		$dbLanes = new DBLanes();

		$finalTree = array();
		$systems = $dbTrafficSystem->getAll();
		foreach ($systems as $key => $system) {
			$currentSystem = new SystemObj($system["id"], $system["name"]);
			$roadways = $dbRoadway->getBySystemId($currentSystem->id);
			foreach ($roadways as $key => $roadway) {
				$currentRoadway = new RoadwayObj($roadway["id"], $roadway["discription"]);
				$lanes = $dbLanes->getByRoadwayId($currentRoadway->id);
				foreach ($lanes as $key => $lane) {
					$currentLane = new LanesObj($lane["id"], $lane["direction"]);
					array_push($currentRoadway->lanes, $currentLane);
				}
				array_push($currentSystem->roadways, $currentRoadway);
			}
			array_push($finalTree, $currentSystem);
		}
		return $finalTree;
	}
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
function createRoadwayAddForm($systemId) {
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

function generateAddRoadwayButton($systemId) {
	$content = '
	<div class="row border-bottom pt-2">
		<form class="col" action="addRoadway.php" method="POST">
				    <div class="form-group">
				        <input name="systemId" id="tb-idname" class="form-control d-inline" value="'.$systemId.'" type="hidden">
				        <input type="submit" class="col-sm btn btn-success d-inline" value="Add"/>
				    </div>
				</form>
				<div class="col"> </div>
	</div>';
	return $content;		
}


function generateAddLaneButton($roadwayId) {
	$content = '
	<div class="row pt-2">
		<form class="col" action="addLane.php" method="POST">
				    <div class="form-group">
				        <input name="roadwayId" id="tb-idname" class="form-control d-inline" value="'.$roadwayId.'" type="hidden">
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

function generateRoadwayRemoveButton($roadwayId) {
	$content = '
		<form class="col-sm-1" action="systems.php" method="POST">
		    <div class="form-group">
		        <input name="roadwayId" id="tb-idname" class="form-control d-inline" value="'.$roadwayId.'" type="hidden">
		        <input name="queryType" id="tb-idname" class="form-control d-inline" value="removeRoadway" type="hidden">
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
		else if($queryType == "newRoadway") {

			$currentSystemId = $_METHOD['systemId'];
			$roadwayDiscription = $_METHOD['discription'];
			$dbRoadway = new DBRoadway();
			$dbRoadway->add($currentSystemId, $roadwayDiscription);
		}
		else if($queryType == "newLane") {

			$roadwayId = $_METHOD['roadwayId'];
			$laneDirection = $_METHOD['direction'];
			$dbLanes = new DBLanes();
			$dbLanes->add($roadwayId, $laneDirection);
		}

		else if($queryType == "removeSystem") {

			$systemId = $_METHOD['systemId'];
			$dbTrafficSystem = new dbTrafficSystem();
			$dbTrafficSystem->remove($systemId);
		}
		else if($queryType == "removeRoadway") {

			$roadwayId = $_METHOD['roadwayId'];
			$dbRoadway = new DBRoadway();
			$dbRoadway->remove($roadwayId);
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
<?php 

	$systems = generateSystemTree();
	$systemsInJson = json_encode($systems); 
	echo '<script> var systemsInJson = '.$systemsInJson.";\n</script>";	
	?>

	<div class="container-fluid">
	  <div class="row  ">
	    <!-- <div class="col-1 border pt-1">#</div> -->
	    <div class="col-2 border pt-1">Име</div>
	    <div class="col-2 border pt-1">Платна</div>
	    <div class="col-2 border pt-1">Ленти</div>
	    <div class="col-6 border pt-1">Визуализация</div>
	  </div>
  		<?php 
			
			// $dbTrafficSystem = new DBTrafficSystem();
			// $dbRoadway = new DBRoadway();
			// $dbLanes = new DBLanes();
			// $systems = $dbTrafficSystem->getAll();
			foreach ($systems as $key => $system) {
				echo "<div class='row'>". PHP_EOL;

				// echo generateCol($system->id, 1);
				echo generateCol('<div class="col-sm-10 ">'.$system->name.'</div>'.generateSystemRemoveButton($system->id), 2);
				// $roadways = $dbRoadway->getBySystemId($system->id);
				$roadways = $system->roadways;
				$combinatedColumnsContent = "";
				// echo $roadways[0];	
				foreach ($roadways as $key => $roadway) {

					$combinatedColumnsContent .= '<div class="row border-bottom">'. PHP_EOL;
					$discriptionContainer = '<div class="col-sm-10">'.$roadway->discription.'</div>'. generateRoadwayRemoveButton($roadway->id);
					// $addPlatnoButton = generateAddPlatnoButton($system["id"]);
					$combinatedColumnsContent .= generateCol($discriptionContainer,NULL);

					// $combinatedColumnsContent .= generateAddPlatnoButton($system["id"]);


					// $lanes = $dbLanes->getByRoadwayId($roadway["id"]);
					$lanes = $roadway->lanes;
					$nastedColContent = "";
					foreach ($lanes as $key => $lane) {

						$nastedColContent .= '<div class="row border-bottom">'. PHP_EOL;
						$directionText = '<div class="col-sm-10">'.directionToText($lane->direction)    .'</div>';
						// $directionText = "";
						$nastedColContent .= generateCol($directionText . generateLaneRemoveButton($lane->id), NULL, false);

						
						$nastedColContent .= '</div>'. PHP_EOL;

					}
					$nastedColContent .= generateAddLaneButton($roadway->id). PHP_EOL;
					$combinatedColumnsContent .= generateCol($nastedColContent,NULL, false). PHP_EOL;

					$combinatedColumnsContent .= '</div>'. PHP_EOL;
					// echo generateCol($combinatedColumnsContent, 4);
					// echo $combinatedColumnsContent;	

				}
				if(empty($roadways)) {
					echo generateCol(generateAddRoadwayButton($system->id), 4, false, false);
				} else {
					$combinatedColumnsContent .= generateAddRoadwayButton($system->id);
					echo generateCol($combinatedColumnsContent, 4, false, false);
				}



				// echo "ppp";
				// echo generateCol($combinatedColumnsContent, 4);
				// echo "ppp";
				$image = '<img src="images/8miDecember.png" class="img-fluid" alt="Responsive image">';
				echo generateCol($image, NULL);
				// echo generateCol("Визуализация", NULL);
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