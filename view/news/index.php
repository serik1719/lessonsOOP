<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="content">
    <div class="container">
        <?php foreach ($newsList as $newsItem):?>
            <div class="single">
                <div class="single-para">
                    <h4><?=$newsItem['name']?></h4>
                    <p><?=mb_substr(strip_tags($newsItem['text']), 0, 500, 'utf-8').'...'?></p>
                    <div class="star-on">
                        <p><?=$newsItem['date']?></p>
                        <div class="clearfix"></div>
                    </div>
                    <a href="/new/<?=$newsItem['id']?>" class="cart ">Читать далее...</a>
                </div>
            </div>
        <?php endforeach;?>
        <br><br>
        <div class="clearfix"></div>
        <?=$pagination->get();?>
    </div>
    <div class="star-on"></div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>