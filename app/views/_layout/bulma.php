<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css.map">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=PROJECT_ROOT;?>css/custom.css">
    <script src="<?=PROJECT_ROOT;?>js/jquery-3.3.1.min.js"></script>
    <title><?= $this->getSiteTitle(); ?></title>
    <?=$this->content('head');?>
</head>
<body>
    <?php include('bulma--main_menu.php'); ?>
    <div class="container-fluid" style="min-height:cal(100% - 125px);">
        <?=$this->content('body');?>
    </div>
</body>
</html>