@extends('layouts.cat-profile-wide')

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

<div class="tree">
    <ul>
        <li>
            {{ link_to_route('cats.tree', $cat->full_name, [$cat->id], ['title' => $cat->full_name.' ('.$cat->gender.')']) }}
            @if ($cat->childs->count())
            <ul>
                @foreach($cat->childs as $child)
                <li>
                    {{ link_to_route('cats.tree', $child->id, [$child->id], ['title' => $child->full_name.' ('.$child->gender.')']) }}
                    @if ($child->childs->count())
                    <ul>
                        @foreach($child->childs as $grand)
                        <li>
                            {{ link_to_route('cats.tree', $grand->id, [$grand->id], ['title' => $grand->full_name.' ('.$grand->gender.')']) }}
                            @if ($grand->childs->count())
                            <ul>
                                @foreach($grand->childs as $gg)
                                <li>
                                    {{ link_to_route('cats.tree', $gg->id, [$gg->id], ['title' => $gg->full_name.' ('.$gg->gender.')']) }}
                                    <?php /*
                                    @if ($gg->childs->count())
                                    <ul>
                                        @foreach($gg->childs as $ggc)
                                        <li>
                                            {{ link_to_route('cats.tree', $ggc->id, [$ggc->id], ['title' => $ggc->full_name.' ('.$ggc->gender.')']) }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    */ ?>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
    </ul>
    <div class="clearfix"></div>
</div>
@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree2.css') }}">
@endsection
