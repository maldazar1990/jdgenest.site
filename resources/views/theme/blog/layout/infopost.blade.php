@if (isset($post) and $post instanceof \App\post)
    <div class="meta w-100 mb-2 single-col-max-width"><span class="date">
            {{$post->created_at->format("Y-m-d")}}&nbsp;/&nbsp;
            {{\Illuminate\Support\Str::wordCount($post->post)}} mots&nbsp;/&nbsp;
            {{\App\Http\Helpers\HelperGeneral::wordToMinute($post->post)}} min de lecture
    </span></div>
@endif
