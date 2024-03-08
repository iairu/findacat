<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('cat.siblings') }}</h3></div>
    <table class="table">
        <tbody>
            @foreach($cat->siblings() as $sibling)
            <tr>
                <td>
                    {{ $sibling->profileLink() }} ({{ $sibling->gender }})
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>