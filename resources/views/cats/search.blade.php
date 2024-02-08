@extends('layouts.app')

@section('ext_css')
<style>
    html,body,#app {
        height: 100%;
        margin-bottom: 0 !important;
    }
    #app>.container {
        display: flex;
        min-height: 85%;
        flex-flow: column;
        justify-content: center;
    }
    .page-header {
        border-color: rgba(0,0,0,0.15) !important;
    }
    body {
        background-image: url("images/cat.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
</style>
@endsection

@section('content')
<h2 class="page-header" style="text-align: center">
<svg style="width:30px;height:30px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>

    {{ trans('app.find_a_cat') }}
    @if (request('q'))
    <small class="pull-right">{!! trans('app.cat_found', ['total' => $cats->total(), 'keyword' => request('q')]) !!}</small>
    @endif
</h2>


{{ Form::open(['method' => 'get','class' => '']) }}
<div class="input-group" style="width:100%">
    {{ Form::text('full_name', request('full_name'), ['class' => 'form-control', 'placeholder' => trans('cat.full_name')]) }}
    <details style="margin: 35px 0 0;">
        <summary style="cursor:pointer; width:100%;text-align:center; padding: 20px 0;">-- See more search options --</summary>
        {{ Form::text('ems_color', request('ems_color'), ['class' => 'form-control', 'placeholder' => trans('cat.ems_color')]) }}
        {{ Form::text('dob', request('dob'), ['class' => 'form-control', 'placeholder' => trans('cat.dob')]) }}
        {{ Form::text('breed', request('breed'), ['class' => 'form-control', 'placeholder' => trans('cat.breed')]) }}
        {{ Form::text('reg_num', request('reg_num'), ['class' => 'form-control', 'placeholder' => trans('cat.reg_num')]) }}
        <label for="kind">Search kind: </label>
        <select name="kind" id="kind" required>
            <option value="substring">substring</option>
            <option value="approximate">approximate</option>
            <option value="exact">exact</option>
        </select>
        <br>
        <label for="generations">Number of generations: </label>
        <select name="generations" id="generations" required>
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
        </select>
    </details>
    <span class="input-group-btn" style="display:flex;justify-content:center;width:100%;">
        {{ Form::submit(trans('app.search'), ['class' => 'btn btn-default']) }}
    </span>
</div>
{{ Form::close() }}

@if (request('full_name') || request('ems_color') || request('dob') || request('breed') || request('reg_num'))
<br>
{{ $cats->appends(Request::except('page'))->render() }}
@foreach ($cats->chunk(4) as $chunkedUser)
<div class="row">
    @foreach ($chunkedUser as $cat)
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div>{{ $cat->titles_before_name }}</div>
                <h3 class="panel-title">{{ $cat->profileLink() }} ({{ $cat->gender }})</h3>
                <div>{{ $cat->titles_after_name }}</div>
                <hr style="margin: 5px 0;">
                <div>{{ trans('cat.sire') }} : {{ $cat->sire_id ? $cat->sire->full_name : '' }}</div>
                <div>{{ trans('cat.dam') }} : {{ $cat->dam_id ? $cat->dam->full_name : '' }}</div>
            </div>
            <div class="panel-footer">
                {{ link_to_route('cats.show', trans('app.show_profile'), [$cat->id], ['class' => 'btn btn-default btn-xs']) }}
                {{ link_to_route('cats.tree', trans('app.show_family_tree'), [$cat->id, request('generations')], ['class' => 'btn btn-default btn-xs']) }}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach

{{ $cats->appends(Request::except('page'))->render() }}
@endif
@endsection
