@extends('frontend.main_master')
@section('title', 'view')
@section('content')
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-2">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">News</div>
                    </div>
                    <div class="row pb-5">
                        @for ($i = 0; $i < count($news['data']); $i++)
                            <div class="col-xl-4 mb-2">
                                <div class="card text-left">
                                    <a href="{{ $news['data'][$i]['url'] }}" target="_blank">
                                        <img class="card-img-top"
                                            src="{{ $news['data'][$i]['image'] ? $news['data'][$i]['image'] : asset('frontend/images/placeholder-news.jpg') }}"
                                            alt="" style="width: 100%; height:15vw; object-fit: cover;">
                                        <div class="card-body">
                                            <p class="card-title font-weight-bold p-2"
                                                style="font-size:15px; color:#434d57">
                                                {{ substr($news['data'][$i]['title'], 0, 40) }}</p>
                                            <p class="mb-0" style="font-size:15px; color:#7a8da0">
                                                {{ $news['data'][$i]['author'] }}</p>
                                            <p class="mb-0" style="font-size:15px; color:#62676b">
                                                {{ $news['data'][$i]['source'] }}</p>
                                            <i class="fa fa-clock-o mb-0" style="font-size:12px; color:#929496">
                                                {{ $news['data'][$i]['published_at'] }}</i>&nbsp;&nbsp;

                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                {{-- <div class="col-md-3 animate-box" data-animate-effect="fadeInRight" >
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py- mb-3">Latest News</div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection










{{-- @extends('frontend.main_master')
@section('title', 'view')
@section('content')
    <div class="container-fluid pt-3">
        <div class="container animate-box" data-animate-effect="fadeIn">
            <div>
                <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">News</div>
            </div>
            <div class="owl-carousel owl-theme js" id="slider1">
                @for ($i = 0; $i < count($news['data']); $i++)
                    <div class="item px-2">
                        <a href="{{ $news['data'][$i]['url'] }}" target="_blank">
                            <div class="card fh5co_latest_trading_img_position_relative"
                                style="width: 240px; height: 200px;">
                                <img class="card-img-top fh5co_latest_trading_img"
                                    src=" {{ $news['data'][$i]['image'] ? $news['data'][$i]['image'] : asset('frontend/images/science-578x362.jpg') }}"
                                    alt="Card image cap" style="width: 240px; height: 200px;">
                                <div class="card-footer"> --}}


{{-- <p class="card-title">Title: {{ $news['data'][$i]['title'] }}</p> --}}
{{-- <p class="card-title"> {{ substr($news['data'][$i]['title'], 0, 30) }}</p>

                                    <p class="mb-0" style="font-size:11px; color:#929496">
                                        {{ $news['data'][$i]['published_at'] }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection --}}
