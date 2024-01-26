<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('cat.details') }}</h3></div>
    <div class="panel-body">
        {!! FormField::text('dob', ['label' => __('cat.dob'), 'placeholder' => __('app.example').' 1959-07-20']) !!}
        {!! FormField::textarea('genetic_tests', ['label' => __('cat.genetic_tests')]) !!}
        {!! FormField::text('chip_number', ['label' => __('cat.chip_number')]) !!}
        {!! FormField::text('registration_numbers', ['label' => __('cat.registration_numbers')]) !!}
    </div>
</div>
