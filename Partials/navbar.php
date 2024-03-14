<?php



?>

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: transparent  !important;">
  <div class="container-fluid">
    <a class="navbar-brand" href="" style="color: white">IM LOGISTICS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <?php
            if(isset($_SESSION['user'])){
            ?>
                          <a class="nav-link active" aria-current="page" href="/Imlogistics/welcome.php">Home</a>

            <?php
            }else{
                ?>
                          <a class="nav-link active" aria-current="page" href="/Imlogistics/index.php">Home</a>

            <?php
                
                
            }
            
            ?>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">About us</li></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
          
        <?php
        
        

        if(isset($_SESSION['user'])){
            ?>
            <a class="lii">Welcome, <?php echo $_SESSION['user']; ?><i class="fa-light fa-user"></i></a>
            <a class=" btn-danger" href="/Imlogistics/logout.php" style="border: 1px solid white; margin-left: 15px;color: unset;text-decoration: none;border-radius: 6px;background: #d5d3e1;">Logout</a>
            <?php
        }else{
            ?>
            <a class="lii" href="/Imlogistics/Auth/Admin/admin_login.php">Admin</a>
        <a href="#" style="visibility: hidden;">...</a>
        <a class="lii" href="/Imlogistics/Auth/Client/client_login.php">Client</a>
            
            <?php
            
        }
        
        ?>
   
        
      </form>
    </div>
  </div>
</nav>



<style>
.lii {
    background: #ecebef;
    text-decoration: none;
    padding: 3px;
    letter-spacing: 2px;
    color: black;
    border-radius: 6px;
}
</style>