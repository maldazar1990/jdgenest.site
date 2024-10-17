<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include("theme.blog.layout.head")
<body>
@include("theme.blog.layout.header")
@include("theme.blog.layout.main")
</body>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>
