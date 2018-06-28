<?php include_once ROOT.'/view/admin/layouts/header.php';?>
<br>
<div class="container">
    <div class="col-md-12 user text-left">
        
        <h2><?=$title;?></h2>
        <br>
        <h4>Приветствую, администратор <b><?=$_SESSION['user']['login'];?></b></h4>
        <br>
        
        <a href="/admin/products" class="a_color">Управление товарами</a>
        
        <a href="#" class="a_color">Управление категориями</a>
        
        <a href="#" class="a_color">Управление заказами</a>
        
        <a href="#" class="a_color">Управление новостями</a>
        
        <div class="clearfix"></div>
        
        <div class="col-md-12 text-left">
            <br>

            <br><b>План работ:</b>
            <br> 1) Письмо на почту о заказе слать списку админов
            <br><font color="blue"> 2) Записывать IP пользователей</font>
            <br> 3) Запоминать последнюю дату входа пользователей
            <br> 4) Список покупок/список товаров
            <br> 5) Админка -> Управление категориями
            <br> 6) Админка -> Управление заказами
            <br> 7) Админка -> Управление новостями
            <br> 8) Навести порядок в категориях, и переставить в header-е
            <br> 9) Страницы: Обо мне, ФАК, Правила, Видео и другие
            <br>10) Сами новости
            <br>11) Наполнение контентом сайт: товары
            <br>12) Сделать сортировку продуктов к примеру по дате добавления(сделать), по наименованию, по цене
            
            
            <br>
            <br>
            <br><b>Полезные материалы:</b>
            <br><a class="a_red" href="https://www.youtube.com/watch?v=FRBHXtyOoYM">Работа с изображениями</a>
            <br><a class="a_red" href="http://php.net/manual/ru/function.imagecolortransparent.php">Сделать изображение прозрачным</a>
            <br>Если добавлять скидки, то вот пример: <span class=" price-in"><small>$500.00</small> $400.00</span>
        </div>

    </div>
</div>
<br>
<?php include_once ROOT.'/view/admin/layouts/footer.php';?>