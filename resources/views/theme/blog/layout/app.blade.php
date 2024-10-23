<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include("theme.blog.layout.head")
<body>
@include("theme.blog.layout.header")
@include("theme.blog.layout.main")
<script>
document.body.innerHTML=document.body.innerHTML.replace(/\u00AD/g, '');
</script>
</body>

</html>
