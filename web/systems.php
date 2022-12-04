<!DOCTYPE html>
<html lang="en">
<?php require_once("php/templates.php");
    mainTemplate::head();
 ?>
<body id="page">
    <?php mainTemplate::header(); ?>

    <section id="container" class="container text-center">

<!-- 
	<div class="container">
	  <div class="row">
	    <div class="col">Column</div>
	    <div class="col">Column</div>
	    <div class="w-100"></div>
	    <div class="col">Column</div>
	    <div class="col">Column</div>
	  </div>
	</div> -->
<?php         
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1)     {
?>

	<div class="container">
	  <div class="row">
	    <div class="col-1 border">#</div>
	    <div class="col-2 border">Име</div>
	    <div class="col-2 border">Платна</div>
	    <div class="col-2 border">Ленти</div>
	    <div class="col-5 border">Визуализация</div>
	  </div>
  		<?php 
  			function generateCol($content, $size = 2) {
  				if($size == NULL) {
					return '<div class="col border">'.(string)$content.'</div>';
  				}
			  	// echo '<div class="col-'.(string)$size.' border">'.(string)$content.'</div>';
			  	return '<div class="col-'.(string)$size.' border">'.(string)$content.'</div>'. PHP_EOL;
			}
			require_once("php/DB_traffic_system.php");
			$dbTrafficSystem = new DBTrafficSystem();
			$dbPlatna = new DBPlatna();
			$dbLenti = new DBLenti();
			$systems = $dbTrafficSystem->getAll();
			foreach ($systems as $key => $system) {
				echo "<div class='row'>". PHP_EOL;

				echo generateCol($system["id"], 1);
				echo generateCol($system["name"], 2);
				$defaultCombinatedColumnsContent = '<div class="row border">'. PHP_EOL.' <div class="col border">'. PHP_EOL.'01</div>'. PHP_EOL.'<div class="col border">02</div>'. PHP_EOL.'</div>'. PHP_EOL;

				$platna = $dbPlatna->getBySystem($system["id"]);
				$combinatedColumnsContent = "";
				foreach ($platna as $key => $platno) {

					$combinatedColumnsContent .= '<div class="row border">'. PHP_EOL;
					$combinatedColumnsContent .= generateCol($platno["discription"],NULL);

					$lenti = $dbLenti->getByPlatnoId($platno["id"]);
					$nastedColContent = "";
					foreach ($lenti as $key => $lenta) {

						$nastedColContent .= '<div class="row border">'. PHP_EOL;
						$nastedColContent .= generateCol($lenta["direction"], NULL);

						
						$nastedColContent .= '</div>'. PHP_EOL;
					}
					if(empty($lenti)) {
						$nastedColContent = "nzzzz";
					} else {
						
					}
					$combinatedColumnsContent .= generateCol($nastedColContent,NULL);

					$combinatedColumnsContent .= '</div>'. PHP_EOL;
					// echo generateCol($combinatedColumnsContent, 4);
					// echo $combinatedColumnsContent;	

				}
				if(empty($platna)) {
					// echo generateCol("size = 0");
					// echo generateCol("size = 0");
					// $combinatedColumnsContent = $defaultCombinatedColumnsContent;
					echo generateCol($defaultCombinatedColumnsContent, 4);
				} else {
					echo generateCol($combinatedColumnsContent, 4);
				}


				// echo "ppp";
				// echo generateCol($combinatedColumnsContent, 4);
				// echo "ppp";
				echo generateCol("Визуализация", NULL);
				echo "</div>". PHP_EOL;
			}
	    ?>
	</div>


    </section>

  </br>
  </br>
  </br>
  </br>
  </br>	

    <section id="container" class="container text-center">
         <!-- 
            <div class="container">
              <div class="row">
                <div class="col">Column</div>
                <div class="col">Column</div>
                <div class="w-100"></div>
                <div class="col">Column</div>
                <div class="col">Column</div>
              </div>
            </div> -->
         <div class="container">
            <div class="row">
               <div class="col-1 border">#</div>
               <div class="col-2 border">Име</div>
               <div class="col-2 border">Платна</div>
               <div class="col-2 border">Ленти</div>
               <div class="col-5 border">
                  <div class="row">adsasd</div>
                  <div class="row">adssa2</div>
                  Визуализация
               </div>
            </div>
            <div class='row'>
               <div class="col-1 border">1</div>
               <div class="col-2 border">Име</div>
               <div class="col-4 border">
               	
	               <div class="row border">
	               	<div class="col border">GM-Paradais</div>
	               	<div class="col border">
	               		<div class="row border">
	               			<div class="col border">mid</div>
	               		</div>
               			<div class="row border">
	               			<div class="col border">ledft/mid</div>
	               		</div>
	               	</div>
	               </div>
	               <div class="row border">GM-Paradais</div>
               </div>
               <div class="col-7 border">Визуализация</div>
            </div>
            <div class='row'>
               <div class="col-1 border">2</div>
               <div class="col-2 border">size = 0</div>
               <div class="col-2 border">size = 0</div>
               <div class="col-5 border">Визуализация</div>
            </div>
         </div>
      </section>

		</br></br>
		<h2>Добави Избираема Дисциплина към записаните</h2>
		<form class="form-horizontal" action="php/add_id.php" method="POST">
		    <div class="form-group">
		      	<label class="control-label col-sm-2" for="email">Име на дисциплината:</label>
		      	<div class="col-sm-9">
		        <input name="idname" id="tb-idname" class="form-control" placeholder="Enter id name" type="text">
		      	</div>
		        </label>
		      	<label class="control-label col-sm-2" for="email">Брой кредити:</label>
		      	<div class="col-sm-9">
		        <input name="credits" id="tb-credits" class="form-control" type="number" placeholder="Enter credits">
		      	</div>
		        </label>
		    </div>
		    <div class="form-group">        
		      	<div class="col-sm-offset-2 col-sm-10">
		        	<input type="submit" class="btn btn-default" value="Добави"/>
		      	</div>
		    </div>
		</form>
<?php         
}
?>
</body>

</html>