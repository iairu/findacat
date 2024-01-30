<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.edit') }}</h3></div>
    <div class="panel-body">
        {!! FormField::text('titles_before_name', ['label' => __('cat.titles_before_name')]) !!}
        {!! FormField::text('full_name', ['label' => __('cat.full_name')]) !!}
        {!! FormField::text('titles_after_name', ['label' => __('cat.titles_after_name')]) !!}
        {!! FormField::text('ems_color', ['label' => __('cat.ems_color')]) !!}
        {!! FormField::text('breed', ['label' => __('cat.breed')]) !!}
        <h4 class="panel-title">{{ __('cat.ems_color_translated') }}:</h4>
        <div class="row">
            <div class="col-md-6">{!! FormField::radios('gender_id', [1 => __('app.male_code'), __('app.female_code')], ['label' => __('cat.gender')]) !!}</div>
        </div>
    </div>
</div>
