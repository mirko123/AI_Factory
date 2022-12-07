<?php 
class mainTemplate 
{
	public static function head() {
        $bootstrapLinks = '
            <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">';
        $bootstrapLinks = '
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
		session_start();
		echo '<head><title>Smart traffic light</title>';
        echo $bootstrapLinks;
        echo '
            <link rel="stylesheet" href="css/main.css">
            <link rel="stylesheet" href="js/jquery.timeline-master/dist/timeline.min.css">
            <script src="js/jquery.timeline-master/dist/timeline.min.js"></script>
            <meta charset="UTF-8">';

        echo '</head>';




   //      echo '
   //  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   // <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   //  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
   //  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        // ';
	}

	public static function header(){
		echo '<header id="header">
			    <h1>Умен светофар</h1>
			    	<nav class="navbar navbar-default">
			    	<ul class="nav navbar-nav" id="main-nav">';

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1)     {
            echo '
                            <li class="systems">
                                <a href="systems.php">Светофарни системи</a>
                            </li>

                            <li class="systems">
                                <a href="uploadImage.php">Калибриране на каемра</a>
                            </li>

                            <li class="systems">
                                <a href="testUpload.php">Test upload</a>
                            </li>
                            ';
        }
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) 
	        echo '<li><a class="btn-nav-logout" href="logout.php">Изход</a></li>';

   		else {
   			echo '<li>
                    <a href="login.php">Вход</a>
                </li>
            </ul>';
   		}


        // echo '
        //         <li class="users">
        //             <a href="users.php">Студенти</a>
        //         </li>
        //         <li class="users">
        //             <a href="lectures.php">Преподаватели</a>
        //         </li>
        //         <li class="ids">
        //             <a href="discipline.php">ИД</a>
        //         </li>';
        // if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) 
        //     echo '<li><a href="profile.php?type='.$_SESSION['type'].'&username='.$_SESSION['username'].'">Профил</a></li>
        //           <li><a class="btn-nav-logout" href="logout.php">Изход</a></li>';

        // else {
        //     echo '<li>
        //             <a href="login.php">Вход</a>
        //         </li>
        //         <li>
        //             <a href="register.php">Регистрация</a>
        //         </li>
        //     </ul>';
        // }

		echo "</nav></header>";
   	}
}
 ?>













