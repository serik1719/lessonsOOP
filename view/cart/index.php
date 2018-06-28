<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-left">
        
        <h2><?=$title;?></h2>
        
        <?php if($products): ?>
            <br>
            <h4>Вы выбрали такие товары:</h4>
            <br>
            <table class="cart_table">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Код товара</th>
                    <th>Название</th>
                    <th>Цена (BYN.)</th>
                    <th>Количество (шт.)</th>
                    <th>Стоимость (BYN.)</th>
                    <th>Отнять</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <?php if(is_array($product)): ?>
                        <tr>
                            <td><a href="/template/images/products/<?=Product::getMainImage($product['id']);?>.jpg"><img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'cart', 100, 100);?>"></a></td>
                            <td><?=$product['id'];?></td>
                            <td><?=$product['code'];?></td>
                            <td>
                                <a href="/product/<?=$product['id'];?>">
                                    <?=$product['name'];?>
                                </a>
                            </td>
                            <td><?=number_format($product['price'], 2, ',', ' ');?></td>
                            <td><?=$productsInCart[$product['id']];?></td>
                            <td><?=number_format($productsInCart[$product['id']]*$product['price'], 2, ',', ' ');?></td>
                            <td><a href="/cart/minus/<?=$product['id'];?>"><img src="../../template/images/cart-c.png"></a></td>
                            <td><a href="/cart/delete/<?=$product['id'];?>"><img src="../../template/images/close_1.png"></a></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td></td>
                            <td><?=$product;?></td>
                            <td></td>
                            <td>Продкут скрыт или удалён</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a href="/cart/delete/<?=$product;?>"><img src="../../template/images/close_1.png"></a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
            <br><h4>Общая стоимость: <b><?=number_format($totalPrice, 2, ',', ' ');?></b> BYN</h4>
            <div class="col-md-4"><a href="/cart/order" class="cart">Оформить заказ</a></div>
            <?php if(!isset($_SESSION['user'])): ?>
                <br>Для оформления заказа вам нужно будет <span class="red_text"><a href="/login">авторизоваться</a></span> на сайте
            <?php endif; ?>
        <?php else: ?>
            Корзина пуста
        <?php endif; ?>
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>