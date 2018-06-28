<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2><?=$title;?></h2>
        
        <?php if(isset($errors) && is_array($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error"><?=$error;?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if(!$result): ?>
            <form action="" method="post">
                <div class="text">Оставьте свои данные, чтобы наш сотрудник связался с Вами</div>
                <input type="text" name="firstname" placeholder="Фамилия" value="<?=$firstname;?>"/><br>
                <input type="text" name="lastname" placeholder="Имя" value="<?=$lastname;?>"/><br>
                <input type="text" name="middlename" placeholder="Отчество" value="<?=$middlename;?>"/><br>
                <input type="tel" name="phone" placeholder="Номер телефона" value="<?=$phone;?>"/><br>
                <div class="block"><?=$email;?></div>
                <textarea name="comment" placeholder="Комментарий к заказу"><?=$comment;?></textarea><br>
                <div class="text">Количество товаров в заказе <b><?= Cart::countItems();?></b> на сумму <b><?=number_format($totalPrice, 2, ',', ' ');?></b> BYN</div>
                <button type="submit" name="submit" class="btn btn-default">Оформить</button>
            </form>
        <?php else: ?>
            Заказ оформлен. Наш сотрудник свяжется с Вами
            <br>Вы можете посмотреть <span class="red_text"><a href="/cabinet/orders">историю заказов</a></span>
        <?php endif; ?>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>