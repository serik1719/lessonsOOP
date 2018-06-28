<?php include_once ROOT.'/view/admin/layouts/header.php';?>
<?php include_once ROOT.'/view/admin/layouts/menuadmin.php';?>
<br>
<div class="container">
    <div class="col-md-12 user text-left">
        
        <h2><?=$title;?></h2>
        <div class="col-md-12">
            <a href="/admin/product/add" class="a_color"><img src="../../../template/images/create.png"> Добавить товар</a>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="col-md-12">
            <br>
            <h4>Список Товаров</h4>
            
            <br>
            <table class="cart_table">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена, BYN</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><a href="/template/images/products/<?=Product::getMainImage($product['id']);?>.jpg"><img src="<?=Image::getMiniImage(Product::getMainImage($product['id']), 'admin_product_index', 70, 70);?>"></a></td>
                        <td><?=$product['id'];?></td>
                        <td><?=$product['code'];?></td>
                        <td><a href="/product/<?=$product['id'];?>"><?=$product['name'];?></a></td>
                        <td><?= Category::getNameCategory($product['category_id']);?></td>
                        <td><?=number_format($product['price'], 2, ',', ' ');?></td>
                        
                        <td><?php if($product['status'] == 0) echo 'Скрыт'; ?></td>
                        <td><a href="/admin/product/edit/<?=$product['id'];?>"><img src="../../../template/images/edit.png"></a></td>
                        <td><a href="/admin/product/delete/<?=$product['id'];?>"><img src="../../../template/images/close_1.png"></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
        </div>
        
        <div class="clearfix"></div>
        <?=$pagination->get();?>
    </div>
</div>
<br>
<?php include_once ROOT.'/view/admin/layouts/footer.php';?>