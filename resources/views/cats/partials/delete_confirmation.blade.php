<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.delete') }} : {{ $cat->name }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tr><td>{{ __('cat.name') }}</td><td>{{ $cat->name }}</td></tr>
            <tr><td>{{ __('cat.nickname') }}</td><td>{{ $cat->nickname }}</td></tr>
            <tr><td>{{ __('cat.gender') }}</td><td>{{ $cat->gender }}</td></tr>
            <tr><td>{{ __('cat.father') }}</td><td>{{ $cat->father_id ? $cat->father->name : '' }}</td></tr>
            <tr><td>{{ __('cat.mother') }}</td><td>{{ $cat->mother_id ? $cat->mother->name : '' }}</td></tr>
            <tr><td>{{ __('cat.childs_count') }}</td><td>{{ $childsCount = $cat->childs()->count() }}</td></tr>
            <tr><td>{{ __('cat.spouses_count') }}</td><td>{{ $spousesCount = $cat->marriages()->count() }}</td></tr>
            <tr><td>{{ __('cat.managed_cat') }}</td><td>{{ $managedUserCount = $cat->managedUsers()->count() }}</td></tr>
            <tr><td>{{ __('cat.managed_couple') }}</td><td>{{ $managedCoupleCount = $cat->managedCouples()->count() }}</td></tr>
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
                'name' => 'replace_delete_button',
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
