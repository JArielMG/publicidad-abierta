<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Show Grid</title>
</head>
<body>

<div id="container">
    <h1>show me the grid!</h1>

    <div id="body">
        <?php //$phpgrid->display(); ?>
        <?php 
         	foreach ($rows as $row):
         		foreach($row as $key => $value) {
				    echo " <b>" . $key . ":</b> " . $value;
				}
            	echo "<br><br><br>"; 
            endforeach; 
		?>
    </div>
</div>

</body>
</html>