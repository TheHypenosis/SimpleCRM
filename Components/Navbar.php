<?php
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$x = pathinfo($url);
$selected = $x['filename'] ;
?>

<!-- Navbar -->
<!-- Left Side -->
<nav class="navbar navbar-light navbar-expand-lg bg-light m-3 sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="Dashboard.php">
      <img
        src="img/project.png" height="30";
      />
    </a>
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php if ($selected == "Dashboard") echo 'active'; ?>" aria-current="page" href="Dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($selected == "Projects") echo 'active'; ?>" href="Projects.php">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($selected == "Teams") echo 'active'; ?>" href="Teams.php">Teams</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($selected == "Members") echo 'active'; ?>" href="Members.php">Members</a>
        </li>
    </ul>
<!-- Right Side -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle hidden-arrow"
          href="#"
          id="navbarDropdownMenuLink"
          role="button"
          data-mdb-toggle="dropdown"
          aria-expanded="false"
        >
          <i class="fas fa-bell"></i>
          <span class="badge rounded-pill badge-notification bg-danger">1</span>
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdownMenuLink"
        >
          <li>
            <a class="dropdown-item" href="#">Some news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Another news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Something else here</a>
          </li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle d-flex align-items-center"
          href="#"
          id="navbarDropdownMenuLink"
          role="button"
          data-mdb-toggle="dropdown"
          aria-expanded="false"
        >
        <i height="22" class="fas fa-user-alt"></i>
        </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="#">My profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="../spm/Modules/Logout.php">Logout</a>
            </li>
          </ul>
      </li>
    </ul>
    </div>
  </div>
</nav>
<!-- Navbar -->
