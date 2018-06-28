<?php include_once ROOT.'/view/admin/layouts/header.php';?>
<?php include_once ROOT.'/view/admin/layouts/menuadmin.php';?>
<br>
<div class="container">
    <div class="col-md-12 user text-left">
        
        <h2><?=$title;?></h2>
        
        <form action="" method="post">
            Вы уверены, что хотите удалить изображение "<?=$image;?>.jpg" товара "<?=$product['name'];?>"?<br>
            <button type="submit" name="submit" class="btn btn-default">Удалить</button>
        </form>
    </div>
</div>
<br>
<?php include_once ROOT.'/view/admin/layouts/footer.php';?>