@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('titles_before_name') ? ' has-error' : '' }}">
                            <label for="titles_before_name" class="col-md-4 control-label">{{ trans('cat.titles_before_name') }}</label>

                            <div class="col-md-6">
                                <input id="titles_before_name" type="text" class="form-control" name="titles_before_name" value="{{ old('titles_before_name') }}" required>

                                @if ($errors->has('titles_before_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titles_before_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <label for="full_name" class="col-md-4 control-label">{{ trans('cat.full_name') }}</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required>

                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('titles_after_name') ? ' has-error' : '' }}">
                            <label for="titles_after_name" class="col-md-4 control-label">{{ trans('cat.titles_after_name') }}</label>

                            <div class="col-md-6">
                                <input id="titles_after_name" type="text" class="form-control" name="titles_after_name" value="{{ old('titles_after_name') }}" required>

                                @if ($errors->has('titles_after_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titles_after_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ems_color') ? ' has-error' : '' }}">
                            <label for="ems_color" class="col-md-4 control-label">{{ trans('cat.ems_color') }}</label>

                            <div class="col-md-6">
                                <input id="ems_color" type="text" class="form-control" name="ems_color" value="{{ old('ems_color') }}" required>

                                @if ($errors->has('ems_color'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ems_color') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('breed') ? ' has-error' : '' }}">
                            <label for="breed" class="col-md-4 control-label">{{ trans('cat.breed') }}</label>

                            <div class="col-md-6">
                                <input id="breed" type="text" class="form-control" name="breed" value="{{ old('breed') }}" required>

                                @if ($errors->has('breed'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('breed') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender_id') ? ' has-error' : '' }}">
                            <label for="gender_id" class="col-md-4 control-label">{{ trans('cat.gender') }}</label>

                            <div class="col-md-4" style="padding-left: 2em;">
                                {!! FormField::radios('gender_id', [1 => trans('app.male'), 2 => trans('app.female')], ['label' => false]) !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
