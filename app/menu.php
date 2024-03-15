<?php
$paginaLink = !empty($_SERVER['QUERY_STRING']) ? htmlspecialchars(trim($_SERVER['QUERY_STRING'])) : '';
?>

<div class="responsive-admin-menu">
  <div class="responsive-menu">MyRouter
    <div class="menuicon"><i class="fa fa-angle-down" tabindex="0"></i></div>
  </div>

  <ul id="menu">
    <li>
      <a class="<?php if($paginaLink == 'app=Dashboard') {echo 'active';} ?>" href="index.php?app=Dashboard" title="Dashboard">
        <i class="entypo-monitor "></i>
        <span>Dashboard</span>
      </a>
    </li>

    <?php
    switch ($paginaLink) {
      case 'app=Page1':
        echo '<li><a class="' . ($paginaLink == 'app=Page1' ? 'active' : '') . '" href="index.php?app=Page1" title="Page 1">Page 1</a></li>';
        break;
      case 'app=Page2':
        echo '<li><a class="' . ($paginaLink == 'app=Page2' ? 'active' : '') . '" href="index.php?app=Page2" title="Page 2">Page 2</a></li>';
        break;
      // Add more cases as needed
