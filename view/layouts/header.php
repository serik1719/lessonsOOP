<!DOCTYPE html>
<html>
<head>
<title><?=$title;?></title>
<link href="/template/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<script src="/template/js/jquery.min.js"></script>
<link href="/template/css/style.css" rel="stylesheet" type="text/css" media="all" />	
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Amaranth:400,700|Gabriela|Lobster&amp;subset=cyrillic" rel="stylesheet">
<script type="text/javascript" src="/template/js/move-top.js"></script>
<script type="text/javascript" src="/template/js/easing.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){		
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>

<link href="/template/css/megamenu.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" src="/template/js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>			
<link rel="stylesheet" href="/template/css/etalage.css">
<script src="/template/js/jquery.etalage.min.js"></script>

</head>
<body> 
<div class="header" >
    <div class="top-header" >		
        <div class="container">
            <div class="top-head" >
                <div class="header-para">
                    <ul class="social-in">
                        <li><a href="https://vk.com/serik1719"><i></i></a></li>						
                        <li><a href="https://vk.com/serik1719"><i class="ic"></i></a></li>
                        <li><a href="https://vk.com/serik1719"><i class="ic1"></i></a></li>
                    </ul>			
                </div>	
                <ul class="header-in">
                    <li><a href="/news">Новости</a></li>
                    <li><a href="/catalog">Товары</a></li>
                    <li><a href="/about">Обо мне</a></li>
                    <li><a href="/contacts">Контакты</a></li>
                    <li><a href="/faq">FAQ</a></li>
                </ul>
                <div class="search-top">
                    <div class="search">
                        <form>
                            <input type="text" value="Что ищем?" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Что ищем?';}">
                            <input type="submit" value="" >
                        </form>
                    </div>
                </div>
                <ul class="user">
                    <?php if(isset($_SESSION['user'])): ?>
                        <li><a href="/logout">Выход</a></li>
                        <li><a href="/cabinet">Кабинет</a></li>
                    <?php else: ?>
                        <li><a href="/login">Вход</a></li>
                        <li><a href="/register">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="header-top">
        <div class="container">
            <div class="head-top">
                <div class="logo">
                    <a href="/"><img src="/template/images/main-logoSG.png" alt=""></a>
                </div>
                <div class="top-nav">		
                    <ul class="megamenu skyblue">
                        <!-- Мебель и декор -->
                        <li><a href="#">Мебель & Декор</a>
                            <div class="megapanel">
                                <div class="row">
                                    <div class="col1">
                                        <div class="h_nav">
                                            <ul>
                                                <?php foreach ($categoriesList1 as $category):?>
                                                    <li><a href="/category/<?=$category['id']?>" class="active"><?=$category['name']?></a></li>
                                                <?php endforeach;?>
                                            </ul>	
                                        </div>							
                                    </div>
                                    <div class="col1"></div>
                                    <div class="col1">
                                        <iframe src="https://player.vimeo.com/video/16878818"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Электроника -->
                        <li class="grid"><a  href="#">Электроника</a>
                            <div class="megapanel">
                                <div class="row">
                                    <div class="col1">
                                        <div class="h_nav">
                                            <ul>
                                                <?php foreach ($categoriesList2 as $category):?>
                                                    <li><a href="/category/<?=$category['id']?>"><?=$category['name']?></a></li>
                                                <?php endforeach;?>
                                            </ul>	
                                        </div>							
                                    </div>
                                    <div class="col1"></div>
                                    <div class="col1">
                                        <div class="col1">
                                            <iframe src="https://player.vimeo.com/video/8118831"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> 
                                        </div>										
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Здоровье и красота -->
                        <li class="grid">
                            <a  href="/category/12">Здоровье & Красота</a>
                        </li>		
                    </ul> 
                </div>
                <div class="cart box_1">
                    <a href="/cart">
                    <h3>
                        <div class="total">
                            <span class="simpleCart_total"></span>Корзина (<span id="simpleCart_quantity" class="simpleCart_quantity"><?=Cart::countItems();?></span>)
                        </div>
                        <img src="/template/images/cart.png" alt=""/>
                    </h3>
                    </a>
                    <p><a href="/cart/clear" class="simpleCart_empty"><img src="/template/images/cart-c.png"  alt=""></a></p>
                    <div class="clearfix"> </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>