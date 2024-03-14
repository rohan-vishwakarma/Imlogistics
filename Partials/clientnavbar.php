<?php

        function menus($parent_id, $link){
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" >

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background: #77d0c4 !important;">
  <div class="container-fluid">
    <a class="navbar-brand col-lg-3" href="/Imlogistics/Client/index.php">IM LOGISTICS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-lg-6" id="navbarSupportedContent">
      <ul class="navbar-nav col-lg-12 justify-content-lg-center">
           <li class="nav-item">
            <?php
            if(isset($_SESSION['client'])){
            ?>
                          <a class="nav-link active" style="    font-weight: 600; font-size: 17px;" aria-current="page" href="/Imlogistics/Client/index.php">HOME</a>

            <?php
            }else{
                ?>
                          <a class="nav-link active" aria-current="page" href="/Imlogistics/index.php">HOME</a>

            <?php
                
            }
           
            ?>
        </li>
          <?php
          
    
                
                    include '../connection.php';
                     
                    $sql = "select * from menu where parent_id='$parent_id' and visibility='show' and access='client' order by order_no ";
                    
                    $ex = $con->query($sql);
                    if(mysqli_num_rows($ex)>0){
                        while($row =mysqli_fetch_assoc($ex)){
                            
                            if($link ==  $row['link']){
                                ?>
                                <li class="nav-item">
                                  <a class="nav-link active"  aria-current="page" style="border-bottom: 3px solid;     font-weight: 600; font-size: 17px;" href="<?php echo $row['link']; ?>"><?php echo $row['name']; ?></a>
                                </li>
                                <?php
                            }else{
                                
                                 ?>
                            <li class="nav-item">
                              <a class="nav-link active"  style="    font-weight: 600; font-size: 17px;" aria-current="page" href="<?php echo $row['link']; ?>"><?php echo $row['name']; ?></a>
                            </li>
                            <?php
                            
                                
                            }
                            
                           
                        }
                    }
            

            ?>

   
      </ul>
    </div>
    
    <div class="collapse navbar-collapse col-lg-3" id="navbarSupportedContent">
      <form class="d-flex" role="search">
          
        <?php
        
        

        if(isset($_SESSION['client'])){
            ?>
            <a class="lii">Welcome, <?php echo $_SESSION['client']; ?><i class="fa fa-user-circle" aria-hidden="true"></i></a>
            <a class=" btn-danger" href="/Imlogistics/logout.php" style="border: 1px solid white; margin-left: 15px;color: unset;text-decoration: none;border-radius: 6px;background: #d5d3e1;">Logout</a>
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

<?php
}
?>




           
            
            
