<?php 
$dynamicPath = $_GET['id'];
$contentData = file_get_contents($dynamicPath);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0yXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .centered-text{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .centered-textarea{
            display:block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <h1 class="title">Editor de texto</h1> <br>
    <form action="update.php?id=<?php echo $dynamicPath;?>" method="post">
        <textarea class="textarea" id="text" name="text" rows="20" cols="100"><?php echo $contentData ?> </textarea> <br><br>
        <div class="text-left">
            <input type="submit" value="Actualizar" class="btn btn-primary">
            <a href="index.php" class="btn btn-info">Regresar</a>
        </div>
    

    </form>
  
</body>
</html>
