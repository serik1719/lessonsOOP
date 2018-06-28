<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="container">
    <div class="col-md-12 user text-center">
        
        <h2><?=$title;?></h2>
        
        <?php if($result): ?>
            Аккаунт активирован, теперь можете <b><span class="red_text"><a href="/login">войти</a></span></b> в аккаунт
        <?php else: ?>
            Код не верный, или использован.
        <?php endif; ?>
        
    </div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>