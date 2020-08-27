<?php

	//Load a class file containing all functionalities
	require_once "class.php";

	//Creating a new object from main class
	$db = new zadanieDB;

	//Connecting to the database
	$db->connect();

?>

<!DOCTYPE html>

<?php
	//Head
	include "components/modules/head.php";
?>

<body class="bg-dark text-white">

	<?php

		//If user is logged in
		if (isset($_COOKIE['user'])) {

			//Navbar module
			include "components/modules/navbar.php";

			//Lucky portal module
			include "components/modules/portal.php";
		
			echo "<section class='container'>";
			
				//Search form
				include "components/modules/search_form.php";

				//Characters module
				include "components/modules/characters.php";
			
			echo "</section>";
		}
		else {

			//If user is not logged in, put this
			include "components/modules/logout.php";
		}
	
	?>
</body>

</html>