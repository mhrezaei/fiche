<div class="container">
    <div class="row">
        <div class="article @if($showSideBar) col-xs-12 col-md-8 @endif">
            @include($viewFolder . '.content')
            @include($viewFolder . '.post_footer')
        </div>
        @if($showSideBar)
            @include($viewFolder . '.sidebar')
        @endif
    </div>
</div>