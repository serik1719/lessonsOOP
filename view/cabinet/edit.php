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
                <input type="tel" name="phone" placeholder="Номер телефона" value="<?=$phone;?>"/><br>
                <input type="password" name="password" placeholder="Пароль" value="<?=$password;?>"/><br>
                <input type="password" name="repassword" placeholder="Повторите пароль" value="<?=$repassword;?>"/><br>
                <button type="submit" name="submit" class="btn btn-default">Сохранить</button>
            </form>
        <?php else: ?>
            Данные успешно сохранены
        <?php endif; ?>
        
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>