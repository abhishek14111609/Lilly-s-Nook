@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- <section class="site-banner jarallax padding-large" style="background: url('{{ asset('images/hero-image.jpg') }}') no-repeat; background-position: center;">
        <div class="container"><h1 class="page-title">Our Journal</h1></div>
    </section> -->

    <section id="latest-blog" class="padding-large">
        <div class="container">
            <div class="row d-flex flex-wrap">
                @foreach ([
                    ['image' => 'post-img1.jpg', 'title' => 'How we migrated a storefront from Core PHP to Laravel'],
                    ['image' => 'post-img2.jpg', 'title' => 'Structuring ecommerce flows with controllers and models'],
                    ['image' => 'post-img3.jpg', 'title' => 'Why clean migrations matter during a rewrite'],
                ] as $post)
                    <article class="col-md-4 post-item">
                        <div class="image-holder zoom-effect"><img src="{{ asset('images/'.$post['image']) }}" alt="{{ $post['title'] }}" class="post-image"></div>
                        <div class="post-content d-flex"><div class="post-header"><h3 class="post-title">{{ $post['title'] }}</h3><p>This is a placeholder journal page carried into the Laravel version of the project.</p></div></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
