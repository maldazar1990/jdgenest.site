<picture>
    @php
        if (!isset($class))
            $class = 'img-fluid';

        if (!isset($width))
            $width = '';

        if (!isset($height))
            $height = '';

        if (!isset($css))
            $css = '';

         if (!isset($size))
            $size = '';
    @endphp
    @if($image)

        @if(Str::contains($image, 'http') or Str::contains($image, config('app.url')))
            <img decoding="async" loading="lazy" class="{{$class}}" src="{{asset($image)}}" alt="image" width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
        @else
            @php
                
                if ( str_contains($image,".") and \File::exists(public_path("images/".$image)) )

                    $filename = explode('.', $image)[0];
                else {
                    $filename = $image;
                    $path = \public_path("images/");
                    if ( str_contains($image,".")) {
                        $image = explode(".",$image)[0];
                    }
                    $files = File::glob($path."*".$image.".*");
                    if (count($files) != 0) {
                        $ext = File::extension($files[0]);
                        $image = $image.".".$ext;
                    } else {
                        $image = "default.jpg";
                    }
                }

                if (Str::contains($image, 'images/')) {
                    $image = $image;
                } else {
                    $image = 'images/' . $image;
                }

                $filename = "images/".$filename;
            @endphp
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'avif',"size"=>$size])
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'webp',"size"=>$size])
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'jpeg',"size"=>$size])
            <img
                class="{{$class}}"
                src="{{asset($image)}}"
                alt="image non présent"
                style="{{$css}}"
                width="{{$width}}"
                height="{{$height}}"
            />
        @endif
    @else
        <img
            class="{{$class}}" decoding="async" loading="lazy"
            src="{{asset('images/default.jpg')}}" alt="bug"  width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
    @endif
</picture>
