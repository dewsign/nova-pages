<h2>@lang('Articles') in {{ $page->h1 }}</h2>
@include('nova-pages::article-list')

<h2>@lang('Categories')</h2>
<ul>
    <li><a href="{{ route('blog.index') }}">@lang('All')</a></li>
    @foreach($categories as $category)
        <li><a href="{{ route('blog.list', [$category]) }}">{{ $category->navTitle }}</a></li>
    @endforeach
</ul>

<div>
    @repeaterblocks($page)
</div>
