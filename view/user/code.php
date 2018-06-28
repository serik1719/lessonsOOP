<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2><?=$title;?></h2>
        
        <?php if(isset($errors) && is_array($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error"><?=$error;?></div>
            <?php endforeach; ?>
        <?php endif; ?>
                
        <?php if(isset($result)): ?>
            <?php if(!$result): ?>
                <form action="" method="post">
                    <input type="password" name="password" placeholder="Пароль" value="<?=$password;?>"/><br>
                    <input type="password" name="repassword" placeholder="Повторите пароль" value="<?=$repassword;?>"/><br>
                    <button type="submit" name="submit" class="btn btn-default">Установить пароль</button>
                </form>
            <?php else: ?>
                Пароль востановлен, теперь можете <span class="red_text"><a href="/login">войти</a></span> в аккаунт
            <?php endif; ?>
        <?php else: ?>
            Код не верный, или устарел.
        <?php endif; ?>
        
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>