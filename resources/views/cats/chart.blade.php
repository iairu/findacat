@extends('layouts.cat-profile-wide')

@section('subtitle', trans('app.family_chart'))

@section('cat-content')
<div class="panel panel-default table-responsive">
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th style="width: 9%">{{ trans('cat.grand_father') }} & {{ trans('cat.grand_mother') }}</th>
                <td class="text-center">
                    {{ $fatherGrandpa ? $fatherGrandpa->profileLink('chart') : '?' }}
                </td>
                <td class="text-center">
                    {{ $fatherGrandma ? $fatherGrandma->profileLink('chart') : '?' }}
                </td>
                <td class="text-center">
                    {{ $motherGrandpa ? $motherGrandpa->profileLink('chart') : '?' }}
                </td>
                <td class="text-center">
                    {{ $motherGrandma ? $motherGrandma->profileLink('chart') : '?' }}
                </td>
            </tr>
            <tr>
                <th>{{ trans('cat.father') }} & {{ trans('cat.mother') }}</th>
                <td class="text-center" colspan="2">
                    {{ $father ? $father->profileLink('chart') : '?' }}
                </td>
                <td class="text-center" colspan="2">
                    {{ $mother ? $mother->profileLink('chart') : '?' }}
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td class="text-center lead" colspan="4">
                    <strong>{{ $cat->profileLink('chart') }} ({{ $cat->gender }})</strong>
                </td>
            </tr>
            <tr>
                <th>{{ trans('cat.childs') }} & {{ trans('cat.grand_childs') }}</th>
                <td colspan="4">
                    <?php $no = 0; ?>
                    @foreach($childs->chunk(4) as $chunkedChild)
                    <div class="">
                        @foreach($chunkedChild as $child)
                        <div class="col-md-3">
                            <h4><strong>{{ ++$no }}. {{ $child->profileLink('chart') }} ({{ $child->gender }})</strong></h4>
                            <ul style="padding-left: 30px">
                                @foreach($child->childs as $grand)
                                <li>{{ $grand->profileLink('chart') }} ({{ $grand->gender }})</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                        @if (! $loop->last)
                        <div class="clearfix"></div><hr>
                        @endif
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h4 class="page-header">
    {{ trans('cat.siblings') }}, {{ trans('cat.nieces') }}, & {{ trans('cat.grand_childs') }}
</h4>
@foreach ($siblings->chunk(3) as $chunkedSiblings)
<div class="row">
    @foreach ($chunkedSiblings as $sibling)
    <div class="col-sm-4">
        @include('cats.partials.chart-sibling')
    </div>
    @endforeach
</div>
@endforeach
@endsection
