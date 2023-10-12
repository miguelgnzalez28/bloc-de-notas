<?php

$text = $_POST['text'];

$path=$_GET['id'];

file_put_contents($path,$text);

echo'<script type="text/javascript">
    alert("Contenido actualizado");
    window.location.href="index.php";
    </script>';
?>