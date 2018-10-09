<script type="application/ld+json">
[
    {
        "@context": "http://schema.org",
        "@type": "BlogPosting",
        "headline": "{{ $page->h1 }}",
        "image": "{{ $page->featured_image_url }}",
        "author": [
            {
                "@context": "http://schema.org",
                "@type": "Person",
                "name": "{{ config('app.name') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('img/logos/fish-for-thought-logo.png') }}"
                }
            }
        ],
        "publisher": [
            {
                "@context": "http://schema.org",
                "@type": "Organization",
                "name": "{{ config('app.name') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('img/logos/fish-for-thought-logo.png') }}"
                }
            }
        ],
        "url": "{{ $page->canonical }}",
        "datePublished": "{{ $page->published_date }}",
        "dateCreated": "{{ $page->created_at }}",
        "dateModified": "{{ $page->updated_at }}",
        "description": "{{ $page->summary }}",
        "articleBody": "{{ $page->content }}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url()->current() }}"
        }
    }
]
</script>
