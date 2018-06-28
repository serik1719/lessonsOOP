<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2><?=$title;?></h2>
        
        <?php if(isset($errors) && is_array($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error"><?=$error;?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="login" placeholder="Логин" value="<?=$login;?>"/><br>
            <input type="password" name="password" placeholder="Пароль" value="<?=$password;?>"/><br>
            <img src="/components/captcha.php" alt="Капча" id="captcha_img"><br>
            <input type="text" name="captcha" placeholder="Проверочный код"><br>
            <button type="submit" name="submit" class="btn btn-default">Авторизация</button>
        </form>
        
        <a href="/restore"><h6>Востановить пароль</h6></a>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>