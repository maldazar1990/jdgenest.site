@if($ext and $filename)
    @php
        $image = $filename.".".$ext;
        $imageMedium = $filename . '_medium.' . $ext;
        $imageSmall = $filename . '_small.' . $ext;
    @endphp
    @if($size)

        @php
            switch ($size) {
                case('small'):
                    $image = $imageSmall;
                    break;
                case('medium'):
                    $image = $imageMedium;
                    break;
                default:
                    $image = $image;
            }

            if (!file_exists(public_path($image))){
                $image = $filename.".".$ext;
            }

        @endphp
        @if(File::exists(public_path($image)))
            <source srcset="{{asset($image)}}" type="image/{{$ext}}">
        @endif
    @else

        @if(File::exists(public_path($image)))
            @if ( File::exists(public_path($imageMedium)) and File::exists(public_path($imageSmall)))
                <source media="(min-width: 1280px)" srcSet="{{asset($image)}}" type="image/{{$ext}}"/>
                <source media="(min-width: 767px)" srcSet="{{asset($imageMedium)}}" type="image/{{$ext}}"/>
                <source media="(max-width: 766px)" srcSet="{{asset($imageSmall)}}" type="image/{{$ext}}"/>
            @endif
            <source srcSet="{{asset($image)}}" type="image/{{$ext}}"/>
        @endif
    @endif
@endif
