<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<?=
'<?xml-stylesheet type="text/xsl" href="'.asset('public/assets/frontend/sitemap.xsl').'"?>'
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($data['posts'] as $post)
        <url>
            <loc>{{ URL::to("/").'/blog/'.$post->slug}}</loc>
            <lastmod>{{ isset($post->created_at) ? $post->created_at : Carbon\Carbon::now() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach($data['categories'] as $category)
        <url>
            <loc>{{ URL::to("/").'/category/'.$category->slug}}</loc>
            <lastmod>{{ isset($category->created_at) ? $category->created_at : Carbon\Carbon::now() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach($data['tags'] as $tag)
        <url>
            <loc>{{ URL::to("/").'/tag/'.$tag->slug}}</loc>
            <lastmod>{{ isset($tag->created_at) ? $tag->created_at : Carbon\Carbon::now() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    <url>
        <loc>{{ URL::to("/")}}</loc>
        <lastmod>{{ Carbon\Carbon::now() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($data['pages'] as $page)
        <url>
            <loc>{{ URL::to("/").'/'.$page->slug}}</loc>
            <lastmod>{{ isset($page->created_at) ? $page->created_at : Carbon\Carbon::now() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>

