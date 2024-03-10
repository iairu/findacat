@extends('layouts.cat-profile-wide')

@section('ext_css')
<style>
body {
        background-image: url("images/cat-1045782-3.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
.navbar-default  {
        background: white;
}
</style>
<script>
    function maleButton(e) {
        e.preventDefault();
        var maleSelector = document.querySelector('select[name="set_sire_id"]');
        var cat = maleSelector.options[maleSelector.selectedIndex].value;
        var uriComponents = window.location.pathname.matchAll(/\/test\/([^\/]*)\/([^\/]*)\/?/g);
        for (const match of uriComponents) {
            var cat1 = match[1];
            var cat2 = match[2];
            var newURI = window.location.origin + "/test/" + cat + "/" + cat2;
            window.location.replace(newURI);
    }}
    function femaleButton(e) {
        e.preventDefault();
        var femaleSelector = document.querySelector('select[name="set_dam_id"]');
        var cat = femaleSelector.options[femaleSelector.selectedIndex].value;
        var uriComponents = window.location.pathname.matchAll(/\/test\/([^\/]*)\/([^\/]*)\/?/g);
        for (const match of uriComponents) {
            var cat1 = match[1];
            var cat2 = match[2];
            var newURI = window.location.origin + "/test/" + cat1 + "/" + cat;
            window.location.replace(newURI);
    }}
    function buttonBehavior() {
        document.querySelector('#set_sire_button').addEventListener("click", maleButton);
        document.querySelector('#set_dam_button').addEventListener("click", femaleButton);
        document.querySelector(".page-header").innerHTML = "Test Mating";
        document.querySelector(".pull-right").style = "display:none;";
        document.querySelector("#generations").style = "display:none;";
    }
    window.addEventListener('load', buttonBehavior);
</script>
@endsection

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

@section('ext_css')
<script src="/js/jquery.min.js"></script>
<script src="/js/inbreeding.js"></script>
<style>
    #pedigree input {
        border: 1px solid rgba(0,0,0,0.25) !important;
        background: none !important;
        padding: 0 10px;
        border-radius: 5px 0 0 0;
        margin: 5px 0 0;
        display: none;
    }
    #pedigree td br {
        display: none;
    }
    #pedigree a {
        border: 1px solid rgba(0,0,0,0.25);
        /* border-top: none; */
        display: block;
        position: relative;
        background: white;
        padding: 0 10px;
        border-radius: 5px 0 0 5px;
        margin: 0 0 5px;
        width: 15vw;
    }
</style>
@endsection


<div id="generations"><strong>Generations:</strong> <span class="generations">{{$generations}}</span> (
    <a href="./1">1</a>
    <a href="./2">2</a>
    <a href="./3">3</a>
    <a href="./4">4</a>
    <a href="./5">5</a>
)</div>
<div id="controls">
    <strong>Inbreeding:</strong>
        <span id="result"><i>F</i> = 0.0%</span>
</div>
<div id="set" style="display:flex;flex-flow:row;">
    <div class="sire">
        {{ Form::open(['route' => ['cats.test', $cat->id, $cat2->id]]) }}
        {!! FormField::select('set_sire_id', $malePersonList, ['label' => false, 'value' => $cat->sire_id, 'placeholder' => __('app.select_from_existing_males')]) !!}
        <div class="input-group">
            <span class="input-group-btn">
                {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_sire_button']) }}
            </span>
        </div>
        {{ Form::close() }}
    </div>
    <div class="dam">
        {{ Form::open(['route' => ['cats.test', $cat->id, $cat2->id]]) }}
        {!! FormField::select('set_dam_id', $femalePersonList, ['label' => false, 'value' => $cat2->dam_id, 'placeholder' => __('app.select_from_existing_females')]) !!}
        <div class="input-group">
            <span class="input-group-btn">
                {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_dam_button']) }}
            </span>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div id="wrapper" class="family-tree">
    <div id="pedigree">
        @php $json = "" @endphp
        <table data-level="0">

            <tbody>
                @php $json .= "{" @endphp
                <tr class="offspring">

                    <td> Offspring:<br><input class="ind" id="offspring" type="text" data="0" disabled><br>0<br>
                        @php $json .= "\"name\": \"" . "0" . ($generations >= 1 ? "\"," : "\"") @endphp

                    </td>

                    <td class="anc">

                        <table data-level="1">

                            <tbody>

                                @if ($cat && $generations >= 1)
                                @php $json .= "\"s\": {" @endphp
                                <tr class="s">
                                    <td> Sire:<br><input class="ind" id="s" type="text" data="{{$cat->id()}}" disabled><br>{{$cat->l($generations)}}<br>
                                        @php $json .= "\"name\": \"" . $cat->id() . ($generations >= 2 ? "\"," : "\"") @endphp
                                        
                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat->s() && $generations >= 2)
                                                @php $json .= "\"s\": {" @endphp
                                                <tr class="s">

                                                    <td> <input class="ind" id="ss" type="text" data="{{$cat->s()->id()}}" disabled><br>{{$cat->s()->l($generations)}}
                                                        @php $json .= "\"name\": \"" . $cat->s()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat->s()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sss" type="text" data="{{$cat->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->s()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssss" type="text" data="{{$cat->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssss" data="{{$cat->s()->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssssd" data="{{$cat->s()->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat->s()->s()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sssd" type="text" data="{{$cat->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssds" data="{{$cat->s()->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->s()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->s()->s()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssdd" data="{{$cat->s()->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}," @endphp
                                                                @endif
                                                                @if ($cat->s()->d() && $generations >= 3)
                                                                @php $json .= "\"d\": {" @endphp
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ssd" type="text" data="{{$cat->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->s()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssds" type="text" data="{{$cat->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdss" data="{{$cat->s()->d()->s()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdsd" data="{{$cat->s()->d()->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat->s()->d()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ssdd" type="text" data="{{$cat->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdds" data="{{$cat->s()->d()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->s()->d()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssddd" data="{{$cat->s()->d()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}" @endphp
                                                                @endif
                                                            </tbody>

                                                        </table>



                                                    </td>

                                                </tr>
                                                @php $json .= "}," @endphp
                                                @endif
                                                @if ($cat2 && $generations >= 2)
                                                @php $json .= "\"d\": {" @endphp
                                                <tr class="d">

                                                    <td> <input class="ind" id="sd" type="text" data="{{$cat2->id()}}" disabled><br>{{$cat2->l($generations)}}
                                                        @php $json .= "\"name\": \"" . $cat2->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat2->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sds" type="text" data="{{$cat2->s()->id()}}" disabled><br>{{$cat2->s()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat2->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdss" type="text" data="{{$cat2->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsss" data="{{$cat2->s()->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdssd" data="{{$cat2->s()->s()->d()->id()}}" disabled><br>{{$cat2->s()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif

                                                                                @if ($cat2->s()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sdsd" type="text" data="{{$cat2->s()->d()->id()}}" disabled><br>{{$cat2->s()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsds" data="{{$cat2->s()->d()->s()->id()}}" disabled><br>{{$cat2->s()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsdd" data="{{$cat2->s()->d()->d()->id()}}" disabled><br>{{$cat2->s()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}," @endphp
                                                                @endif
                                                                @if ($cat2->d() && $generations >= 3)
                                                                @php $json .= "\"d\": {" @endphp
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="sdd" type="text" data="{{$cat2->d()->id()}}" disabled><br>{{$cat2->d()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat2->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdds" type="text" data="{{$cat2->d()->s()->id()}}" disabled><br>{{$cat2->d()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddss" data="{{$cat2->d()->s()->s()->id()}}" disabled><br>{{$cat2->d()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->d()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddsd" data="{{$cat2->d()->s()->d()->id()}}" disabled><br>{{$cat2->d()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat2->d()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sddd" type="text" data="{{$cat2->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddds" data="{{$cat2->d()->d()->s()->id()}}" disabled><br>{{$cat2->d()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->d()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdddd" data="{{$cat2->d()->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}" @endphp
                                                                @endif
                                                            </tbody>

                                                        </table>



                                                    </td>

                                                </tr>
                                                @php $json .= "}" @endphp
                                                @endif
                                            </tbody>

                                        </table>



                                    </td>

                                </tr>
                                @php $json .= "}," @endphp
                                @endif

                                @if ($cat2 && $generations >= 1)
                                @php $json .= "\"d\": {" @endphp
                                <tr class="d">

                                    <td> Dam:<br>

                                        <input class="ind" id="d" type="text" data="{{$cat2->id()}}" disabled><br>{{$cat2->l($generations)}}<br>
                                        @php $json .= "\"name\": \"" . $cat2->id() . ($generations >= 2 ? "\"," : "\"") @endphp



                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat2->s() && $generations >= 2)
                                                @php $json .= "\"s\": {" @endphp
                                                <tr class="s">

                                                    <td> <input class="ind" id="ds" type="text" data="{{$cat2->s()->id()}}" disabled><br>{{$cat2->s()->l($generations)}}
                                                        @php $json .= "\"name\": \"" . $cat2->s()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat2->s()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dss" type="text" data="{{$cat2->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat2->s()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsss" type="text" data="{{$cat2->s()->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssss" data="{{$cat2->s()->s()->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->s()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsssd" data="{{$cat2->s()->s()->s()->d()->id()}}" disabled><br>{{$cat2->s()->s()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat2->s()->s()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dssd" type="text" data="{{$cat2->s()->s()->d()->id()}}" disabled><br>{{$cat2->s()->s()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssds" data="{{$cat2->s()->s()->d()->s()->id()}}" disabled><br>{{$cat2->s()->s()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->s()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssdd" data="{{$cat2->s()->s()->d()->d()->id()}}" disabled><br>{{$cat2->s()->s()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}," @endphp
                                                                @endif
                                                                @if ($cat2->s()->d() && $generations >= 3)
                                                                @php $json .= "\"d\": {" @endphp
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="dsd" type="text" data="{{$cat2->s()->d()->id()}}" disabled><br>{{$cat2->s()->d()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat2->s()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsds" type="text" data="{{$cat2->s()->d()->s()->id()}}" disabled><br>{{$cat2->s()->d()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdss" data="{{$cat2->s()->d()->s()->s()->id()}}" disabled><br>{{$cat2->s()->d()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->d()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdsd" data="{{$cat2->s()->d()->s()->d()->id()}}" disabled><br>{{$cat2->s()->d()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat2->s()->d()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dsdd" type="text" data="{{$cat2->s()->d()->d()->id()}}" disabled><br>{{$cat2->s()->d()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdds" data="{{$cat2->s()->d()->d()->s()->id()}}" disabled><br>{{$cat2->s()->d()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->s()->d()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsddd" data="{{$cat2->s()->d()->d()->d()->id()}}" disabled><br>{{$cat2->s()->d()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}" @endphp
                                                                @endif
                                                            </tbody>

                                                        </table>



                                                    </td>

                                                </tr>
                                                @php $json .= "}," @endphp
                                                @endif
                                                @if ($cat2->d() && $generations >= 2)
                                                @php $json .= "\"d\": {" @endphp
                                                <tr class="d">

                                                    <td> <input class="ind" id="dd" type="text" data="{{$cat2->d()->id()}}" disabled><br>{{$cat2->d()->l($generations)}}
                                                        @php $json .= "\"name\": \"" . $cat2->d()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat2->d()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dds" type="text" data="{{$cat2->d()->s()->id()}}" disabled><br>{{$cat2->d()->s()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat2->d()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddss" type="text" data="{{$cat2->d()->s()->s()->id()}}" disabled><br>{{$cat2->d()->s()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsss" data="{{$cat2->d()->s()->s()->s()->id()}}" disabled><br>{{$cat2->d()->s()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif

                                                                                                @if ($cat2->d()->s()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddssd" data="{{$cat2->d()->s()->s()->d()->id()}}" disabled><br>{{$cat2->d()->s()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif

                                                                                @if ($cat2->d()->s()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="ddsd" type="text" data="{{$cat2->d()->s()->d()->id()}}" disabled><br>{{$cat2->d()->s()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>

                                                                                                @if ($cat2->d()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsds" data="{{$cat2->d()->s()->d()->s()->id()}}" disabled><br>{{$cat2->d()->s()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat2->d()->s()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsdd" data="{{$cat2->d()->s()->d()->d()->id()}}" disabled><br>{{$cat2->d()->s()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}," @endphp
                                                                @endif
                                                                @if ($cat2->d()->d() && $generations >= 3)
                                                                @php $json .= "\"d\": {" @endphp
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="ddd" type="text" data="{{$cat2->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->l($generations)}}
                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat2->d()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddds" type="text" data="{{$cat2->d()->d()->s()->id()}}" disabled><br>{{$cat2->d()->d()->s()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddss" data="{{$cat2->d()->d()->s()->s()->id()}}" disabled><br>{{$cat2->d()->d()->s()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif

                                                                                                @if ($cat2->d()->d()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddsd" data="{{$cat2->d()->d()->s()->d()->id()}}" disabled><br>{{$cat2->d()->d()->s()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->s()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}," @endphp
                                                                                @endif
                                                                                @if ($cat2->d()->d()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="dddd" type="text" data="{{$cat2->d()->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->d()->l($generations)}}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddds" data="{{$cat2->d()->d()->d()->s()->id()}}" disabled><br>{{$cat2->d()->d()->d()->s()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif

                                                                                                @if ($cat2->d()->d()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddddd" data="{{$cat2->d()->d()->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->d()->d()->l($generations)}}

                                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->d()->d()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}" @endphp
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </td>

                                                                                </tr>
                                                                                @php $json .= "}" @endphp
                                                                                @endif
                                                                            </tbody>

                                                                        </table>



                                                                    </td>

                                                                </tr>
                                                                @php $json .= "}" @endphp
                                                                @endif

                                                            </tbody>

                                                        </table>



                                                    </td>

                                                </tr>
                                                @php $json .= "}" @endphp
                                                @endif

                                            </tbody>

                                        </table>



                                    </td>

                                </tr>
                                @php $json .= "}" @endphp
                                @endif
                            </tbody>

                        </table>



                    </td>

                </tr>
                @php $json .= "}" @endphp
            </tbody>

        </table>
        <textarea id="textarea" style="display: none;">@php echo($json) @endphp</textarea>
    </div>
</div>
<hr>

@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection