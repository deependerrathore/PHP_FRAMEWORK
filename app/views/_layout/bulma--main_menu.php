<?php 
    $menu = Router::getMenu('menu_acl');
    $currentPage=  currentPage();
?>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="<?=PROJECT_ROOT?>home">
    <?=MENU_BRAND?>
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="main_menu" class="navbar-menu">
    <div class="navbar-start">
      <?php foreach($menu as $key => $value): $active= '';?>
      <?php if(is_array($value)):?>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
        <?= $key ?>
        </a>
        <div class="navbar-dropdown">
            <?php foreach($value as $k => $v): 
                          $active = ($v == $currentPage)? 'is-active': '';?>

            <?php if($k == 'separator'):?>
              <hr class="navbar-divider">
            <?php else: ?>
              <a class="navbar-item <?=$active?>" href="<?=$v?>">
                <?=$k?>
              </a>         
            <?php endif;?>

          <?php endforeach;?>
        </div>

      </div>
          

        <?php else: $active = ($value == $currentPage)?'is-active':'';?>
          <a class="navbar-item <?=$active?>"  href="<?=$value?>">
            <?=$key?>
          </a>
        <?php endif;?>
      <?php endforeach; ?>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <?php if(currentUser()):?>
              
              <a class="navbar-item" href="#">Hello <?=currentUser()->fname;?></a>

              <a class="button is-primary" href="<?=PROJECT_ROOT?>register/logout">
                  <strong>Log Out</strong>
              </a>
          <?php else: ?>
              <a class="button is-primary" href="<?=PROJECT_ROOT?>register/register">
                  <strong>Sign up</strong>
              </a>
              <a class="button is-light" href="<?=PROJECT_ROOT?>register/login">
                  Log in
              </a>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</nav>