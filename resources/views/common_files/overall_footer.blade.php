</main>
<footer class="footer fixed-bottom mt-auto py-3">
    <div class="container">
        <span class="text-muted">&copy; McScanFace</span>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="{{asset('js/jquery-slim.min.js')}}"><\/script>')</script><script src="{{asset('js/bootstrap.bundle.min.js')}}" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
<script src="{{asset('js/offcanvas.js')}}"></script></body>
<script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

</script>
</html>
