<ul>
    @foreach($articles as $article)
        <li><a href="{{ route('blog.show', [$category ?? $article->primaryCategory, $article]) }}">{{ $article->navTitle }}</a></li>
    @endforeach
</ul>
