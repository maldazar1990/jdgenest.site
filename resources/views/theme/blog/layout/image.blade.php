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

        @if(Str::contains($image, 'http'))
            <img decoding="async" loading="lazy" class="{{$class}}" src="{{asset($image)}}" alt="image" width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
        @else
            @php
                $image = 'images/' . $image;
                $filename = explode('.', $image);
                if ( !str_contains($image,".webp") ) {
                    $image = $image.".webp";
                }

            @endphp
            @include("theme.blog.layout.source", ['filename' => $filename[0], 'ext' => 'avif',"size"=>$size])
            @include("theme.blog.layout.source", ['filename' => $filename[0], 'ext' => 'webp',"size"=>$size])
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
