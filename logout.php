<?php


session_start();
unset($_SESSION['user']);
unset($_SESSION['client']);
?>

<script>
    window.location.href='/Imlogistics/index.php';
</script>

<?php

?>