<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="text-center"><h2><?=$title;?></h2></div>
    <br><br>
    <?php if (!empty($latesProducts)): ?>
        <?php foreach ($latesProducts as $product):?>
            <div class="col-md-3 blue">
                <div class="col-md-12 name"><h4><a href="/product/<?=$product['id']?>"><?=$product['name']?></a></h4></div>
                <a href="/product/<?=$product['id']?>">
                    <img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'catalog');?>" class="img-responsive" alt="">
                </a>			 	
                <div class="grid_1 simpleCart_shelfItem">
                    <a href="" class="cup item_add" data-id="<?=$product['id'];?>">
                        <span class="item_price"><?=number_format($product['price'], 2, ',', ' ');?> BYN 
                            <i></i>
                        </span>
                    </a>					
                </div>
                <br><br>
            </div>
        <?php endforeach;?>
    <?php else: ?>
        <h4>В данной категории нет товаров!</h4>
    <?php endif; ?>
    <div class="clearfix"></div>
    <?=$pagination->get();?>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>