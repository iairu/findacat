<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right" style="margin: -3px -6px">
            {{ link_to_route('cats.show', __('cat.add_child'), [$cat->id, 'action' => 'add_child'], ['class' => 'btn btn-success btn-xs']) }}
        </div>
        <h3 class="panel-title">{{ __('cat.childs') }} ({{ $cat->childs->count() }})</h3>
    </div>

    <ul class="list-group">
        @forelse($cat->childs as $child)
            <li class="list-group-item">
                {{ $child->profileLink() }} ({{ $child->gender }})
            </li>
        @empty
            <li class="list-group-item">{{ __('app.childs_were_not_recorded') }}</li>
        @endforelse
        @if (request('action') == 'add_child')
        <li class="list-group-item">
            {{ Form::open(['route' => ['family-actions.add-child', $cat->id]]) }}
            <div class="row">
                <div class="col-md-8">
                    {!! FormField::text('add_child_name', ['label' => __('cat.child_name')]) !!}
                </div>
                <div class="col-md-4">
                    {!! FormField::radios('add_child_gender_id', [1 => __('app.male'), 2 => __('app.female')], ['label' => __('cat.child_gender')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    {!! FormField::select('add_child_parent_id', $catsMariageList, ['label' => __('cat.add_child_from_existing_couples', ['name' => $cat->name]), 'placeholder' => __('app.unknown')]) !!}
                </div>
                <div class="col-md-4">
                    {!! FormField::text('add_child_birth_order', ['label' => __('cat.birth_order'), 'type' => 'number', 'min' => 1]) !!}
                </div>
            </div>

            {{ Form::submit(__('cat.add_child'), ['class' => 'btn btn-success btn-sm']) }}
            {{ link_to_route('cats.show', __('app.cancel'), [$cat->id], ['class' => 'btn btn-default btn-sm']) }}
            {{ Form::close() }}
        </li>
        @endif
    </ul>
</div>
