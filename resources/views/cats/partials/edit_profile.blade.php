<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.edit') }}</h3></div>
    <div class="panel-body">
        {!! FormField::text('name', ['label' => __('cat.name')]) !!}
        {!! FormField::text('nickname', ['label' => __('cat.nickname')]) !!}
        <div class="row">
            <div class="col-md-6">{!! FormField::radios('gender_id', [1 => __('app.male_code'), __('app.female_code')], ['label' => __('cat.gender')]) !!}</div>
            <div class="col-md-4">
                {!! FormField::text('birth_order', ['label' => __('cat.birth_order'), 'type' => 'number', 'min' => 1]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">{!! FormField::text('yob', ['label' => __('cat.yob'), 'placeholder' => __('app.example').' 1959']) !!}</div>
            <div class="col-md-6">{!! FormField::text('dob', ['label' => __('cat.dob'), 'placeholder' => __('app.example').' 1959-07-20']) !!}</div>
        </div>
    </div>
</div>
