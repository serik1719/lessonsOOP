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
                <input type="text" name="email" placeholder="E-mail" value="<?=$email;?>"/><br>
                <img src="/components/captcha.php" alt="Капча" id="captcha_img"><br>
                <input type="text" name="captcha" placeholder="Проверочный код""><br>
                <button type="submit" name="submit" class="btn btn-default">Отправить код</button>
            </form>
        <?php else: ?>
            Ссылка для восстановления пароля была отправлена на указанный E-mail адрес <b><?=$result;?></b>.
        <?php endif; ?>
        
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>