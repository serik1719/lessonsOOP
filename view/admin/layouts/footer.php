<div class="footer">
    <div class="container">
        <div class="col-md-12 footer-left">
            <a href="/"><img src="/template/images/main-logoSG.png" alt=""></a>
            <span class="footer-class">© 2017 Магазин Гапановича С.В. New-Dream.ru <a href="http://w3layouts.com/" target="_blank">W3layouts</a></span>
        </div>
        <div class="clearfix"></div>
    </div>
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