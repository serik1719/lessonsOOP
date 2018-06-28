<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="contact">
        <h2><?=$title;?></h2>
        <div class="contact-in">
            <div class=" col-md-3 contact-right">
                <h5>Контактная информация</h5>
                <p>Студия разработки сайтов Сергея Гапановича,</p>
                <p>Беларусь</p>
                <p>г.Барановичи ул.Кирова</p>
                <p>Телефон: <a href="tel:+375(29)826-19-97">+375(29)826-19-97</a></p>
                <p>Email: <a href="mailto:serik1719@mail.ru">serik1719@mail.ru</a></p>
                <p>Я в социальных сетях: </p>
                <p><a href="https://vk.com/serik1719" target="_blank">ВКонтакте</a>, <a href="https://www.facebook.com/profile.php?id=100001987831186" target="_blank">Facebook</a>, <a href="https://twitter.com/serik1719" target="_blank">Twitter</a></p>
            </div>
            <div class=" col-md-9 contact-left">
                
                <?php if(isset($errors) && is_array($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <div class="error"><?=$error;?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <?php if(!$result): ?>
                    <form action="" method="post">
                        <input name="login" placeholder="Логин" type="text" class="textbox" value="<?=$login;?>">
                        <input name="email" placeholder="E-mail" type="text" class="textbox" value="<?=$email;?>">
                        <textarea name="text" placeholder="Текст сообщения"><?=$text;?></textarea>
                        <img src="/components/captcha.php" alt="Капча" id="captcha_img">
                        <input type="text" name="captcha" placeholder="Проверочный код">
                        <button type="submit" name="submit" class="btn btn-default">Отправить</button>
                    </form>
                <?php else: ?>
                    <br><br><h4>Спасибо за ваше сообщение, я постараюсь ответить побыстрее, но эффективнее будет написать мне <a href="https://vk.com/serik1719" target="_blank">ВКонтакте.</a></h4>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2392.8803599265457!2d26.0370727161508!3d53.148241679937904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46d8d03dc60f04b9%3A0xdb43e14dfbef148!2z0YPQuy4g0JrQuNGA0L7QstCwLCDQkdCw0YDQsNC90L7QstC40YfQuA!5e0!3m2!1sru!2sby!4v1493243392234" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>