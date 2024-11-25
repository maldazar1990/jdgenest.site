@if($ext and $array)
    @if(isset($array))
        @if($size)
            @if(isset($array[$size]))
                <source srcset="{{asset($array[$size])}}" type="image/{{$ext}}">
            @endif
        @else
            @if(isset($array["large"]))
                <source media="(min-width: 1200px)" srcSet="{{asset($array["large"])}}" type="image/{{$ext}}"/>
            @endif
            @if(isset($array["medium"]))
                <source media="(min-width: 577px)" srcSet="{{asset($array["medium"])}}" type="image/{{$ext}}"/>
            @endif
            @if(isset($array["small"]))
                <source media="(max-width: 576px)" srcSet="{{asset($array["small"])}}" type="image/{{$ext}}"/>
            @endif
            @if(isset($array["large"]))
                <source srcSet="{{asset($array["large"])}}" type="image/{{$ext}}"/>
            @elseif(isset($array["medium"]))
                <source srcSet="{{asset($array["medium"])}}" type="image/{{$ext}}"/>
            @elseif(isset($array["small"]))
                <source srcSet="{{asset($array["small"])}}" type="image/{{$ext}}"/>
            @else
                <source srcSet="{{asset(config("custom.default"))}}" type="image/webp"/>
            @endif
        @endif
    @endif
@endif
