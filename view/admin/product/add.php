<?php include_once ROOT.'/view/admin/layouts/header.php';?>
<?php include_once ROOT.'/view/admin/layouts/menuadmin.php';?>
<br>
<div class="container">
    <div class="col-md-12 user admin text-left">
        
        <h2><?=$title;?></h2>
        
        <?php if(isset($errors) && is_array($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error"><?=$error;?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="lab">Наименование</div>
            <input type="text" name="name" placeholder="Наименование" value="<?=$options['name'];?>"/><br>
            
            <div class="lab">Категория</div>
            <select name="category_id">
                <?php if(is_array($categoriesList)): ?>
                    <?php foreach ($categoriesList as $category): ?>
                        <?php if($category['id'] == $options['category_id']): ?>
                            <option value="<?=$category['id'];?>" selected="selected"><?=$category['name'];?></option>
                        <?php else: ?>
                            <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select><br>
            
            <div class="lab">Код</div>
            <input type="number" name="code" placeholder="Код" max="999999" value="<?=$options['code'];?>"><br>
            
            <div class="lab">Цена, BYN</div>
            <input type="number" name="price" placeholder="Цена (BYN)" max="999999" step="0.01" value="<?=$options['price'];?>"><br>
            
            <div class="lab">Количество, шт.</div>
            <input type="number" name="availability" placeholder="Количество (шт.)" max="999999" step="1" value="<?=$options['availability'];?>"><br>
            
            <div class="lab">Бренд</div>
            <input type="text" name="brand" placeholder="Бренд" value="<?=$options['brand'];?>"/><br>
            
            <div class="lab">Изображения (*.jpg, *.jpeg, *.png)</div>
            <?php for($i = 1; $i <= AdminProductController::COUNT_DOWLOAD_IMAGES; $i++): ?>
                <input type="file" name="image[]">
            <?php endfor; ?>
            
            <div class="lab">Описание</div>
            <textarea name="description" placeholder="Описание"><?=$options['description'];?></textarea><br>
            
            <div class="lab">Новый</div>
            <select name="is_new">
                <option value="0" <?php if($options['is_new']==0){echo 'selected="selected"';}?>>Нет</option>
                <option value="1" <?php if($options['is_new']==1){echo 'selected="selected"';}?>>Да</option>
            </select>
            <br>
            
            <div class="lab">Рекомендуемые</div>
            <select name="is_recomendet">
                <option value="0" <?php if($options['is_recomendet']==0){echo 'selected="selected"';}?>>Нет</option>
                <option value="1" <?php if($options['is_recomendet']==1){echo 'selected="selected"';}?>>Да</option>
            </select>
            <br>
            
            <div class="lab">Статус</div>
            <select name="status">
                <option value="0" <?php if($options['status']==0){echo 'selected="selected"';}?>>Скрыт</option>
                <option value="1" <?php if($options['status']==1){echo 'selected="selected"';}?>>Отображается</option>
            </select>
            <br>
            
            <div class="lab"></div>
            <button type="submit" name="submit" class="btn btn-default">Добавить</button>
        </form>
        
    </div>
</div>
<br>
<?php include_once ROOT.'/view/admin/layouts/footer.php';?>