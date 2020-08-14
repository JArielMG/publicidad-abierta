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
    <h1>Welcome to CodeIgniter! Show me the grid!</h1>

    <div id="body">
        <?php $phpgrid->display(); ?>
    </div>

</div>

</body>
</html>