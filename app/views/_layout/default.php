<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?=PROJECT_ROOT;?>css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
    <link rel="stylesheet" href="<?=PROJECT_ROOT;?>css/custom.css">
    <script src="<?=PROJECT_ROOT;?>js/jquery-3.3.1.min.js"></script>
    <script src="<?=PROJECT_ROOT;?>js/bootstrap.min.js"></script>
    <title><?= $this->getSiteTitle(); ?></title>
    <?=$this->content('head');?>
</head>
<body>
    <?php include('main_menu.php'); ?>
    <div class="container-fluid" style="min-height:cal(100% - 125px);">
        <?=$this->content('body');?>
    </div>
</body>
</html>