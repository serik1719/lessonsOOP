<?php       //  '' => 'Значение'     - элемент массива будет игнорироваться, ключ должен быть заполнен
    return array(
        
        'new/([0-9]+)' => 'news/view/$1',
        'news/page-([0-9]+)' => 'news/index/$1',
        'news' => 'news/index',
        
        
        'index' => 'site/index',
        '404' => 'site/page404',
        'contacts' => 'site/contacts',
        
        
        'cart/add/([0-9]+)' => 'cart/add/$1',
        'cart/clear' => 'cart/clear',
        'cart/minus/([0-9]+)' => 'cart/minus/$1',
        'cart/delete/([0-9]+)' => 'cart/delete/$1',
        'cart/order' => 'cart/order',
        'cart' => 'cart/index',
        
        
        'register' => 'user/register',
        'active/([a-z0-9]+)' => 'user/active/$1',
        'login' => 'user/login',
        'logout' => 'user/logout',
        'restore' => 'user/restore',
        'code/([a-z0-9]+)' => 'user/code/$1',
        
        'cabinet/edit' => 'cabinet/edit',
        'cabinet/orders' => 'cabinet/orders',
        'cabinet' => 'cabinet/index',
        
        
        'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',
        'category/([0-9]+)' => 'catalog/category/$1',
        'catalog/page-([0-9]+)' => 'catalog/index/$1',
        'catalog' => 'catalog/index',
        
        
        
        'admin/product/image/delete/([0-9_]+)' => 'adminProduct/imagedelete/$1',
        'admin/product/image/main/([0-9_]+)' => 'adminProduct/mainimage/$1',
        'admin/product/add' => 'adminProduct/add',
        'admin/product/edit/([0-9]+)' => 'adminProduct/edit/$1',
        'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
        'admin/products/page-([0-9]+)' => 'adminProduct/index/$1',
        'admin/products' => 'adminProduct/index',
        
        'admin' => 'admin/index',
        
        
        'product/([0-9]+)' => 'product/view/$1',
        
        
        'test/([0-9_]+)' => 'site/test/$1',
    );