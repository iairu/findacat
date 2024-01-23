<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('cat.profile') }}</h3></div>
    <div class="panel-body text-center">
        {{ catPhoto($cat, ['style' => 'width:100%;max-width:300px']) }}
    </div>
    <table class="table">
        <tbody>
            <tr>
                <th class="col-sm-4">{{ trans('cat.name') }}</th>
                <td class="col-sm-8">{{ $cat->profileLink() }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.nickname') }}</th>
                <td>{{ $cat->nickname }}</td>
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
                <th>{{ trans('cat.birth_order') }}</th>
                <td>{{ $cat->birth_order }}</td>
            </tr>
            @if ($cat->dod)
            <tr>
                <th>{{ trans('cat.dod') }}</th>
                <td>{{ $cat->dod }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ trans('cat.age') }}</th>
                <td>
                    @if ($cat->age)
                        {!! $cat->age_string !!}
                    @endif
                </td>
            </tr>
            @if ($cat->email)
            <tr>
                <th>{{ trans('cat.email') }}</th>
                <td>{{ $cat->email }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ trans('cat.phone') }}</th>
                <td>{{ $cat->phone }}</td>
            </tr>
            <tr>
                <th>{{ trans('cat.address') }}</th>
                <td>{!! nl2br($cat->address) !!}</td>
            </tr>
        </tbody>
    </table>
</div>
