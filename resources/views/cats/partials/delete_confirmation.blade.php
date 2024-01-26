<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.delete') }} : {{ $cat->name }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tr><td>{{ __('cat.full_name') }}</td><td>{{ $cat->full_name }}</td></tr>
            <tr><td>{{ __('cat.gender_id') }}</td><td>{{ $cat->gender_id }}</td></tr>
            <tr><td>{{ __('cat.titles_before_name') }}</td><td>{{ $cat->titles_before_name }}</td></tr>
            <tr><td>{{ __('cat.titles_after_name') }}</td><td>{{ $cat->father_id ? $cat->father->full_name : '' }}</td></tr>
            <tr><td>{{ __('cat.registration_numbers') }}</td><td>{{ $cat->mother_id ? $cat->mother->full_name : '' }}</td></tr>
            <tr><td>{{ __('cat.ems_color') }}</td><td>{{ $childsCount = $cat->childs()->count() }}</td></tr>
            <tr><td>{{ __('cat.chip_number') }}</td><td>{{ $spousesCount = $cat->marriages()->count() }}</td></tr>
            <tr><td>{{ __('cat.genetic_tests') }}</td><td>{{ $managedUserCount = $cat->managedUsers()->count() }}</td></tr>
            <tr><td>{{ __('cat.dob') }}</td><td>{{ $managedCoupleCount = $cat->managedCouples()->count() }}</td></tr>
            <tr><td>{{ __('cat.father_id') }}</td><td>{{ $managedCoupleCount = $cat->managedCouples()->count() }}</td></tr>
            <tr><td>{{ __('cat.mother_id') }}</td><td>{{ $managedCoupleCount = $cat->managedCouples()->count() }}</td></tr>
            <tr><td>{{ __('cat.parent_id') }}</td><td>{{ $managedCoupleCount = $cat->managedCouples()->count() }}</td></tr>
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
