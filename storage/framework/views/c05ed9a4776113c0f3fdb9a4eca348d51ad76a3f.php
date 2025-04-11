<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 Page not found</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://codepen.io/uzcho_/pen/XWdExxq.scss">
  <link rel="stylesheet" type="text/css" href="https://codepen.io/uzcho_/pen/eYdmdXw.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>
  <style type="text/css">
   body {
  display: flex;
  flex-flow: row wrap;
  align-content: center;
  justify-content: center;
}

div {
  width: 100%;
  text-align: center;
}

.number {
  background: #fff;
  position: relative;
  font: 900 30vmin "Consolas";
  letter-spacing: 5vmin;
  text-shadow: 2px -1px 0 #000, 4px -2px 0 #0a0a0a, 6px -3px 0 #0f0f0f, 8px -4px 0 #141414, 10px -5px 0 #1a1a1a, 12px -6px 0 #1f1f1f, 14px -7px 0 #242424, 16px -8px 0 #292929;
}
.number::before {
  background-color: #673ab7;
  background-image: radial-gradient(closest-side at 50% 50%, #ffc107 100%, rgba(0, 0, 0, 0)), radial-gradient(closest-side at 50% 50%, #e91e63 100%, rgba(0, 0, 0, 0));
  background-repeat: repeat-x;
  background-size: 40vmin 40vmin;
  background-position: -100vmin 20vmin, 100vmin -25vmin;
  width: 100%;
  height: 100%;
  mix-blend-mode: screen;
  -webkit-animation: moving 10s linear infinite both;
          animation: moving 10s linear infinite both;
  display: block;
  position: absolute;
  content: "";
}
@-webkit-keyframes moving {
  to {
    background-position: 100vmin 20vmin, -100vmin -25vmin;
  }
}
@keyframes moving {
  to {
    background-position: 100vmin 20vmin, -100vmin -25vmin;
  }
}

.text {
  font: 400 5vmin "Courgette";
}
.text span {
  font-size: 10vmin;
}
  </style>
</head>
<body>
  
<div class="number">404</div>
<div class="text mt-4 mb-4"><span>Ooops...</span><br>Page not found</div>
<a class="me btn btn-primary" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
</body>
</html>
<script type="text/javascript">
  
</script><?php /**PATH C:\Users\The Mad Brains\priv\resources\views/errors/404.blade.php ENDPATH**/ ?>