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

	if($_METHOD && array_key_exists('roadwayId',$_METHOD))
	{

		$roadwayId = $_METHOD['roadwayId'];
		?>

		<div class="container">
			<h2>Добавяне на лента</h2>
			<form class="form-horizontal" action="systems.php" method="GET">
			    <div class="form-group">
			      	<label class="control-label col-sm-2" for="roadwayDiscription">Вид на лентата</label>
			      	<div class="col-sm-8">
			        <!-- <input name="direction" id="tb-idname" class="form-control" placeholder="Îïèñàíèå" type="text"> -->
			        <select class="form-control form-select form-select-lg mb-3" name="direction" aria-label=".form-select-lg example">
						<option selected value="mid">Само направо</option>
						<option value="mid/right">Направо и надясно</option>
						<option value="left/mid">Наляво и направо</option>
						<option value="left/right">Наляво и надясно</option>
						<option value="left">Само наляво</option>
						<option value="right">Само надясно</option>
						<option value="out">Изход</option>
					</select>
			        <?php 
			        echo '<input name="roadwayId" id="tb-idname" class="form-control" value="'.$roadwayId.'" type="hidden">'.PHP_EOL;
			         ?>
			        <input name="queryType" id="tb-idname" class="form-control" value="newLane" type="hidden">
			      	</div>
			        </label>
			      	<div class="	col-sm-1">
			        	<input type="submit" class="btn btn-success" value="Добави"/>
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