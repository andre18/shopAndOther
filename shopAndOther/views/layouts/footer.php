<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2015</p>
                <p class="pull-right">Курс PHP Start</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/template/js/jquery.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<script src="/template/js/jquery.scrollUp.min.js"></script>
<script src="/template/js/price-range.js"></script>
<script src="/template/js/jquery.prettyPhoto.js"></script>
<script src="/template/js/main.js"></script>
<script>
    $(document).ready(function() {
        $(".add-to-cart").click(function () {

            var id = $(this).attr("data-id");

            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            });

            return false;
        });

        $(".cartdelete1").click(function () {

            let id = $(this).attr("data-id");

            $.post("/cart/deleteAjax/"+id, {}, function (data) {

                let {cartCount, deleteRow, productCount} = JSON.parse(data);

                $("#cart-count").html(cartCount);

                if (deleteRow !== -1) {
                    $("tr#product-"+id).remove();
                } else {
                    $("td#product-count-"+id).html(productCount);
                }
            });

            return false;
        });
    })
</script>
</body>
</html>