@extends('layouts.cat-profile-wide')

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

@section('ext_css')
<script src="/js/jquery.min.js"></script>
<script src="/js/inbreeding.js"></script>
</style>
@endsection


<div id="generations">Generations: <span class="generations">{{$generations}}</span></div>
<div id="controls">
    <h3 class="result">Inbreeding:
        <span id="result"><i>F</i> = 0.0%</span>
    </h3>
    <button id="calculate">Calculate</button>
</div>
<div id="wrapper" class="family-tree">
    <div id="pedigree">

        <table data-level="0">

            <tbody>
                @if ($cat)
                <tr class="offspring">

                    <td> Offspring:<br><input class="ind" id="offspring" type="text" data="{{$cat->id()}}" disabled><br>{{$cat->l()}}<br>

                        &nbsp;
                    </td>

                    <td class="anc">

                        <table data-level="1">

                            <tbody>
                                @if ($cat->s())
                                <tr class="s">

                                    <td> Sire:<br><input class="ind" id="s" type="text" data="{{$cat->s()->id()}}" disabled><br>{{$cat->s()->l()}}<br>

                                        &nbsp; </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat->s()->s())
                                                <tr class="s">

                                                    <td> <input class="ind" id="ss" type="text" data="{{$cat->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->l()}} </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat->s()->s()->s())
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sss" type="text" data="{{$cat->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->s()->s()->s()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssss" type="text" data="{{$cat->s()->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->s()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssss" data="{{$cat->s()->s()->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->s()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssssd" data="{{$cat->s()->s()->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->s()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->s()->s()->s()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sssd" type="text" data="{{$cat->s()->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->s()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->s()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssds" data="{{$cat->s()->s()->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->s()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssdd" data="{{$cat->s()->s()->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->s()->s()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                                @if ($cat->s()->s()->d())
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ssd" type="text" data="{{$cat->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->s()->s()->d()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssds" type="text" data="{{$cat->s()->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->s()->d()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->d()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdss" disabled><br>{{$cat->s()->s()->d()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->d()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdsd" disabled><br>{{$cat->s()->s()->d()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->s()->s()->d()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ssdd" type="text" data="{{$cat->s()->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->d()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdds" data="{{$cat->s()->s()->d()->d()->s()->id()}}" disabled><br>{{$cat->s()->s()->d()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->d()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssddd" data="{{$cat->s()->s()->d()->d()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>
                                                @endif
                                                @if ($cat->s()->d())
                                                <tr class="d">

                                                    <td> <input class="ind" id="sd" type="text" data="{{$cat->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->l()}} </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat->s()->d()->s())
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sds" type="text" data="{{$cat->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->s()->d()->s()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdss" type="text" data="{{$cat->s()->d()->s()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->s()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsss" data="{{$cat->s()->d()->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->s()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdssd" data="{{$cat->s()->d()->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->s()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif

                                                                                @if ($cat->s()->d()->s()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sdsd" type="text" data="{{$cat->s()->d()->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->s()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->s()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsds" data="{{$cat->s()->d()->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->s()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsdd" data="{{$cat->s()->d()->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->s()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                                @if ($cat->s()->d()->d())
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="sdd" type="text" data="{{$cat->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->s()->d()->d()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdds" type="text" data="{{$cat->s()->d()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->d()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->d()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddss" data="{{$cat->s()->d()->d()->s()->s()->id()}}" disabled><br>{{$cat->s()->d()->d()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->d()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddsd" data="{{$cat->s()->d()->d()->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->s()->d()->d()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sddd" type="text" data="{{$cat->s()->d()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->d()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddds" data="{{$cat->s()->d()->d()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->d()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->d()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdddd" data="{{$cat->s()->d()->d()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>
                                                @endif
                                            </tbody>

                                        </table>

                                    </td>

                                </tr>
                                @endif
                                @if ($cat->d())
                                <tr class="d">

                                    <td> Dam:<br>

                                        <input class="ind" id="d" type="text" data="{{$cat->d()->id()}}" disabled><br>{{$cat->d()->l()}}<br>

                                        &nbsp;
                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat->d()->s())
                                                <tr class="s">

                                                    <td> <input class="ind" id="ds" type="text" data="{{$cat->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->l()}} </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat->d()->s()->s())
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dss" type="text" data="{{$cat->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->d()->s()->s()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsss" type="text" data="{{$cat->d()->s()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->s()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssss" data="{{$cat->d()->s()->s()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->s()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsssd" data="{{$cat->d()->s()->s()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->s()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->d()->s()->s()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dssd" type="text" data="{{$cat->d()->s()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->s()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->s()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssds" data="{{$cat->d()->s()->s()->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->s()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssdd" data="{{$cat->d()->s()->s()->d()->d()->id()}}" disabled><br>{{$cat->d()->s()->s()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                                @if ($cat->d()->s()->d())
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="dsd" type="text" data="{{$cat->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->d()->s()->d()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsds" type="text" data="{{$cat->d()->s()->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->d()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->d()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdss" data="{{$cat->d()->s()->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->d()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->d()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdsd" data="{{$cat->d()->s()->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->d()->s()->d()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dsdd" type="text" data="{{$cat->d()->s()->d()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->d()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdds" data="{{$cat->d()->s()->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->d()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->d()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsddd" data="{{$cat->d()->s()->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>
                                                @endif
                                                @if ($cat->d()->d())
                                                <tr class="d">

                                                    <td> <input class="ind" id="dd" type="text" data="{{$cat->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->l()}} </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat->d()->d()->s())
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dds" type="text" data="{{$cat->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->d()->d()->s()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddss" type="text" data="{{$cat->d()->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->d()->s()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsss" data="{{$cat->d()->d()->s()->s()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif

                                                                                                @if ($cat->d()->d()->s()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddssd" data="{{$cat->d()->d()->s()->s()->d()->id()}}" disabled><br>{{$cat->d()->d()->s()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif

                                                                                @if ($cat->d()->d()->s()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ddsd" type="text" data="{{$cat->d()->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->d()->s()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>

                                                                                                @if ($cat->d()->d()->s()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsds" data="{{$cat->d()->d()->s()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                                @if ($cat->d()->d()->s()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsdd" data="{{$cat->d()->d()->s()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->s()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif
                                                                @if ($cat->d()->d()->d())
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ddd" type="text" data="{{$cat->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->l()}} </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->d()->d()->d()->s())
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddds" type="text" data="{{$cat->d()->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->d()->s()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->d()->d()->s()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddss" data="{{$cat->d()->d()->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->d()->d()->s()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif

                                                                                                @if ($cat->d()->d()->d()->s()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddsd" data="{{$cat->d()->d()->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->s()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                                @if ($cat->d()->d()->d()->d())
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dddd" type="text" data="{{$cat->d()->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->d()->l()}}

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->d()->d()->d()->s())
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddds" data="{{$cat->d()->d()->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->d()->d()->s()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif

                                                                                                @if ($cat->d()->d()->d()->d()->d())
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddddd" data="{{$cat->d()->d()->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->d()->d()->l()}}
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>
                                                                                @endif
                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>
                                                                @endif

                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>
                                                @endif

                                            </tbody>

                                        </table>

                                    </td>

                                </tr>
                                @endif
                            </tbody>

                        </table>

                    </td>

                </tr>
                @endif
            </tbody>

        </table>

    </div>
</div>
<hr>

@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection