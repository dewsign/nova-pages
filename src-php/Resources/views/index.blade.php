<h2>@lang('Articles')</h2>
@include('nova-pages::article-list')

<h2>@lang('Categories')</h2>
<ul>
    @foreach($categories as $category)
        <li><a href="{{ route('blog.list', [$category]) }}">{{ $category->navTitle }}</a></li>
    @endforeach
</ul>
