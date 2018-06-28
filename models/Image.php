<?php

class Image{
    
    /**
     * Преобразуем массив POST с загружаемыми изображениями в удобный вид
     */
    public static function getPostImages($postImages) {
        $images = array();
        foreach ($_FILES['image']['name'] as $key => $value) {
            $images[$key]['name'] = $value;
            $images[$key]['type'] = $_FILES['image']['type'][$key];
            $images[$key]['tmp_name'] = $_FILES['image']['tmp_name'][$key];
            $images[$key]['error'] = $_FILES['image']['error'][$key];
            $images[$key]['size'] = $_FILES['image']['size'][$key];
        }
        return $images;
    }
    
    /**
     * Если при загрузке произошла ошибка, или не соответствует правилам,
     * возвратит $errors, иначе false
     */
    public static function errorDowloadImage($image, $max_weight) {
        $errors = '';
        
        if($image['error'] != 0){
            $errors .= ' неизвестная ошибка при загрузке';
        }else if($image['size'] > $max_weight){
            $errors .= ' превышает допустимый вес (максимально допустимый '.($max_weight/1024/1024).' mb)';
        }else if($image['type'] != 'image/jpeg'){
            $errors .= ' несоответствие типа (допустимы *.jpeg, *.jpg)';
        }
        
        if(empty($errors)){
            return false;
        }
        return 'Ошибка при загрузке файла '.$image['name'].' '.$errors;
    }
    
    /**
     * Сохраняем изображение продкута в конечную папку
     * и дописываем его в БД к изображениям продкута в виде Json
     */
    public static function dowloadImageProduct($idProduct, $image){
        //  Создаём имя изображения продукта
        $nameImage = $idProduct.'_'.(Product::getLastImageProduct($idProduct)+1);
        
        //  Сохраняем изображение в конечную папку
        move_uploaded_file($image['tmp_name'], ROOT."/template/images/products/{$nameImage}.jpg");
        
        //  Дописываем продукту в БД информацию о новом продукте
        Product::addImageInListImagesProduct($idProduct, $nameImage);
    }
    
    /**
     * Создаёт и возвращает путь к уменьшенному(изменённому по размеру) изображению
     * @param type $originalImage Имя изображения-оригинала (без разрешения)
     * @param type $folder Папка в '\mini\' для сохранения, пример 'index1'
     * @param type $maxWidthNewImage Максимальная ширина выходящего изображения
     * @param type $maxHeightNewImage Максимальная высота выходящего изображения
     * @param type $path Полный путь к изображению (/template/...)
     * @return type
     */
    public static function getMiniImage($originalImage, $folder, $maxWidthNewImage = 260, $maxHeightNewImage = 260, $path = '/template/images/products/'){
        if(empty($originalImage) || !file_exists(ROOT.$path.$originalImage.'.jpg')){
            $fullNameOriginalImage = imagecreatefromjpeg(ROOT.'/template/images/'.'no_photo'.'.jpg');
        }else{
            $fullNameOriginalImage = imagecreatefromjpeg(ROOT.$path.$originalImage.'.jpg');
        }
        
        
        // Ширина и высота оригинала
        $widthOriginal = imagesX($fullNameOriginalImage);
        $heightOriginal = imagesY($fullNameOriginalImage);
        
        //  Пропорции изображения оригинала
        $koeffOriginal = $widthOriginal / $heightOriginal;
        
        //  Пропорции нового изображения
        $koeffNew = $maxWidthNewImage / $maxHeightNewImage;

        if($koeffOriginal < $koeffNew){   //  сжимаем по высоте 
            $startWidthNewTempImage = 0;
            $k = $widthOriginal/$maxWidthNewImage;
            $startHeightNewTempImage = ($heightOriginal - $widthOriginal/$koeffNew) / 2;
        }else{                            //  сжимаем по ширине 
            $startHeightNewTempImage = 0;
            $k = $heightOriginal/$maxHeightNewImage;
            $startWidthNewTempImage = ($widthOriginal - $heightOriginal*$koeffNew) / 2;
        }
        
        // Просчитанные ширина и высота нового изображения
        $widthNewTempImage = $widthOriginal/$k;
        $heightNewTempImage = $heightOriginal/$k;
        
        //  Пустое изображение на которое будем ложить уменьшенную копию оригинала
        $tempImage = imagecreatetruecolor($maxWidthNewImage, $maxHeightNewImage);
        
        //  Переносим уменьшенную копию оригинала на созданное пустое изображение
        imagecopyresampled($tempImage, $fullNameOriginalImage, 0, 0, $startWidthNewTempImage, $startHeightNewTempImage, $widthNewTempImage, $heightNewTempImage, $widthOriginal, $heightOriginal);
        
        //  Записываем изображение на сервер в пупку 'mini/'.$folder.'/'
        if(!file_exists(ROOT.$path.'mini/'.$folder.'/')){
            mkdir(ROOT.$path.'mini/'.$folder.'/');
        }
        imagejpeg($tempImage, ROOT.$path.'mini/'.$folder.'/'.$originalImage.".jpg",100);
        
        //  Удаляем временные изображения
        imagedestroy($fullNameOriginalImage);
        imagedestroy($tempImage);
        
        return $path.'mini/'.$folder.'/'.$originalImage.".jpg";
    }
    
    /**
     * Создаёт уменьшенные(изменённые по размеру) изображения из переданного массива
     * @param type $originalImages Массив изображений-оригиналов (без разрешения)
     * @param type $folder Папка в '\mini\' для сохранения, пример 'index1'
     * @param type $maxWidthNewImage Максимальная ширина выходящего изображения
     * @param type $maxHeightNewImage Максимальная высота выходящего изображения
     * @param type $path Полный путь к изображению (/template/...)
     * @return type
     */
    public static function createMiniImages($originalImages, $folder, $maxWidthNewImage = 260, $maxHeightNewImage = 260, $path = '/template/images/products/') {
        foreach ($originalImages as $originalImage) {
            Image::getMiniImage($originalImage, $folder, $maxWidthNewImage, $maxHeightNewImage, $path);
        }
    }
}