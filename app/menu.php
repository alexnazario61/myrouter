<?php $paginaLink = $_SERVER['QUERY_STRING'];?>
<!-- active: stores the current page link for highlighting the active menu item -->

<div class="responsive-admin-menu">
  <!-- container for the navigation menu -->

  <div class="responsive-menu">MyRouter
    <!-- title of the menu -->

    <div class="menuicon"><i class="fa fa-angle-down"></i></div>
    <!-- icon for displaying/hiding the submenu items -->
  </div>

  <ul id="menu">
    <!-- list for the navigation menu -->

    <li>
      <!-- menu item -->

      <a class="<?php if($paginaLink == 'app=Dashboard') {echo 'active';} ?>" href="index.php?app=Dashboard" title="Dashboard">
        <!-- link for the menu item -->

        <i class="entypo-monitor "></i>
        <span> Dashboard</span>
      </a>
    </li>

    <!-- More menu items follow... -->

  </ul>
</div>
