    <div class="sidebar">
        <div class="widget">
            <h2 class="widget-title">Popular Posts</h2>
            <div class="blog-list-widget">
                <div class="list-group">
                    @foreach ($sidebar_posts as $sidebar_post)
                        <a href="{{ route('posts.single', ['slug' => $sidebar_post->slug]) }}"
                            class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="w-100 justify-content-between">
                                <img src="{{ $sidebar_post->getImage() }}" alt="{{ $sidebar_post->slug }}"
                                    class="img-fluid float-left">
                                <h5 class="mb-1">{{ $sidebar_post->title }}</h5>
                                <small>{{ $sidebar_post->getPostDate() }}</small>
                                || <small><i class="fa fa-eye"></i>({{ $sidebar_post->views }})</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div><!-- end blog-list -->
        </div><!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Categories</h2>
            <div class="link-widget">
                <ul>
                    @foreach ($cats as $category)
                        <li><a
                                href="{{ route('categories.single', ['slug' => $category->slug]) }}">{{ $category->title }}<span>({{ $category->posts_count }})</span></a>
                        </li>
                    @endforeach
                </ul>
            </div><!-- end link-widget -->
        </div><!-- end widget -->
    </div><!-- end sidebar -->
