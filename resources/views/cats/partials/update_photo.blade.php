<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.update_photo') }}</h3></div>
    {{ Form::open(['route' => ['cats.photo-upload', $cat], 'method' => 'patch', 'files' => true]) }}
    <div class="panel-body text-center">
        {{ catPhoto($cat, ['style' => 'width:100%;max-width:300px']) }}
    </div>
    <div class="panel-body">
        {!! FormField::file('photo', ['required' => true, 'label' => __('cat.reupload_photo'), 'info' => ['text' => 'Format jpg, maks: 200 Kb.', 'class' => 'warning']]) !!}
    </div>
    <div class="panel-footer">
        {!! Form::submit(__('cat.update_photo'), ['class' => 'btn btn-success']) !!}
        {{ link_to_route('cats.show', __('app.cancel'), [$cat], ['class' => 'btn btn-default']) }}
    </div>
    {{ Form::close() }}
</div>
