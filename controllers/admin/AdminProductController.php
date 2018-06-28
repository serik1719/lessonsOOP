<?php

class AdminProductController{
    const SHOW_BY_DEFAULT = 10;
    const MAX_WEIGHT_DOVLOAD_IMAGE = 1048576;  //  1024*1024*1     1mb
    const COUNT_DOWLOAD_IMAGES = 6;
    
    public function actionIndex($page = 1) {
        User::checkAdmin();
        
        $total = Product::getTotalProduct('all');
        $pagination = new Pagination('/admin/products/page-', $page, $total, self::SHOW_BY_DEFAULT);
        $productsList = Product::getLatesProductsForPage($page, self::SHOW_BY_DEFAULT, 'all');
        
        $title = 'Управление товарами';
        require_once ROOT.'/view/admin/product/index.php';
        return true;
    }
    
    public function actionAdd() {
        User::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        $errors = false;
        $options['name'] = '';
        $options['category_id'] = '';
        $options['code'] = '';
        $options['price'] = '';
        $options['availability'] = '';
        $options['brand'] = '';
        $options['description'] = '';
        $options['is_new'] = 1;
        $options['is_recomendet'] = 0;
        $options['status'] = 1;
        
        if(isset($_POST['submit'])){
            $options['name'] = $_POST['name'];
            $options['category_id'] = $_POST['category_id'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['availability'] = $_POST['availability'];
            $options['brand'] = $_POST['brand'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recomendet'] = $_POST['is_recomendet'];
            $options['status'] = $_POST['status'];
            
            if(empty($options['name'])){$errors[] = 'Наименование не указано';}
            
            if(empty($options['code'])){$errors[] = 'Код не указан';}
            if(empty($options['price'])){$errors[] = 'Цена не указана';}
            if(empty($options['availability'])){$errors[] = 'Количетсво не указано';}
            if(empty($options['brand'])){$errors[] = 'Бренд не указан';}
            
            if(empty($options['description'])){$errors[] = 'Описание не заполнено';}
            
            if($errors == false){
                if($id = Product::create($options)){
                    $images = Image::getPostImages($_FILES['image']);
                    foreach ($images as $key => $image) {
                        if($image['error'] != 4){       //  error 4 - файл не загружен
                            if($error = Image::errorDowloadImage($image, self::MAX_WEIGHT_DOVLOAD_IMAGE)){
                                $errors[] = $error;
                            }else{
                                if(!is_uploaded_file($image['tmp_name'])){
                                    $errors[] = 'Ошибка при сохранении файла '.$image['name'];
                                }else{
                                    Image::dowloadImageProduct($id, $image);
                                }
                            }
                        }
                    }
                    Product::setMainImage($id);
                    
                    if($errors){
                        $_SESSION['errors'] = $errors;
                        Router::setUrlRedirectr('/admin/product/edit/'.$id);
                    }else{
                        Router::setUrlRedirectr('/admin/products');
                    }
                    
                }else{
                    $errors[] = 'Ошибка при добавлении товара';
                }
            }
        }
        
        $title = "Добавление товара";
        require_once ROOT.'/view/admin/product/add.php';
        return true;
    }
    
    public function actionEdit($id) {
        User::checkAdmin();
        
        $main_image = Product::getMainImage($id);
        
        $categoriesList = Category::getCategoriesListAdmin();
        $product = Product::getProductById($id, 'all');
        $images = Product::getListImagesProduct($id);
        
        $errors = false;
        $options['id'] = $id;
        $options['name'] = $product['name'];
        $options['category_id'] = $product['category_id'];
        $options['code'] = $product['code'];
        $options['price'] = $product['price'];
        $options['availability'] = $product['availability'];
        $options['brand'] = $product['brand'];
        $options['description'] = $product['description'];
        $options['is_new'] = $product['is_new'];
        $options['is_recomendet'] = $product['is_recomendet'];
        $options['status'] = $product['status'];
        
        if(isset($_SESSION['errors'])){
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }
        
        if(isset($_POST['submit'])){
            $options['name'] = $_POST['name'];
            $options['category_id'] = $_POST['category_id'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['availability'] = $_POST['availability'];
            $options['brand'] = $_POST['brand'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recomendet'] = $_POST['is_recomendet'];
            $options['status'] = $_POST['status'];
            
            if(empty($options['name'])){$errors[] = 'Наименование не указано';}
            
            if(empty($options['code'])){$errors[] = 'Код не указан';}
            if(empty($options['price'])){$errors[] = 'Цена не указана';}
            if(empty($options['availability'])){$errors[] = 'Количетсво не указано';}
            if(empty($options['brand'])){$errors[] = 'Бренд не указан';}
            
            if(empty($options['description'])){$errors[] = 'Описание не заполнено';}
            
            if($errors == false){
                Product::update($options);
                
                $images = Image::getPostImages($_FILES['image']);
                foreach ($images as $key => $image) {
                    if($image['error'] != 4){       //  error 4 - файл не загружен
                        if($error = Image::errorDowloadImage($image, self::MAX_WEIGHT_DOVLOAD_IMAGE)){
                            $errors[] = $error;
                        }else{
                            if(!is_uploaded_file($image['tmp_name'])){
                                $errors[] = 'Ошибка при сохранении файла '.$image['name'];
                            }else{
                                Image::dowloadImageProduct($id, $image);
                            }
                        }
                    }
                }
                if(!Product::getMainImage($id)){
                    Product::setMainImage($id);
                }
                
                if($errors){
                    $_SESSION['errors'] = $errors;
                    header("Location: ".$_SERVER["REQUEST_URI"]);
                }else{
                    Router::setUrlRedirectr('/admin/products');
                }
            }
        }
        
        $title = "Редактирование товара (ID:".$id.")";
        require_once ROOT.'/view/admin/product/edit.php';
        return true;
    }
    
    public function actionImageDelete($image){
        User::checkAdmin();
        
        $elements = explode('_', $image);
        $idProduct = $elements[0];
        
        $product = Product::getProductById($idProduct, 'all');
        
        if(isset($_POST['submit'])){
            $images = Product::getListImagesProduct($idProduct);
            
            $images = array_flip($images);  //  Меняем местами ключи и значения
            unset($images[$image]);         //  Удаляем по значению
            $images = array_flip($images);
            
            $images = array_values($images);
            
            Product::setListImagesProduct($idProduct, $images);
            
            if($image == Product::getMainImage($idProduct)){
                Product::setMainImage($idProduct);
            }
            
            $image = ROOT.'/template/images/products/'.$image.'.jpg';
            if(file_exists($image)){
                unlink($image);
            }
            
            header('location: /admin/product/edit/'.$idProduct);
        }
        
        $title = "Удаление изорбражения ".$image." товара (ID:".$idProduct.")";
        require_once ROOT.'/view/admin/product/imagedelete.php';
        return true;
    }

    public function actionDelete($id) {
        User::checkAdmin();
        
        if(!$product = Product::getProductById($id, 'all')){
            Router::ErrorPage404();
        }
        
        if(isset($_POST['submit'])){
            Product::deleteProductById($id);
            header('Location: /admin/products');
        }
        
        $title = "Удаление товара (ID:".$id.")";
        require_once ROOT.'/view/admin/product/delete.php';
        return true;
    }

    public function actionMainImage($image) {
        User::checkAdmin();
        $elements = explode('_', $image);
        Product::setMainImage($elements[0], $image);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
