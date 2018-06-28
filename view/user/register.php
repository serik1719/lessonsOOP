<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2><?=$title;?></h2>
        <?php if($result): ?>
            На почтовый ящик <b><?=$result;?></b> отправлена ссылка для активации аккаунта
        <?php else: ?>
            <?php if(isset($errors) && is_array($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error"><?=$error;?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <form action="" method="post">
                <input type="text" name="login" placeholder="Логин" value="<?=$login;?>"/><br>
                <input type="email" name="email" placeholder="E-mail" value="<?=$email;?>"/><br>
                <input type="password" name="password" placeholder="Пароль" value="<?=$password;?>"/><br>
                <input type="password" name="repassword" placeholder="Повторите пароль" value="<?=$repassword;?>"/><br>
                <img src="/components/captcha.php" alt="Капча" id="captcha_img"><br>
                <input type="text" name="captcha" placeholder="Проверочный код"><br>
                <button type="submit" name="submit" class="btn btn-default">Регистрация</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>