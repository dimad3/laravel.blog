<div class="page-wrapper">
    <div class="blog-custom-build">
        @foreach ($posts as $post)
            <div class="blog-box wow fadeIn">
                <div class="post-media">
                    <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" title="">
                        <img src="{{ $post->getImage() }}" alt="{{ $post->slug }}" class="img-fluid">
                        <div class="hovereffect">
                            <span></span>
                        </div>
                        <!-- end hover -->
                    </a>
                </div>
                <!-- end media -->
                <div class="blog-meta big-meta text-center">
                    <div class="post-sharing">
                        <ul class="list-inline">
                            <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i>
                                    <span class="down-mobile">Share on Facebook</span></a></li>
                            <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i>
                                    <span class="down-mobile">Tweet on Twitter</span></a></li>
                            <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a>
                            </li>
                        </ul>
                    </div><!-- end post-sharing -->
                    <h4><a href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                            title="">{{ $post->title }}</a></h4>
                    <p>{!! $post->description !!}</p>
                    <small><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}"
                            title="">{{ $post->category->title }}</a></small>
                    <small>{{ $post->getPostDate() }}</small>
                    <small><i class="fa fa-eye"></i>{{ $post->views }}</small>
                </div><!-- end meta -->

                <hr class="invis">
            </div><!-- end blog-box -->
        @endforeach
    </div>
</div>

<hr class="invis">

<div class="row">
    <div class="col-md-12">
        <nav aria-label="Page navigation">
            @if (isset($search))
                @php
                    /**
                     * vendor\laravel\framework\src\Illuminate\Contracts\Pagination\Paginator.php
                     *
                     * public function appends($key, $value = null);
                     *
                     * Add a set of query string values to the paginator.
                     *
                     * @param  array|string  $key
                     * @param  string|null  $value
                     * @return $this
                    */
                    /**
                     * vendor\laravel\framework\src\Illuminate\Foundation\helpers.php
                     *
                     * function request($key = null, $default = null)
                     *
                     * Get an instance of the current request or an input item from the request.
                     *
                     * @param  array|string|null  $key
                     * @param  mixed  $default
                     * @return \Illuminate\Http\Request|string|array
                    */
                @endphp
                {{ $posts->appends(['s' => request()->s])->links() }}
            @else
                {{ $posts->links() }}
            @endif
        </nav>
    </div><!-- end col -->
</div><!-- end row -->
