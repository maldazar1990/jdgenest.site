<picture>
    @php
        if ( isset($modelWithImage) ) {
            if ($modelWithImage instanceof \App\users or $modelWithImage instanceof \App\post or $modelWithImage instanceof \App\Infos) {
                if(isset($modelWithImage->imageClass->file)){
                    $image = $modelWithImage->imageClass->file;
                } else {
                    if ( Str::isUrl($modelWithImage->image) ){
                        $image = $modelWithImage->image;
                    } elseif ($modelWithImage->image){
                        $image = $modelWithImage->image;
                        if ( !str_contains($image,"images/") )
                            $image = "images/".$image;
                    } else {
                        $image = null;
                    }
                }
            }
        }

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
            <img decoding="async" loading="lazy" id="previewImage" class="{{$class}}" src="{{asset($image)}}" alt="image" width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
        @else
            @php

                if ( str_contains($image,".") and \File::exists(public_path($image)) )

                    $filename = explode('.', $image)[0];
                else {
                    $filename = $image;
                    $path = \public_path();
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

            @endphp
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'avif',"size"=>$size])
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'webp',"size"=>$size])
            @include("theme.blog.layout.source", ['filename' => $filename, 'ext' => 'jpeg',"size"=>$size])
            <img
                class="{{$class}}"
                src="{{asset($image)}}"
                alt="image non présent"
                id="previewImage"
                style="{{$css}}"
                width="{{$width}}"
                height="{{$height}}"
            />
        @endif
    @else
        <img
            class="{{$class}}" decoding="async" loading="lazy"
            src="{{asset('images/default.jpg')}}" alt="bug" id="previewImage"  width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
    @endif
</picture>
