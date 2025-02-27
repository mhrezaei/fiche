@extends('front.frame.frame')

{{ null, $post->spreadMeta() }}

@section('head')
    <title>{{ setting()->ask('site_title')->gain() }} | {{ $post->title }}</title>
{{--    {{ dd($post) }}--}}
    @include('front.frame.open_graph_meta_tags',[
        'title' => $post->title,
        'url' => url('organ_donation_card'),
        'image' => url('/assets/site/images/cardMini.png'),
        'description' => $post->abstract,
    ])
@append
@section('content')
    <div class="container-fluid">

        @include('front.frame.position_info', [
            'group' => $post->header_title,
            'category' => $post->category_title,
            'groupColor' => 'green',
        ])
        @include('front.card_info.card_info_content')
    </div>
@endsection