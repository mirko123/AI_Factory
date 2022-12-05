<!DOCTYPE html>
<html lang="en">
<?php require_once("php/templates.php");
    mainTemplate::head();
 ?>
<body id="page">
    <?php mainTemplate::header(); ?>

    <section id="container" class="container text-center">
<?php         

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1)     {

	$methodName = $_SERVER['REQUEST_METHOD'];
	$_METHOD;
	if($methodName == "GET") $_METHOD = $_GET;
	else if($methodName == "POST") $_METHOD = $_POST;

	if($_METHOD && array_key_exists('systemId',$_METHOD))
	{

		$systemId = $_METHOD['systemId'];
		?>

		<div class="container">
			<h2>Добавяне на пътно платно</h2>
			<form class="form-horizontal" action="systems.php" method="GET">
			    <div class="form-group">
			      	<label class="control-label col-sm-2" for="platnoDiscription">Описание</label>
			      	<div class="col-sm-8">
			        <input name="discription" id="tb-idname" class="form-control" placeholder="Описание" type="text" required>
			        <?php 
			        echo '<input name="systemId" id="tb-idname" class="form-control" value="'.$systemId.'" type="hidden">'.PHP_EOL;
			         ?>
			        <input name="queryType" id="tb-idname" class="form-control" value="newPlatno" type="hidden">
			      	</div>
			        </label>
			      	<div class="	col-sm-1">
			        	<input type="submit" class="btn btn-success" value="Добавяне"/>
			      	</div>
			    </div>
			</form>
		</div>
	

<?php    
	}	
}
?>

</section>
</body>

</html>