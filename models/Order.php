<?php

class Order{
    /**
     * Сохраняем заказ в БД
     */
    public static function save($user_id, $fio, $phone, $email, $comment){
        $db = Db::getConnection();
        
        $products = json_encode(Cart::getProducts());
        
        $result = $db->prepare(
                'INSERT INTO product_order (user_id, fio, phone, email, comment, date, products) '
                . 'VALUES (:user_id, :fio, :phone, :email, :comment, now(), :products) '
                );
        $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $result->bindParam(':fio', $fio, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':comment', $comment, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        
        return $result->execute();
    }
}