<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2>Кабинет</h2>
        <br>
        
        <div class="col-md-6 text-left">
            <br>
            <p>Привет <b><?=$_SESSION['user']['login'];?></b> (id = <?=$_SESSION['user']['id'];?>)</p>
            <p>Ваша почта: <b><?=$_SESSION['user']['email'];?></b></p>
            <p>Дата регистрации: <b><?=$_SESSION['user']['date_reg'];?></b></p>
        </div>
        <div class="col-md-6 text-left">
            <a href="/cabinet/edit" class="a_color">Редактировать данные</a>
            <a href="/cabinet/orders" class="a_color">Список покупок</a>
            <?php if($_SESSION['user']['typeuser'] == 2): ?>
                <a href="/admin" class="a_color">Админ панель</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>