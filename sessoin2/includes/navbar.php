<style>
  .navbar-brand {
    margin-left: 346px;
  }

  .btn-outline-success {
    margin-left: 130px;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="navbar-brand" style="color:mediumblue ;">
        <?=
        $_SESSION['fullname'];
        ?>
      </li>
      <li class="nav-item">

        <a class="nav-link" href="admins">admins</a>

      </li>
      <li class="nav-item">

        <a class="nav-link" href="members">members</a>

      </li>
      <li class="nav-item">

        <a class="nav-link" href="products">products</a>

      </li>
      <li class="nav-item">

        <a class="nav-link" href="membesr.php?owners=admins">SHOW ALL</a>

      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>

        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>


      <li class="nav-item"> <a class="nav-link" href="logout.php">logout</a> </li>
      
    

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>