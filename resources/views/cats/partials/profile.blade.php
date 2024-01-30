<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('cat.profile') }}</h3></div>
    <table class="table">
        <tbody>
            <tr>
                <th>{{ trans('cat.titles_before_name') }}</th>
                <td>{{ $cat->titles_before_name }}</td>
            </tr>
            <tr>
                <th class="col-sm-4">{{ trans('cat.full_name') }}</th>
                <td class="col-sm-8">{{ $cat->profileLink() }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.titles_after_name') }}</th>
                <td>{{ $cat->titles_after_name }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.gender') }}</th>
                <td>{{ $cat->gender }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.dob') }}</th>
                <td>{{ $cat->dob }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.ems_color') }}</th>
                <td>{{ $cat->ems_color }} = </td>
            </tr>
            <tr>
                <th>{{ trans('cat.breed') }}</th>
                <td>{{ $cat->breed }} = </td>
            </tr>
            <tr>
                <th>{{ trans('cat.genetic_tests') }}</th>
                <td>{!! nl2br($cat->genetic_tests) !!}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.registration_numbers') }}</th>
                <td>{{ $cat->registration_numbers }}</td>
            </tr>
        </tbody>
    </table>
</div>
