<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.family') }}</h3></div>

    <table class="table">
        <tbody>
            <tr>
                <th class="col-sm-4">{{ __('cat.sire') }}</th>
                <td class="col-sm-8">
                        @if (request('action') == 'set_sire')
                        {{ Form::open(['route' => ['family-actions.set-sire', $cat->id]]) }}
                        {!! FormField::select('set_sire_id', $malePersonList, ['label' => false, 'value' => $cat->sire_id, 'placeholder' => __('app.select_from_existing_males')]) !!}
                        <div class="input-group">
                            {{ Form::text('set_sire', null, ['class' => 'form-control input-sm', 'placeholder' => __('app.enter_new_name')]) }}
                            <span class="input-group-btn">
                                {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_sire_button']) }}
                                {{ link_to_route('cats.show', __('app.cancel'), [$cat->id], ['class' => 'btn btn-default btn-sm']) }}
                            </span>
                        </div>
                        {{ Form::close() }}
                        @else
                            {{ $cat->sireLink() }}
                            <div class="pull-right">
                                {{ link_to_route('cats.show', __('cat.set_sire'), [$cat->id, 'action' => 'set_sire'], ['class' => 'btn btn-link btn-xs']) }}
                            </div>
                        @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('cat.dam') }}</th>
                <td>
                        @if (request('action') == 'set_dam')
                        {{ Form::open(['route' => ['family-actions.set-dam', $cat->id]]) }}
                        {!! FormField::select('set_dam_id', $femalePersonList, ['label' => false, 'value' => $cat->dam_id, 'placeholder' => __('app.select_from_existing_females')]) !!}
                        <div class="input-group">
                            {{ Form::text('set_dam', null, ['class' => 'form-control input-sm', 'placeholder' => __('app.enter_new_name')]) }}
                            <span class="input-group-btn">
                                {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_dam_button']) }}
                                {{ link_to_route('cats.show', __('app.cancel'), [$cat->id], ['class' => 'btn btn-default btn-sm']) }}
                            </span>
                        </div>
                        {{ Form::close() }}
                        @else
                            {{ $cat->damLink() }}
                            <div class="pull-right">
                                {{ link_to_route('cats.show', __('cat.set_dam'), [$cat->id, 'action' => 'set_dam'], ['class' => 'btn btn-link btn-xs']) }}
                            </div>
                        @endif
                </td>
            </tr>
            @if ($cat->gender_id == 1)
            <tr>
                <th>{{ __('cat.wife') }}</th>
                <td>
                    <div class="pull-right">
                        @unless (request('action') == 'add_spouse')
                            {{ link_to_route('cats.show', __('cat.add_wife'), [$cat->id, 'action' => 'add_spouse'], ['class' => 'btn btn-link btn-xs']) }}
                        @endunless
                    </div>

                    @if ($cat->wifes->isEmpty() == false)
                        <ul class="list-unstyled">
                            @foreach($cat->wifes as $wife)
                            <li>{{ $wife->profileLink() }}</li>
                            @endforeach
                        </ul>
                    @endif
                        @if (request('action') == 'add_spouse')
                        <div>
                        {{ Form::open(['route' => ['family-actions.add-wife', $cat->id]]) }}
                        {!! FormField::select('set_wife_id', $femalePersonList, ['label' => false, 'placeholder' => __('app.select_from_existing_females')]) !!}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-7">
                                    {{ Form::text('set_wife', null, ['class' => 'form-control input-sm', 'placeholder' => __('app.enter_new_name')]) }}
                                </div>
                                <div class="col-md-5">
                                    {{ Form::text('marriage_date', null, ['class' => 'form-control input-sm', 'placeholder' => __('couple.marriage_date')]) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_wife_button']) }}
                        {{ link_to_route('cats.show', __('app.cancel'), $cat, ['class' => 'btn btn-default btn-sm']) }}
                        {{ Form::close() }}
                    </div>
                    @endif
                </td>
            </tr>
            @else
            <tr>
                <th>{{ __('cat.husband') }}</th>
                <td>
                    <div class="pull-right">
                        @unless (request('action') == 'add_spouse')
                            {{ link_to_route('cats.show', __('cat.add_husband'), [$cat->id, 'action' => 'add_spouse'], ['class' => 'btn btn-link btn-xs']) }}
                        @endunless
                    </div>
                    @if ($cat->husbands->isEmpty() == false)
                        <ul class="list-unstyled">
                            @foreach($cat->husbands as $husband)
                            <li>{{ $husband->profileLink() }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if (request('action') == 'add_spouse')
                    <div>
                        {{ Form::open(['route' => ['family-actions.add-husband', $cat->id]]) }}
                        {!! FormField::select('set_husband_id', $malePersonList, ['label' => false, 'placeholder' => __('app.select_from_existing_males')]) !!}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-7">
                                    {{ Form::text('set_husband', null, ['class' => 'form-control input-sm', 'placeholder' => __('app.enter_new_name')]) }}
                                </div>
                                <div class="col-md-5">
                                    {{ Form::text('marriage_date', null, ['class' => 'form-control input-sm', 'placeholder' => __('couple.marriage_date')]) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_husband_button']) }}
                        {{ link_to_route('cats.show', __('app.cancel'), [$cat->id], ['class' => 'btn btn-default btn-sm']) }}
                        {{ Form::close() }}
                    </div>
                    @endif
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
