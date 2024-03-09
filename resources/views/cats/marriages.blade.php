@extends('layouts.cat-profile')

@section('ext_css')
<style>
body {
        background-image: url("images/cat-1045782-3.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
.navbar-default  {
        background: white;
}
</style>
@endsection

@section('subtitle', trans('cat.marriages'))

@section('cat-content')

<div class="row">
    @foreach ($marriages as $marriage)
    <div class="col-md-4">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <tr><th class="col-xs-5">{{ trans('couple.husband') }}</th><td>{{ $marriage->husband->profileLink() }}</th></tr>
                <tr><th>{{ trans('couple.wife') }}</th><td>{{ $marriage->wife->profileLink() }}</th></tr>
                <tr><th>{{ trans('couple.marriage_date') }}</th><td>{{ $marriage->marriage_date }}</th></tr>
                @if ($marriage->divorce_date)
                <tr><th>{{ trans('couple.divorce_date') }}</th><td>{{ $marriage->divorce_date }}</th></tr>
                @endif
                <tr><th>{{ trans('couple.childs_count') }}</th><td>{{ $marriage->childs_count }}</th></tr>
                {{-- <tr><th>{{ trans('couple.grand_childs_count') }}</th><td>?</th></tr> --}}
            </table>
            <div class="panel-footer">
                {{ link_to_route('couples.show', trans('couple.show'), [$marriage->id], ['class' => 'btn btn-default btn-xs']) }}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
