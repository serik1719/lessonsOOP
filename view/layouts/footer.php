<div class="footer">
    <div class="container">
        <div class="col-md-3 footer-left">
            <a href="/"><img src="/template/images/main-logoSG.png" alt=""></a>
            <p class="footer-class">© 2017 Магазин Гапановича С.В. New-Dream.ru <a href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
        </div>
        <div class="col-md-2 footer-middle">
            <ul>
                <li><a href="/404">Обо мне</a></li>
                <li><a href="/contact">Контакты</a></li>
                <li><a href="/portfolio">Мои сайты</a></li>
            </ul>
        </div>
        <div class="col-md-4 footer-left">
            <ul class="term">
                <li><a href="/regulations">Правила</a></li>
                <li><a href="/press">Пресса</a></li>
                <li><a href="/reviews">Отзывы</a></li>	
            </ul>
            <ul class="term">
                <li><a href="/registration">Присоединиться</a></li>
                <li><a href="/vidio">Видео магазине</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-3 footer-right">
            <h5>Принимаем</h5>
            <ul>
                <li><a href="#"><i></i></a> </li>
                <li><a href="#"><i class="we"></i></a></li>
                <li><a href="#"><i class="we-in"></i></a></li>
                <li><a href="#"><i class="we-at"></i></a></li>
                <li><a href="#"><i class="we-at-at"></i></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            /*
            var defaults = {
                    containerID: 'toTop', // fading element id
                    containerHoverID: 'toTopHover', // fading element hover id
                    scrollSpeed: 1200,
                    easingType: 'linear' 
            };
            */
            $().UItoTop({ easingType: 'easeOutQuart' });
        });
    </script>
    <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
    
    <script>
        $(document).ready(function(){
            // выполняем function() если нажат (click) класс item_add
            $(".item_add").click(function(){
                //  присваиваем переменной id значение из атрибута data-id
                var id = $(this).attr("data-id");
                //  передаём методом POST выполнение адресу типа "cart/add/"+id и function() возвращает echo из файла значение в data
                $.post("/cart/add/"+id, {}, function(data){
                    //  блоку с id="simpleCart_quantity" присваиваем значение из data
                    $("#simpleCart_quantity").html(data);
                });
                return false;
            });
        });
    </script>
</div>
</body>
</html>