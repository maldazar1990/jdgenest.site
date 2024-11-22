@if($ext and $array)
    @if(isset($array))
        @if($size)
            <source srcset="{{asset($array[$size])}}" type="image/{{$ext}}">
        @else
            @if(isset($array["large"]))
                <source media="(min-width: 1280px)" srcSet="{{asset($array["large"])}}" type="image/{{$ext}}"/>
            @endif
            @if(isset($array["medium"]))
                <source media="(min-width: 767px)" srcSet="{{asset($array["medium"])}}" type="image/{{$ext}}"/>
            @endif
            @if(isset($array["small"]))
                <source media="(max-width: 766px)" srcSet="{{asset($array["small"])}}" type="image/{{$ext}}"/>
            @endif

            <source srcSet="{{asset($array["large"])}}" type="image/{{$ext}}"/>
        @endif
    @endif
@endif
