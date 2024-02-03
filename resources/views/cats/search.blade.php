@extends('layouts.app')

@section('content')
<h2 class="page-header">
    {{ trans('app.find_a_cat') }}
    @if (request('q'))
    <small class="pull-right">{!! trans('app.cat_found', ['total' => $cats->total(), 'keyword' => request('q')]) !!}</small>
    @endif
</h2>


{{ Form::open(['method' => 'get','class' => '']) }}
<div class="input-group">
    {{ Form::text('full_name', request('full_name'), ['class' => 'form-control', 'placeholder' => trans('cat.full_name')]) }}
    {{ Form::text('ems_color', request('ems_color'), ['class' => 'form-control', 'placeholder' => trans('cat.ems_color')]) }}
    {{ Form::text('dob', request('dob'), ['class' => 'form-control', 'placeholder' => trans('cat.dob')]) }}
    {{ Form::text('breed', request('breed'), ['class' => 'form-control', 'placeholder' => trans('cat.breed')]) }}
    {{ Form::text('reg_num', request('reg_num'), ['class' => 'form-control', 'placeholder' => trans('cat.reg_num')]) }}
    <select name="kind" id="kind" required>
        <option value="substring">substring</option>
        <option value="approximate">approximate</option>
        <option value="exact">exact</option>
    </select>
    <select name="generations" id="generations" required>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
    </select>
    <span class="input-group-btn">
        {{ Form::submit(trans('app.search'), ['class' => 'btn btn-default']) }}
        {{ link_to_route('cats.search', 'Reset', [], ['class' => 'btn btn-default']) }}
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
