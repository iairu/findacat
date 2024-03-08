<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.delete') }} : {{ $cat->full_name }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tr><td>{{ __('cat.titles_before_name') }}</td><td>{{ $cat->titles_before_name }}</td></tr>
            <tr><td>{{ __('cat.full_name') }}</td><td>{{ $cat->full_name }}</td></tr>
            <tr><td>{{ __('cat.titles_after_name') }}</td><td>{{ $cat->titles_after_name }}</td></tr>
            <tr><td>{{ __('cat.gender_id') }}</td><td>{{ $cat->gender_id }}</td></tr>
            <tr><td>{{ __('cat.sire') }}</td><td>{{ $cat->sire_id ? $cat->sire->full_name : '' }}</td></tr>
            <tr><td>{{ __('cat.dam') }}</td><td>{{ $cat->dam_id ? $cat->dam->full_name : '' }}</td></tr>
        </table>
        @if ($childsCount + $spousesCount + $managedUserCount + $managedCoupleCount)
            {{ __('cat.replace_delete_text') }}
            {{ Form::open([
                'route' => ['cats.destroy', $cat],
                'method' => 'delete',
                'onsubmit' => 'return confirm("'.__('cat.replace_confirm').'")',
            ]) }}
            {!! FormField::select('replacement_cat_id', $replacementUsers, [
                'label' => false,
                'placeholder' => __('cat.replacement'),
            ]) !!}
            {{ Form::submit(__('cat.replace_delete_button'), [
                'full_name' => 'replace_delete_button',
                'class' => 'btn btn-danger',
            ]) }}
            {{ link_to_route('cats.edit', __('app.cancel'), [$cat], ['class' => 'btn btn-default pull-right']) }}
            {{ Form::close() }}
        @else
            {!! FormField::delete(
                ['route' => ['cats.destroy', $cat]],
                __('cat.delete_confirm_button'),
                ['class' => 'btn btn-danger'],
                ['cat_id' => $cat->id]
            ) !!}
            {{ link_to_route('cats.edit', __('app.cancel'), [$cat], ['class' => 'btn btn-default']) }}
        @endif
    </div>
</div>
