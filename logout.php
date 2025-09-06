
<?php
session_start();
session_destroy();
header('Location: /gerenciador_de_estoque/index.php');
exit();
