<!DOCTYPE html>
<html lang="en">
<?php require_once("php/templates.php");
    mainTemplate::head();
 ?>
<body id="page">
    <?php mainTemplate::header(); ?>

    <section id="container" class="container text-center">
    </section>
	<?php 

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1)     {
		header('Location: systems.php');
	}
	else {
		header('Location: login.php');
	}
	 ?>
</body>

</html>