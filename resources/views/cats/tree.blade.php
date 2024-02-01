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

                <tr class="offspring">

                    <td> Offspring: <input class="ind" id="offspring" type="text">{{$cat->l()}}

                        <br>

                        &nbsp;
                    </td>

                    <td class="anc">

                        <table data-level="1">

                            <tbody>

                                <tr class="s">

                                    <td> Sire: <input class="ind" id="s" type="text">{{$cat->f()->l()}}<br>

                                        &nbsp; </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>

                                                <tr class="s">

                                                    <td> <input class="ind" id="ss" type="text"> </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sss" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssss" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssssd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sssd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssdd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ssd" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssds" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdsd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ssdd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssddd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>

                                                <tr class="d">

                                                    <td> <input class="ind" id="sd" type="text"> </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sds" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdss" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdssd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sdsd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsdd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                                <tr class="d">

                                                                    <td> <input class="ind" id="sdd" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdds" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddsd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sddd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdddd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </td>

                                </tr>

                                <tr class="d">

                                    <td> Dam:<br>

                                        <input class="ind" id="d" type="text"> <br>

                                        &nbsp;
                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>

                                                <tr class="s">

                                                    <td> <input class="ind" id="ds" type="text"> </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dss" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsss" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsssd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dssd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssdd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                                <tr class="d">

                                                                    <td> <input class="ind" id="dsd" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsds" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdsd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dsdd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsddd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>

                                                <tr class="d">

                                                    <td> <input class="ind" id="dd" type="text"> </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dds" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddss" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddssd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ddsd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsdd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ddd" type="text"> </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddds" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddss">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddsd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dddd" type="text">

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddds">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddddd">
                                                                                                    </td>
                                                                                                    <td class="anc"></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>
</div>
<hr>

@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection