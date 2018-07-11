@inject('systemPresenter','App\Presenters\SystemPresenter')

@extends('layouts.app')

@section('title',$systemPresenter->getKeyValue('title'))

@section('description',$systemPresenter->getKeyValue('seo_desc'))

@section('keywords',$systemPresenter->getKeyValue('seo_keyword'))

@section('content')
    <div class="pagebg timer"> </div>
    <div class="container">
        <h1 class="t_nav"><a href="/" class="n1">网站首页</a><a class="n2">时间轴</a></h1>
        <div class="timebox">
            <ul id="list">
                @foreach($articles as $article)
                    <li><span>{{date('Y-m-d',strtotime($article->created_at))}}</span><a href="{{ route('article',['id'=>$article->id]) }}" title="{{$article->title}}" target="_blank">{{$article->title}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
