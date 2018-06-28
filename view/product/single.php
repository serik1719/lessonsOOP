<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="content">
    <div class="container">
        <div class="single">
            <div class="col-md-9 top-in-single">
                <div class="col-md-5 single-top">	
                    <ul id="etalage">
                        <?php foreach ($images as $image):?>
                            <li>
                                <img class="etalage_source_image img-responsive" src="/template/images/products/mini/single_mini/<?=$image;?>.jpg">
                                <img class="etalage_source_image img-responsive" src="/template/images/products/mini/single/<?=$image;?>.jpg">
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="col-md-7 single-top-in">
                    <div class="single-para">
                        <h4><?=$product['name'];?></h4>
                        <div class="star-on">
                                <p>Категория: <b><?=$categoryName;?></b></p>
                                <p>Код товара: <b><?=$product['code'];?></b></p>
                                <p>На складе: <b><?=$product['availability'];?></b> шт.</p>
                                <p>Бренд: <b><?=$product['brand'];?></b></p>
                            <div class="clearfix"> </div>
                        </div>
                        <label class="add-to"><?=$product['price'];?> BYN </label>
                        <a href="#" class="cart item_add" data-id="<?=$product['id'];?>">В корзину</a>
                    </div>
                </div>
                <div class="clearfix"> </div>
                
		<div class="sap_tabs">	
                    <ul class="resp-tabs-list">
                        <li class="resp-tab-item " aria-controls="tab_item-0" role="tab"><span>Описанте товара</span></li>
                        <div class="clearfix"></div>
                    </ul>				  	 
                    <div class="resp-tabs-container">
                        <div class="tab-1 resp-tab-content resp-tab-content-active" aria-labelledby="tab_item-0" style="display:block">
                            <div class="facts"><?=nl2br($product['description']);?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 at-single">
                <div class="single-bottom">
                    <h4>Твары из категории</h4>
                    <?php foreach ($listProducts as $product):?>
                        <div class="product-go">
                            <a href="/product/<?=$product['id'];?>">
                                <img class="img-responsive fashion" src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'single_category', 90, 90);?>" alt="">
                                <div class="grid-product">
                                    <?=$product['name'];?>
                                    <span class=" price-in"><?=number_format($product['price'], 2, ',', ' ');?> BYN</span>
                                </div>
                            </a>
                            <div class="clearfix"> </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="clearfix"></div>		
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($){
        $('#etalage').etalage({
            thumb_image_width: 300,
            thumb_image_height: 300,
            source_image_width: 700,
            source_image_height: 700
        });
    });
</script>

<?php include_once ROOT.'/view/layouts/footer.php';?>