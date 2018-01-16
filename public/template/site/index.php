<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?=URL_HTTP?>">
<title>APP</title>
</head>
<body>

<div>
    <?php
        if(empty($this->url[0]))
        { require_once '../application/app/controller/home/index.php'; }
        else if($this->url[0])
        { require_once '../application/app/controller/'.$this->url[0].'/index.php'; }
    ?>
</div>

<footer>
</footer> 
</div><!--container-fluid-->
</body>
</html>

