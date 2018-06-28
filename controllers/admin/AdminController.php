<?php

class AdminController{
    
    public function actionIndex() {
        User::checkAdmin();
        
        $title = "Админ панель";
        require_once ROOT.'/view/admin/index.php';
        
        return true;
    }
}