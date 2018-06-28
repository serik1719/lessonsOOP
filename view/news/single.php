<?php include_once ROOT.'/view/layouts/header.php';?>
<div class="content">
    <div class="container">
        <div class="single">
            <div class="single-para">
                <h4><?=$newsItem['name']?></h4>
                <p><?=htmlspecialchars_decode($newsItem['text'])?></p>
                <div class="star-on">
                    <p><?=$newsItem['date']?></p>
                    <div class="clearfix"> </div>
                </div>
                <a href="/news" class="cart ">Все новости</a>
            </div>
        </div>
    </div>
    <div class="star-on"></div>
</div>
<?php include_once ROOT.'/view/layouts/footer.php';?>