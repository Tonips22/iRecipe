<?php
require '../../includes/templates/header.php';
$receta = Receta::find($_GET["id"]);
if($receta->eliminar()){
    header("Location: /admin/admin.php");

}
?>

<?php require '../../includes/templates/footer.php' ?>