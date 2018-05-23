@inject('systemPresenter','App\Presenters\SystemPresenter')

@extends('layouts.app')

@section('title',$systemPresenter->checkReturnValue('title',$category->title))

@section('description',$systemPresenter->checkReturnValue('seo_desc',$category->desc))

@section('keywords',$systemPresenter->checkReturnValue('seo_keyword',$category->keyword))

@section('header-text')
    <div class="text-inner">
        <div class="row">
            <div class="col-md-12">
                <h3 class="to-animate fadeInUp animated color-white">
                    <i class="glyphicon glyphicon-th-list"></i>
                    &nbsp;{{ $category->name }}
                </h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('default.article')
@endsection