<!DOCTYPE html>
<html>
<head>
<title><?=$title;?></title>
<link href="/template/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/template/js/jquery.min.js"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="/template/css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--fonts-->
<link href="https://fonts.googleapis.com/css?family=Amaranth:400,700|Gabriela|Lobster&amp;subset=cyrillic" rel="stylesheet">
<!--//fonts-->
<script type="text/javascript" src="/template/js/move-top.js"></script>
<script type="text/javascript" src="/template/js/easing.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){		
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>
<!-- start menu -->
<link href="/template/css/megamenu.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" src="/template/js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>			
<link rel="stylesheet" href="/template/css/etalage.css">
<script src="/template/js/jquery.etalage.min.js"></script>
<script>
    jQuery(document).ready(function($){
        $('#etalage').etalage({
            thumb_image_width: 300,
            thumb_image_height: 400,
            source_image_width: 900,
            source_image_height: 1200,
            show_hint: true,
            click_callback: function(image_anchor, instance_id){
                alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
            }
        });
    });
</script>
</head>
<body> 
<div class="header" >
    <div class="top-header" >		
        <div class="container">
            <div class="top-head" >
                <ul class="header-in">
                    <li><a href="/admin"><img src="/template/images/white_edit.png"> Админ панель</a></li>
                </ul>
                <ul class="user">
                    <?php if(isset($_SESSION['user'])): ?>
                    <li><a href="/"><img src="/template/images/white_back.png"> На сайт</a></li>
                    <?php else: ?>
                    <?php endif; ?>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
