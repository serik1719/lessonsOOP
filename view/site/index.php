<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="banner">
    <div class="container">	
        <div class="wmuSlider example1">
            <div class="wmuSliderWrapper">
                <?php foreach ($latesProducts1 as $key => $product) :?>
                    <?php if ($key % 2 != 1): ?>
                    <article style="position: absolute; width: 100%; opacity: 0;">
                        <div class="banner-wrap">
                    <?php endif; ?>
                            <?php if ($key % 2 != 1): ?>
                            <div class="banner-top">
                            <?php else: ?>
                            <div class="banner-top banner-bottom">    
                            <?php endif; ?>
                                <a href="/product/<?=$product['id']?>">
                                    <?php if ($key % 2 != 1): ?>
                                    <div class="banner-top-in">
                                    <?php else: ?>
                                    <div class="banner-top-in at">    
                                    <?php endif; ?>
                                        <img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'index1', 225, 280);?>" class="img-responsive" alt=""/>
                                    </div>
                                </a>
                                <div class="cart-at grid_1 simpleCart_shelfItem">
                                    <div class="item_add" data-id="<?=$product['id'];?>"><a href="#"><span class="item_price"><?=number_format($product['price'], 2, ',', ' ');?> BYN<i></i></span></a></div>
                                    <div class="off">
                                        <label> - 35% </label>
                                        <p><?=$product['name'];?></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                    <?php if ($key % 2 != 1): ?>
                    <?php else: ?>
                            <div class="clearfix"> </div>
                        </div>
                    </article>
                    <?php endif; ?>
                <?php endforeach;?>
            </div>
            <ul class="wmuSliderPagination">
                <li><a href="#" class="">0</a></li>
                <li><a href="#" class="">1</a></li>
                <li><a href="#" class="wmuActive">2</a></li>
            </ul>
        </div>
        <script src="/template/js/jquery.wmuSlider.js"></script> 
        <script>
            $('.example1').wmuSlider({
                pagination : true,
                nav : false,
            });
        </script>	
    </div>   
</div>

<div class="content">
    <div class="container">
        <div class="content-top">
            <h2 class="text-center">НОВОЕ</h2>
            <div class="pink">
		<link href="/template/css/owl.carousel.css" rel="stylesheet">
                <script src="/template/js/owl.carousel.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#owl-demo").owlCarousel({
                            items : 4,
                            lazyLoad : true,
                            autoPlay : true,
                            pagination : true,
                        });
                    });
                </script>
                <div id="owl-demo" class="owl-carousel text-center">
                    <?php foreach ($latesProducts2 as $product):?>
                        <div class="item">
                            <div class=" box-in">
                                <div class="col-md-12 name">
                                    <a href="/product/<?=$product['id']?>">
                                        <h4><?=$product['name']?></h4>
                                        <img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'catalog');?>" class="img-responsive" alt="">
                                    </a>
                                </div>
                                <div class="grid_1 simpleCart_shelfItem">
                                    <a href="#" class="cup item_add" data-id="<?=$product['id'];?>"><span class=" item_price" ><?=number_format($product['price'], 2, ',', ' ');?> BYN<i> </i> </span></a>					
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        
	<div class="content-middle">
            <h2 class="text-center">РЕКОМЕНДУЕМОЕ</h2>
            <div class="col-best">
                <?php foreach ($latesProducts3 as $product):?>
                    <div class="col-md-4">
                        <div class="col-in">
                            
                            <div class="col-md-5">
                                <a href="/product/<?=$product['id'];?>">
                                    <img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'index3', 90, 120);?>" class="img-responsive" alt="">
                                </a>
                            </div>
                            
                            <div class="col-md-7">
                                <div class="col-in-right grid_1 simpleCart_shelfItem">
                                    <a href="/product/<?=$product['id'];?>">
                                        <h5><?=$product['name']?></h5>
                                    </a>
                                    <ul class="star">
                                        <li><a href="#"><i></i></a></li>
                                        <li><a href="#"><i></i></a></li>
                                        <li><a href="#"><i></i></a></li>
                                        <li><a href="#"><i></i></a></li>
                                        <li><a href="#"><i></i></a></li>
                                        <!--li><i class="in-star"></i></li-->
                                    </ul>
                                    <a href="#" class="item_add" data-id="<?=$product['id'];?>"><span class="white item_price" ><?=number_format($product['price'], 2, ',', ' ');?> BYN <i> </i> </span></a>
                                </div>
                            </div>
                            
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                <?php endforeach;?>
                <div class="clearfix"> </div>
            </div>
	</div>
                
        <div class="content-bottom">
            <div class="col-md-7 latter">
                <h6>НОВОСТНАЯ РАССЫЛКА</h6>
                <p>Получи скидку прямо сейчас!</p>
                <div class="clearfix"> </div>
            </div>
            <div class="col-md-5 latter-right">
                <form action="#" method="post">
                    <div class="join">
                        <input type="text" value="Ваша электронная почта" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Ваша электронная почта';}">
                        <i></i>
                    </div>
                    <input type="submit" value="Получить">
                </form>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>