<picture>
    @php
        $imageConverted = 0;
        $imageUrl = null;
        $image = null;
        if ( isset($modelWithImage) ) {
            if ($modelWithImage instanceof \App\Users or $modelWithImage instanceof \App\post or $modelWithImage instanceof \App\Infos) {
                $id = $modelWithImage->image_id;
                $imageModel = Cache::rememberForever("modelImage_" . $id, function () use ($id) {
                    return \App\Image::where('id', $id)->first();
                });

                if(isset($imageModel->file)){
                    $image = $imageModel->file;
                    if ( $imageModel->migrated ){

                        $imageConverted = 1;
                    } else {
                        $imageConverted = 2;
                    }
                }
                if ( Str::isUrl($modelWithImage->image) ){
                    $imageUrl = $modelWithImage->image;
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
    @if($image or $imageUrl)

        @if($imageUrl)
            <img decoding="async" loading="lazy" id="previewImage" class="{{$class}}" src="{{$imageUrl}}" alt="image" width="{{$width}}" height="{{$height}}" style="{{$css}}"/>
        @else
            @php

                $files = $modelWithImage->getImages();

            @endphp
            @dump($files);
            @if($imageConverted != 2 and $files )

                @if(isset($files['avif']))
                    @include("toolbox.source", ['array' => $files['avif'], 'ext' => 'avif',"size"=>$size])
                @endif
                @if(isset($files['webp']))
                    @include("toolbox.source", ['array' => $files['webp'], 'ext' => 'webp',"size"=>$size])
                @endif
                @if(isset($files['jpeg']) or isset($files['jpg']))
                    @php
                        if(isset($files['jpeg'])){
                            $ext = 'jpeg';
                        } else {
                            $ext = 'jpg';
                        }
                    @endphp
                    @include("toolbox.source", ['array' => $files[$ext], 'ext' => $ext,"size"=>$size])
                @endif
            @endif
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
