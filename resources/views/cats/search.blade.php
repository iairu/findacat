@extends('layouts.app')

@section('content')
<h2 class="page-header">
    {{ trans('app.search_your_family') }}
    @if (request('q'))
    <small class="pull-right">{!! trans('app.cat_found', ['total' => $cats->total(), 'keyword' => request('q')]) !!}</small>
    @endif
</h2>


{{ Form::open(['method' => 'get','class' => '']) }}
<div class="input-group">
    {{ Form::text('q', request('q'), ['class' => 'form-control', 'placeholder' => trans('app.search_your_family_placeholder')]) }}
    <span class="input-group-btn">
        {{ Form::submit(trans('app.search'), ['class' => 'btn btn-default']) }}
        {{ link_to_route('cats.search', 'Reset', [], ['class' => 'btn btn-default']) }}
    </span>
</div>
{{ Form::close() }}

@if (request('q'))
<br>
{{ $cats->appends(Request::except('page'))->render() }}
@foreach ($cats->chunk(4) as $chunkedUser)
<div class="row">
    @foreach ($chunkedUser as $cat)
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                {{ catPhoto($cat, ['style' => 'width:100%;max-width:300px']) }}
                @if ($cat->age)
                    {!! $cat->age_string !!}
                @endif
            </div>
            <div class="panel-body">
                <h3 class="panel-title">{{ $cat->profileLink() }} ({{ $cat->gender }})</h3>
                <div>{{ trans('cat.nickname') }} : {{ $cat->nickname }}</div>
                <hr style="margin: 5px 0;">
                <div>{{ trans('cat.father') }} : {{ $cat->father_id ? $cat->father->name : '' }}</div>
                <div>{{ trans('cat.mother') }} : {{ $cat->mother_id ? $cat->mother->name : '' }}</div>
            </div>
            <div class="panel-footer">
                {{ link_to_route('cats.show', trans('app.show_profile'), [$cat->id], ['class' => 'btn btn-default btn-xs']) }}
                {{ link_to_route('cats.chart', trans('app.show_family_chart'), [$cat->id], ['class' => 'btn btn-default btn-xs']) }}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach

{{ $cats->appends(Request::except('page'))->render() }}
@endif
@endsection
