<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">
        <aside class="widget news-letter">
            <h3 class="widget-title text-uppercase text-center">Get Newsletter</h3>

            <form action="#">
                <input type="email" placeholder="Your email address">
                <input type="submit" value="Subscribe Now"
                       class="text-uppercase text-center btn btn-subscribe">
            </form>

        </aside>
        @if($popularPosts != null)
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
            @foreach($popularPosts as $popularPostsItem)
            <div class="popular-post">


                <a href="{{route('post.show',$popularPostsItem->slug)}}" class="popular-img"><img src="{{$popularPostsItem->getImage()}}" alt="">

                    <div class="p-overlay"></div>
                </a>

                <div class="p-content">
                    <a href="{{route('post.show',$popularPostsItem->slug)}}" class="text-uppercase">{{$popularPostsItem->title}}</a>
                    <span class="p-date">{{$popularPostsItem->getDate()}}</span>

                </div>
            </div>
            @endforeach
        </aside>
        @endif
        @if($featuredPosts  != null)
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Featured Posts</h3>
            <div id="widget-feature" class="owl-carousel">
                @foreach($featuredPosts  as $featuredPostsItem)
                <div class="item">
                    <div class="feature-content">
                        <img src="{{$featuredPostsItem->getImage()}}" alt="">

                        <a href="{{route('post.show',$featuredPostsItem->slug)}}" class="overlay-text text-center">
                            <h5 class="text-uppercase">{{$featuredPostsItem->title}}</h5>

                            <p>{!! $featuredPostsItem->descriptions !!} </p>
                        </a>
                    </div>
                </div>
                    @endforeach

            </div>
        </aside>
        @endif
        @if($recentPosts != null)
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>
            @foreach($recentPosts as $recentPostsItem)
            <div class="thumb-latest-posts">


                <div class="media">
                    <div class="media-left">
                        <a href="{{route('post.show',$recentPostsItem->slug)}}" class="popular-img"><img src="{{$recentPostsItem->getImage()}}" alt="">

                            <div class="p-overlay"></div>
                        </a>
                    </div>
                    <div class="p-content">
                        <a href="{{route('post.show',$recentPostsItem->slug)}}" class="text-uppercase">{{$recentPostsItem->title}}</a>
                        <span class="p-date">{{$recentPostsItem->getDate()}}</span>
                    </div>
                </div>
            </div>
                @endforeach

        </aside>
        @endif
        @if($categories != null)
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{route('category.show',$category->slug)}}">{{$category->title}}</a>
                    <span class="post-count pull-right"> ({{$category->posts->count()}})</span>
                </li>
                @endforeach
            </ul>

        </aside>
            @endif
    </div>
</div>