<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/frontend/bootstrap.min.css">
    <link rel="stylesheet" href="css/frontend/animate.css">
    <link rel="stylesheet" href="css/frontend/owl.carousel.min.css">
    <link rel="stylesheet" href="css/frontend/all.css">
    <link rel="stylesheet" href="css/frontend/flaticon.css">
    <link rel="stylesheet" href="css/frontend/themify-icons.css">
    <link rel="stylesheet" href="css/frontend/magnific-popup.css">
    <link rel="stylesheet" href="css/frontend/slick.css">
    <link rel="stylesheet" href="css/frontend/style.css">
    <title>Shopping</title>
</head>

<body>
    <header class="main_menu home_menu">
        <?php echo $__env->make('frontend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </header>

    <?php echo $__env->yieldContent('content'); ?>

    <footer class="footer_part">
        <?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </footer>
</body>
<script src="js/frontend/jquery-1.12.1.min.js"></script>
<script src="js/frontend/popper.min.js"></script>
<script src="js/frontend/bootstrap.min.js"></script>
<script src="js/frontend/jquery.magnific-popup.js"></script>
<script src="js/frontend/swiper.min.js"></script>
<script src="js/frontend/masonry.pkgd.js"></script>
<script src="js/frontend/owl.carousel.min.js"></script>
<script src="js/frontend/jquery.nice-select.min.js"></script>
<script src="js/frontend/slick.min.js"></script>
<script src="js/frontend/jquery.counterup.min.js"></script>
<script src="js/frontend/waypoints.min.js"></script>
<script src="js/frontend/contact.js"></script>
<script src="js/frontend/jquery.ajaxchimp.min.js"></script>
<script src="js/frontend/jquery.form.js"></script>
<script src="js/frontend/jquery.validate.min.js"></script>
<script src="js/frontend/mail-script.js"></script>
<script src="js/frontend/custom.js"></script>

</html><?php /**PATH C:\Users\The Mad Brains\messho\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>