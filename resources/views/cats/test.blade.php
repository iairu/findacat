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
    #set {
        display: flex;
        flex-flow: row;
        gap: 10px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        justify-content: center;
        padding: 25px;
    }

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
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section ('ext_js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/inbreeding.js') }}"></script>
@endsection

@section ('script')
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
    }
    function setSameBreed() {
        var maleSelect = document.querySelector('[name="set_sire_id"]')
        var femaleSelect = document.querySelector('[name="set_dam_id"]')
        var maleBreed = maleSelect.options[maleSelect.selectedIndex].text.substr(0,5);
        var femaleBreed = femaleSelect.options[femaleSelect.selectedIndex].text.substr(0,5);
        if (maleBreed.startsWith('(')) {
            var femaleBreedOptions = Array.prototype.slice.call(femaleSelect.options).filter(option => option.text.substr(0,5) == maleBreed || option.text.substr(0,2) == '--')
            femaleSelect.innerHTML = ""
            femaleBreedOptions.forEach(option => femaleSelect.append(option))
        } 
        if (femaleBreed.startsWith('(')) {
            var maleBreedOptions = Array.prototype.slice.call(maleSelect.options).filter(option => option.text.substr(0,5) == femaleBreed || option.text.substr(0,2) == '--')
            maleSelect.innerHTML = ""
            maleBreedOptions.forEach(option => maleSelect.append(option))
        }
    }
    function sameBreedCheckboxBehavior() {
        var checkbox = document.querySelector('input[name="same_breed"]');
        var storedValue = localStorage.getItem('same_breed_checkbox');
        if (JSON.parse(storedValue)) {
            checkbox.checked = true;
        }
        if (checkbox.checked) {
            setSameBreed()
        }
        checkbox.addEventListener("click", function(){
            localStorage.setItem('same_breed_checkbox', JSON.stringify(checkbox.checked));
            // Reset loaded select options to all breeds or apply ticked box (must be done before select2 gets loaded)
            window.location.reload()
        })
    }
    function regnumCheckboxBehavior() {
        var checkbox = document.querySelector('input[name="reg_num"]');
        var storedValue = localStorage.getItem('reg_num_checkbox');
        if (JSON.parse(storedValue)) {
            checkbox.checked = true;
        }
        if (checkbox.checked) {
            Array.prototype.slice.call(document.querySelectorAll('.reg_num')).forEach(div => div.setAttribute("style", "display:block;"))
        } else {
            Array.prototype.slice.call(document.querySelectorAll('.reg_num')).forEach(div => div.setAttribute("style", "display:none;"))
        }
        checkbox.addEventListener("click", function(){
            var checkbox = document.querySelector('input[name="reg_num"]');
            localStorage.setItem('reg_num_checkbox', JSON.stringify(checkbox.checked));
            if (checkbox.checked) {
                Array.prototype.slice.call(document.querySelectorAll('.reg_num')).forEach(div => div.setAttribute("style", "display:block;"))
            } else {
                Array.prototype.slice.call(document.querySelectorAll('.reg_num')).forEach(div => div.setAttribute("style", "display:none;"))
            }
        })
    }
    function loadScripts() {
        regnumCheckboxBehavior()
        sameBreedCheckboxBehavior()
        // Interactive searchable select (default select options no longer work from now on until reload)
        $('[name="set_sire_id"]').select2();
        $('[name="set_dam_id"]').select2();
        setInterval(function(){
            if (document.querySelector('#set_sire_button').value !== "Update") {
                document.querySelector('#set_sire_button').value = "Update";
                document.querySelector('#set_dam_button').value = "Update";
            }
        }, 500)
    }
    buttonBehavior();
    loadScripts();
</script>
@endsection

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

<div id="controls">
    <strong>Inbreeding:</strong>
        <span id="result"><i>F</i> = 0.0%</span><br>
        <input type="checkbox" name="same_breed"><label for="same_breed">{{ __('cat.same_breed') }}</label><br>
        <input type="checkbox" name="reg_num"><label for="reg_num">{{ __('cat.display_reg_num') }}</label>
</div>
<div id="set">
    <div class="sire">
        {{ Form::open(['route' => ['cats.test', $cat->id, $cat2->id]]) }}
        {!! FormField::select('set_sire_id', $malePersonList, ['label' => false, 'value' => $cat->id, 'placeholder' => __('app.select_from_existing_males')]) !!}
        <div class="input-group">
            <span class="input-group-btn">
                {{ Form::submit(__('app.update'), ['class' => 'btn btn-info btn-sm', 'id' => 'set_sire_button']) }}
            </span>
        </div>
        {{ Form::close() }}
    </div>
    <div class="dam">
        {{ Form::open(['route' => ['cats.test', $cat->id, $cat2->id]]) }}
        {!! FormField::select('set_dam_id', $femalePersonList, ['label' => false, 'value' => $cat2->id, 'placeholder' => __('app.select_from_existing_females')]) !!}
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

                    <td><br><input class="ind" id="offspring" type="text" data="0" disabled><br><br>
                        @php $json .= "\"name\": \"" . "0" . ($generations >= 1 ? "\"," : "\"") @endphp

                    </td>

                    <td class="anc">

                        <table data-level="1">

                            <tbody>

                                @if ($cat && $generations >= 1)
                                @php $json .= "\"s\": {" @endphp
                                <tr class="s">
                                    <td> Sire:<br><input class="ind" id="s" type="text" data="{{$cat->id()}}" disabled><br>{{$cat->l($generations)}}<br>{{ $cat->breed }} {{ $cat->ems_color }} {{ $cat->dob() }}
                                        <div class="reg_num">
    @if ($cat->id != "1")
    {{ $cat->original_reg_num }}<br> 
        {{ $cat->last_reg_num }}<br> {{ $cat->reg_num_2 }}<br> {{ $cat->reg_num_3 }}
    @endif
    </div><br>
                                        @php $json .= "\"name\": \"" . $cat->id() . ($generations >= 2 ? "\"," : "\"") @endphp
                                        
                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat->s() && $generations >= 2)
                                                @php $json .= "\"s\": {" @endphp
                                                <tr class="s">

                                                    <td> <input class="ind" id="ss" type="text" data="{{$cat->s()->id()}}" disabled><br>{{$cat->s()->l($generations)}}<br>{{ $cat->s()->breed }} {{ $cat->s()->ems_color }} {{ $cat->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->id != "1")
    {{ $cat->s()->original_reg_num }}<br> 
        {{ $cat->s()->last_reg_num }}<br> {{ $cat->s()->reg_num_2 }}<br> {{ $cat->s()->reg_num_3 }}
    @endif
    </div>
                                                        @php $json .= "\"name\": \"" . $cat->s()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat->s()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sss" type="text" data="{{$cat->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->l($generations)}}<br>{{ $cat->s()->s()->breed }} {{ $cat->s()->s()->ems_color }} {{ $cat->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->id != "1")
    {{ $cat->s()->s()->original_reg_num }}<br> 
        {{ $cat->s()->s()->last_reg_num }}<br> {{ $cat->s()->s()->reg_num_2 }}<br> {{ $cat->s()->s()->reg_num_3 }}
    @endif
    </div>
                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->s()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssss" type="text" data="{{$cat->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->l($generations)}}<br>{{ $cat->s()->s()->s()->breed }} {{ $cat->s()->s()->s()->ems_color }} {{ $cat->s()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->s()->id != "1")
    {{ $cat->s()->s()->s()->original_reg_num }}<br> 
        {{ $cat->s()->s()->s()->last_reg_num }}<br> {{ $cat->s()->s()->s()->reg_num_2 }}<br> {{ $cat->s()->s()->s()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssss" data="{{$cat->s()->s()->s()->s()->id()}}" disabled><br>{{$cat->s()->s()->s()->s()->l($generations)}}<br>{{ $cat->s()->s()->s()->s()->breed }} {{ $cat->s()->s()->s()->s()->ems_color }} {{ $cat->s()->s()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->s()->s()->id != "1")
    {{ $cat->s()->s()->s()->s()->original_reg_num }}<br> 
        {{ $cat->s()->s()->s()->s()->last_reg_num }}<br> {{ $cat->s()->s()->s()->s()->reg_num_2 }}<br> {{ $cat->s()->s()->s()->s()->reg_num_3 }}
    @endif
    </div>

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
                                                                                                        <input type="text" class="ind" id="ssssd" data="{{$cat->s()->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->s()->d()->l($generations)}}<br>{{ $cat->s()->s()->s()->d()->breed }} {{ $cat->s()->s()->s()->d()->ems_color }} {{ $cat->s()->s()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->s()->d()->id != "1")
    {{ $cat->s()->s()->s()->d()->original_reg_num }}<br> 
        {{ $cat->s()->s()->s()->d()->last_reg_num }}<br> {{ $cat->s()->s()->s()->d()->reg_num_2 }}<br> {{ $cat->s()->s()->s()->d()->reg_num_3 }}
    @endif
    </div>

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

                                                                                        <input class="ind" id="sssd" type="text" data="{{$cat->s()->s()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->l($generations)}}<br>{{ $cat->s()->s()->d()->breed }} {{ $cat->s()->s()->d()->ems_color }} {{ $cat->s()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->d()->id != "1")
    {{ $cat->s()->s()->d()->original_reg_num }}<br> 
        {{ $cat->s()->s()->d()->last_reg_num }}<br> {{ $cat->s()->s()->d()->reg_num_2 }}<br> {{ $cat->s()->s()->d()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sssds" data="{{$cat->s()->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->s()->d()->s()->l($generations)}}<br>{{ $cat->s()->s()->d()->s()->breed }} {{ $cat->s()->s()->d()->s()->ems_color }} {{ $cat->s()->s()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->d()->s()->id != "1")
    {{ $cat->s()->s()->d()->s()->original_reg_num }}<br> 
        {{ $cat->s()->s()->d()->s()->last_reg_num }}<br> {{ $cat->s()->s()->d()->s()->reg_num_2 }}<br> {{ $cat->s()->s()->d()->s()->reg_num_3 }}
    @endif
    </div>

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
                                                                                                        <input type="text" class="ind" id="sssdd" data="{{$cat->s()->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->s()->d()->d()->l($generations)}}<br>{{ $cat->s()->s()->d()->d()->breed }} {{ $cat->s()->s()->d()->d()->ems_color }} {{ $cat->s()->s()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->s()->d()->d()->id != "1")
    {{ $cat->s()->s()->d()->d()->original_reg_num }}<br> 
        {{ $cat->s()->s()->d()->d()->last_reg_num }}<br> {{ $cat->s()->s()->d()->d()->reg_num_2 }}<br> {{ $cat->s()->s()->d()->d()->reg_num_3 }}
    @endif
    </div>

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

                                                                    <td> <input class="ind" id="ssd" type="text" data="{{$cat->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->l($generations)}}<br>{{ $cat->s()->d()->breed }} {{ $cat->s()->d()->ems_color }} {{ $cat->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->id != "1")
    {{ $cat->s()->d()->original_reg_num }}<br> 
        {{ $cat->s()->d()->last_reg_num }}<br> {{ $cat->s()->d()->reg_num_2 }}<br> {{ $cat->s()->d()->reg_num_3 }}
    @endif
    </div>
                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->s()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ssds" type="text" data="{{$cat->s()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->l($generations)}}<br>{{ $cat->s()->d()->s()->breed }} {{ $cat->s()->d()->s()->ems_color }} {{ $cat->s()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->s()->id != "1")
    {{ $cat->s()->d()->s()->original_reg_num }}<br> 
        {{ $cat->s()->d()->s()->last_reg_num }}<br> {{ $cat->s()->d()->s()->reg_num_2 }}<br> {{ $cat->s()->d()->s()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdss" data="{{$cat->s()->d()->s()->s()->id()}}" disabled><br>{{$cat->s()->d()->s()->s()->l($generations)}}<br>{{ $cat->s()->d()->s()->s()->breed }} {{ $cat->s()->d()->s()->s()->ems_color }} {{ $cat->s()->d()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->s()->s()->id != "1")
    {{ $cat->s()->d()->s()->s()->original_reg_num }}<br> 
        {{ $cat->s()->d()->s()->s()->last_reg_num }}<br> {{ $cat->s()->d()->s()->s()->reg_num_2 }}<br> {{ $cat->s()->d()->s()->s()->reg_num_3 }}
    @endif
    </div>

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
                                                                                                        <input type="text" class="ind" id="ssdsd" data="{{$cat->s()->d()->s()->d()->id()}}" disabled><br>{{$cat->s()->d()->s()->d()->l($generations)}}<br>{{ $cat->s()->d()->s()->d()->breed }} {{ $cat->s()->d()->s()->d()->ems_color }} {{ $cat->s()->d()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->s()->d()->id != "1")
    {{ $cat->s()->d()->s()->d()->original_reg_num }}<br> 
        {{ $cat->s()->d()->s()->d()->last_reg_num }}<br> {{ $cat->s()->d()->s()->d()->reg_num_2 }}<br> {{ $cat->s()->d()->s()->d()->reg_num_3 }}
    @endif
    </div>

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

                                                                                        <input class="ind" id="ssdd" type="text" data="{{$cat->s()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->l($generations)}}<br>{{ $cat->s()->d()->d()->breed }} {{ $cat->s()->d()->d()->ems_color }} {{ $cat->s()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->d()->id != "1")
    {{ $cat->s()->d()->d()->original_reg_num }}<br> 
        {{ $cat->s()->d()->d()->last_reg_num }}<br> {{ $cat->s()->d()->d()->reg_num_2 }}<br> {{ $cat->s()->d()->d()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->s()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->s()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ssdds" data="{{$cat->s()->d()->d()->s()->id()}}" disabled><br>{{$cat->s()->d()->d()->s()->l($generations)}}<br>{{ $cat->s()->d()->d()->s()->breed }} {{ $cat->s()->d()->d()->s()->ems_color }} {{ $cat->s()->d()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->d()->s()->id != "1")
    {{ $cat->s()->d()->d()->s()->original_reg_num }}<br> 
        {{ $cat->s()->d()->d()->s()->last_reg_num }}<br> {{ $cat->s()->d()->d()->s()->reg_num_2 }}<br> {{ $cat->s()->d()->d()->s()->reg_num_3 }}
    @endif
    </div>

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
                                                                                                        <input type="text" class="ind" id="ssddd" data="{{$cat->s()->d()->d()->d()->id()}}" disabled><br>{{$cat->s()->d()->d()->d()->l($generations)}}<br>{{ $cat->s()->d()->d()->d()->breed }} {{ $cat->s()->d()->d()->d()->ems_color }} {{ $cat->s()->d()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->s()->d()->d()->d()->id != "1")
    {{ $cat->s()->d()->d()->d()->original_reg_num }}<br> 
        {{ $cat->s()->d()->d()->d()->last_reg_num }}<br> {{ $cat->s()->d()->d()->d()->reg_num_2 }}<br> {{ $cat->s()->d()->d()->d()->reg_num_3 }}
    @endif
    </div>

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
                                                @if ($cat->d() && $generations >= 2)
                                                @php $json .= "\"d\": {" @endphp
                                                <tr class="d">

                                                    <td> <input class="ind" id="sd" type="text" data="{{$cat->d()->id()}}" disabled><br>{{$cat->d()->l($generations)}}<br>{{ $cat->d()->breed }} {{ $cat->d()->ems_color }} {{ $cat->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->id != "1")
    {{ $cat->d()->original_reg_num }}<br> 
        {{ $cat->d()->last_reg_num }}<br> {{ $cat->d()->reg_num_2 }}<br> {{ $cat->d()->reg_num_3 }}
    @endif
    </div>
                                                        @php $json .= "\"name\": \"" . $cat->d()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat->d()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="sds" type="text" data="{{$cat->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->l($generations)}}<br>{{ $cat->d()->s()->breed }} {{ $cat->d()->s()->ems_color }} {{ $cat->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->id != "1")
    {{ $cat->d()->s()->original_reg_num }}<br> 
        {{ $cat->d()->s()->last_reg_num }}<br> {{ $cat->d()->s()->reg_num_2 }}<br> {{ $cat->d()->s()->reg_num_3 }}
    @endif
    </div>
                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat->d()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdss" type="text" data="{{$cat->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->l($generations)}}<br>{{ $cat->d()->s()->s()->breed }} {{ $cat->d()->s()->s()->ems_color }} {{ $cat->d()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->s()->id != "1")
    {{ $cat->d()->s()->s()->original_reg_num }}<br> 
        {{ $cat->d()->s()->s()->last_reg_num }}<br> {{ $cat->d()->s()->s()->reg_num_2 }}<br> {{ $cat->d()->s()->s()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsss" data="{{$cat->d()->s()->s()->s()->id()}}" disabled><br>{{$cat->d()->s()->s()->s()->l($generations)}}<br>{{ $cat->d()->s()->s()->s()->breed }} {{ $cat->d()->s()->s()->s()->ems_color }} {{ $cat->d()->s()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->s()->s()->id != "1")
    {{ $cat->d()->s()->s()->s()->original_reg_num }}<br> 
        {{ $cat->d()->s()->s()->s()->last_reg_num }}<br> {{ $cat->d()->s()->s()->s()->reg_num_2 }}<br> {{ $cat->d()->s()->s()->s()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdssd" data="{{$cat->d()->s()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->s()->d()->l($generations)}}<br>{{ $cat->d()->s()->s()->d()->breed }} {{ $cat->d()->s()->s()->d()->ems_color }} {{ $cat->d()->s()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->s()->d()->id != "1")
    {{ $cat->d()->s()->s()->d()->original_reg_num }}<br> 
        {{ $cat->d()->s()->s()->d()->last_reg_num }}<br> {{ $cat->d()->s()->s()->d()->reg_num_2 }}<br> {{ $cat->d()->s()->s()->d()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->s()->d()->id() . "\"" @endphp

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

                                                                                @if ($cat->d()->s()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sdsd" type="text" data="{{$cat->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->l($generations)}}<br>{{ $cat->d()->s()->d()->breed }} {{ $cat->d()->s()->d()->ems_color }} {{ $cat->d()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->d()->id != "1")
    {{ $cat->d()->s()->d()->original_reg_num }}<br> 
        {{ $cat->d()->s()->d()->last_reg_num }}<br> {{ $cat->d()->s()->d()->reg_num_2 }}<br> {{ $cat->d()->s()->d()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsds" data="{{$cat->d()->s()->d()->s()->id()}}" disabled><br>{{$cat->d()->s()->d()->s()->l($generations)}}<br>{{ $cat->d()->s()->d()->s()->breed }} {{ $cat->d()->s()->d()->s()->ems_color }} {{ $cat->d()->s()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->d()->s()->id != "1")
    {{ $cat->d()->s()->d()->s()->original_reg_num }}<br> 
        {{ $cat->d()->s()->d()->s()->last_reg_num }}<br> {{ $cat->d()->s()->d()->s()->reg_num_2 }}<br> {{ $cat->d()->s()->d()->s()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->d()->s()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdsdd" data="{{$cat->d()->s()->d()->d()->id()}}" disabled><br>{{$cat->d()->s()->d()->d()->l($generations)}}<br>{{ $cat->d()->s()->d()->d()->breed }} {{ $cat->d()->s()->d()->d()->ems_color }} {{ $cat->d()->s()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->s()->d()->d()->id != "1")
    {{ $cat->d()->s()->d()->d()->original_reg_num }}<br> 
        {{ $cat->d()->s()->d()->d()->last_reg_num }}<br> {{ $cat->d()->s()->d()->d()->reg_num_2 }}<br> {{ $cat->d()->s()->d()->d()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->s()->d()->d()->id() . "\"" @endphp

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
                                                                @if ($cat->d()->d() && $generations >= 3)
                                                                @php $json .= "\"d\": {" @endphp
                                                                <tr class="d">

                                                                    <td> <input class="ind" id="sdd" type="text" data="{{$cat->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->l($generations)}}<br>{{ $cat->d()->d()->breed }} {{ $cat->d()->d()->ems_color }} {{ $cat->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->id != "1")
    {{ $cat->d()->d()->original_reg_num }}<br> 
        {{ $cat->d()->d()->last_reg_num }}<br> {{ $cat->d()->d()->reg_num_2 }}<br> {{ $cat->d()->d()->reg_num_3 }}
    @endif
    </div>
                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat->d()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="sdds" type="text" data="{{$cat->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->l($generations)}}<br>{{ $cat->d()->d()->s()->breed }} {{ $cat->d()->d()->s()->ems_color }} {{ $cat->d()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->s()->id != "1")
    {{ $cat->d()->d()->s()->original_reg_num }}<br> 
        {{ $cat->d()->d()->s()->last_reg_num }}<br> {{ $cat->d()->d()->s()->reg_num_2 }}<br> {{ $cat->d()->d()->s()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddss" data="{{$cat->d()->d()->s()->s()->id()}}" disabled><br>{{$cat->d()->d()->s()->s()->l($generations)}}<br>{{ $cat->d()->d()->s()->s()->breed }} {{ $cat->d()->d()->s()->s()->ems_color }} {{ $cat->d()->d()->s()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->s()->s()->id != "1")
    {{ $cat->d()->d()->s()->s()->original_reg_num }}<br> 
        {{ $cat->d()->d()->s()->s()->last_reg_num }}<br> {{ $cat->d()->d()->s()->s()->reg_num_2 }}<br> {{ $cat->d()->d()->s()->s()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->s()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->d()->d()->s()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddsd" data="{{$cat->d()->d()->s()->d()->id()}}" disabled><br>{{$cat->d()->d()->s()->d()->l($generations)}}<br>{{ $cat->d()->d()->s()->d()->breed }} {{ $cat->d()->d()->s()->d()->ems_color }} {{ $cat->d()->d()->s()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->s()->d()->id != "1")
    {{ $cat->d()->d()->s()->d()->original_reg_num }}<br> 
        {{ $cat->d()->d()->s()->d()->last_reg_num }}<br> {{ $cat->d()->d()->s()->d()->reg_num_2 }}<br> {{ $cat->d()->d()->s()->d()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->s()->d()->id() . "\"" @endphp

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
                                                                                @if ($cat->d()->d()->d() && $generations >= 4)
                                                                                @php $json .= "\"d\": {" @endphp
                                                                                <tr class="d">

                                                                                    <td>

                                                                                        <input class="ind" id="sddd" type="text" data="{{$cat->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->l($generations)}}<br>{{ $cat->d()->d()->d()->breed }} {{ $cat->d()->d()->d()->ems_color }} {{ $cat->d()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->d()->id != "1")
    {{ $cat->d()->d()->d()->original_reg_num }}<br> 
        {{ $cat->d()->d()->d()->last_reg_num }}<br> {{ $cat->d()->d()->d()->reg_num_2 }}<br> {{ $cat->d()->d()->d()->reg_num_3 }}
    @endif
    </div>


                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat->d()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sddds" data="{{$cat->d()->d()->d()->s()->id()}}" disabled><br>{{$cat->d()->d()->d()->s()->l($generations)}}<br>{{ $cat->d()->d()->d()->s()->breed }} {{ $cat->d()->d()->d()->s()->ems_color }} {{ $cat->d()->d()->d()->s()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->d()->s()->id != "1")
    {{ $cat->d()->d()->d()->s()->original_reg_num }}<br> 
        {{ $cat->d()->d()->d()->s()->last_reg_num }}<br> {{ $cat->d()->d()->d()->s()->reg_num_2 }}<br> {{ $cat->d()->d()->d()->s()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->d()->s()->id() . "\"" @endphp

                                                                                                    </td>
                                                                                                    <td class="anc">

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @php $json .= "}," @endphp
                                                                                                @endif
                                                                                                @if ($cat->d()->d()->d()->d() && $generations >= 5)
                                                                                                @php $json .= "\"d\": {" @endphp
                                                                                                <tr class="d">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="sdddd" data="{{$cat->d()->d()->d()->d()->id()}}" disabled><br>{{$cat->d()->d()->d()->d()->l($generations)}}<br>{{ $cat->d()->d()->d()->d()->breed }} {{ $cat->d()->d()->d()->d()->ems_color }} {{ $cat->d()->d()->d()->d()->dob() }}
                                        <div class="reg_num">
    @if ($cat->d()->d()->d()->d()->id != "1")
    {{ $cat->d()->d()->d()->d()->original_reg_num }}<br> 
        {{ $cat->d()->d()->d()->d()->last_reg_num }}<br> {{ $cat->d()->d()->d()->d()->reg_num_2 }}<br> {{ $cat->d()->d()->d()->d()->reg_num_3 }}
    @endif
    </div>

                                                                                                        @php $json .= "\"name\": \"" . $cat->d()->d()->d()->d()->id() . "\"" @endphp

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

                                        <input class="ind" id="d" type="text" data="{{$cat2->id()}}" disabled><br>{{$cat2->l($generations)}}<br>{{ $cat2->breed }} {{ $cat2->ems_color }} {{ $cat2->dob() }}<br>
                                        @php $json .= "\"name\": \"" . $cat2->id() . ($generations >= 2 ? "\"," : "\"") @endphp



                                    </td>

                                    <td class="anc">

                                        <table data-level="2">

                                            <tbody>
                                                @if ($cat2->s() && $generations >= 2)
                                                @php $json .= "\"s\": {" @endphp
                                                <tr class="s">

                                                    <td> <input class="ind" id="ds" type="text" data="{{$cat2->s()->id()}}" disabled><br>{{$cat2->s()->l($generations)}}<br>{{ $cat2->s()->breed }} {{ $cat2->s()->ems_color }} {{ $cat2->s()->dob() }}
                                                        @php $json .= "\"name\": \"" . $cat2->s()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>
                                                                @if ($cat2->s()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dss" type="text" data="{{$cat2->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->l($generations)}}<br>{{ $cat2->s()->s()->breed }} {{ $cat2->s()->s()->ems_color }} {{ $cat2->s()->s()->dob() }}
                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat2->s()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsss" type="text" data="{{$cat2->s()->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->s()->l($generations)}}<br>{{ $cat2->s()->s()->s()->breed }} {{ $cat2->s()->s()->s()->ems_color }} {{ $cat2->s()->s()->s()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssss" data="{{$cat2->s()->s()->s()->s()->id()}}" disabled><br>{{$cat2->s()->s()->s()->s()->l($generations)}}<br>{{ $cat2->s()->s()->s()->s()->breed }} {{ $cat2->s()->s()->s()->s()->ems_color }} {{ $cat2->s()->s()->s()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="dsssd" data="{{$cat2->s()->s()->s()->d()->id()}}" disabled><br>{{$cat2->s()->s()->s()->d()->l($generations)}}<br>{{ $cat2->s()->s()->s()->d()->breed }} {{ $cat2->s()->s()->s()->d()->ems_color }} {{ $cat2->s()->s()->s()->d()->dob() }}

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

                                                                                        <input class="ind" id="dssd" type="text" data="{{$cat2->s()->s()->d()->id()}}" disabled><br>{{$cat2->s()->s()->d()->l($generations)}}<br>{{ $cat2->s()->s()->d()->breed }} {{ $cat2->s()->s()->d()->ems_color }} {{ $cat2->s()->s()->d()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dssds" data="{{$cat2->s()->s()->d()->s()->id()}}" disabled><br>{{$cat2->s()->s()->d()->s()->l($generations)}}<br>{{ $cat2->s()->s()->d()->s()->breed }} {{ $cat2->s()->s()->d()->s()->ems_color }} {{ $cat2->s()->s()->d()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="dssdd" data="{{$cat2->s()->s()->d()->d()->id()}}" disabled><br>{{$cat2->s()->s()->d()->d()->l($generations)}}<br>{{ $cat2->s()->s()->d()->d()->breed }} {{ $cat2->s()->s()->d()->d()->ems_color }} {{ $cat2->s()->s()->d()->d()->dob() }}

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

                                                                    <td> <input class="ind" id="dsd" type="text" data="{{$cat2->s()->d()->id()}}" disabled><br>{{$cat2->s()->d()->l($generations)}}<br>{{ $cat2->s()->d()->breed }} {{ $cat2->s()->d()->ems_color }} {{ $cat2->s()->d()->dob() }}
                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat2->s()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="dsds" type="text" data="{{$cat2->s()->d()->s()->id()}}" disabled><br>{{$cat2->s()->d()->s()->l($generations)}}<br>{{ $cat2->s()->d()->s()->breed }} {{ $cat2->s()->d()->s()->ems_color }} {{ $cat2->s()->d()->s()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdss" data="{{$cat2->s()->d()->s()->s()->id()}}" disabled><br>{{$cat2->s()->d()->s()->s()->l($generations)}}<br>{{ $cat2->s()->d()->s()->s()->breed }} {{ $cat2->s()->d()->s()->s()->ems_color }} {{ $cat2->s()->d()->s()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="dsdsd" data="{{$cat2->s()->d()->s()->d()->id()}}" disabled><br>{{$cat2->s()->d()->s()->d()->l($generations)}}<br>{{ $cat2->s()->d()->s()->d()->breed }} {{ $cat2->s()->d()->s()->d()->ems_color }} {{ $cat2->s()->d()->s()->d()->dob() }}

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

                                                                                        <input class="ind" id="dsdd" type="text" data="{{$cat2->s()->d()->d()->id()}}" disabled><br>{{$cat2->s()->d()->d()->l($generations)}}<br>{{ $cat2->s()->d()->d()->breed }} {{ $cat2->s()->d()->d()->ems_color }} {{ $cat2->s()->d()->d()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->s()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->s()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dsdds" data="{{$cat2->s()->d()->d()->s()->id()}}" disabled><br>{{$cat2->s()->d()->d()->s()->l($generations)}}<br>{{ $cat2->s()->d()->d()->s()->breed }} {{ $cat2->s()->d()->d()->s()->ems_color }} {{ $cat2->s()->d()->d()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="dsddd" data="{{$cat2->s()->d()->d()->d()->id()}}" disabled><br>{{$cat2->s()->d()->d()->d()->l($generations)}}<br>{{ $cat2->s()->d()->d()->d()->breed }} {{ $cat2->s()->d()->d()->d()->ems_color }} {{ $cat2->s()->d()->d()->d()->dob() }}

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

                                                    <td> <input class="ind" id="dd" type="text" data="{{$cat2->d()->id()}}" disabled><br>{{$cat2->d()->l($generations)}}<br>{{ $cat2->d()->breed }} {{ $cat2->d()->ems_color }} {{ $cat2->d()->dob() }}
                                                        @php $json .= "\"name\": \"" . $cat2->d()->id() . ($generations >= 3 ? "\"," : "\"") @endphp

                                                    </td>

                                                    <td class="anc">

                                                        <table data-level="3">

                                                            <tbody>

                                                                @if ($cat2->d()->s() && $generations >= 3)
                                                                @php $json .= "\"s\": {" @endphp
                                                                <tr class="s">

                                                                    <td> <input class="ind" id="dds" type="text" data="{{$cat2->d()->s()->id()}}" disabled><br>{{$cat2->d()->s()->l($generations)}}<br>{{ $cat2->d()->s()->breed }} {{ $cat2->d()->s()->ems_color }} {{ $cat2->d()->s()->dob() }}
                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>

                                                                                @if ($cat2->d()->s()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddss" type="text" data="{{$cat2->d()->s()->s()->id()}}" disabled><br>{{$cat2->d()->s()->s()->l($generations)}}<br>{{ $cat2->d()->s()->s()->breed }} {{ $cat2->d()->s()->s()->ems_color }} {{ $cat2->d()->s()->s()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->s()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsss" data="{{$cat2->d()->s()->s()->s()->id()}}" disabled><br>{{$cat2->d()->s()->s()->s()->l($generations)}}<br>{{ $cat2->d()->s()->s()->s()->breed }} {{ $cat2->d()->s()->s()->s()->ems_color }} {{ $cat2->d()->s()->s()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="ddssd" data="{{$cat2->d()->s()->s()->d()->id()}}" disabled><br>{{$cat2->d()->s()->s()->d()->l($generations)}}<br>{{ $cat2->d()->s()->s()->d()->breed }} {{ $cat2->d()->s()->s()->d()->ems_color }} {{ $cat2->d()->s()->s()->d()->dob() }}

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

                                                                                        <input class="ind" id="ddsd" type="text" data="{{$cat2->d()->s()->d()->id()}}" disabled><br>{{$cat2->d()->s()->d()->l($generations)}}<br>{{ $cat2->d()->s()->d()->breed }} {{ $cat2->d()->s()->d()->ems_color }} {{ $cat2->d()->s()->d()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->s()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>

                                                                                                @if ($cat2->d()->s()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="ddsds" data="{{$cat2->d()->s()->d()->s()->id()}}" disabled><br>{{$cat2->d()->s()->d()->s()->l($generations)}}<br>{{ $cat2->d()->s()->d()->s()->breed }} {{ $cat2->d()->s()->d()->s()->ems_color }} {{ $cat2->d()->s()->d()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="ddsdd" data="{{$cat2->d()->s()->d()->d()->id()}}" disabled><br>{{$cat2->d()->s()->d()->d()->l($generations)}}<br>{{ $cat2->d()->s()->d()->d()->breed }} {{ $cat2->d()->s()->d()->d()->ems_color }} {{ $cat2->d()->s()->d()->d()->dob() }}

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

                                                                    <td> <input class="ind" id="ddd" type="text" data="{{$cat2->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->l($generations)}}<br>{{ $cat2->d()->d()->breed }} {{ $cat2->d()->d()->ems_color }} {{ $cat2->d()->d()->dob() }}
                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->id() . ($generations >= 4 ? "\"," : "\"") @endphp

                                                                    </td>

                                                                    <td class="anc">

                                                                        <table data-level="4">

                                                                            <tbody>
                                                                                @if ($cat2->d()->d()->s() && $generations >= 4)
                                                                                @php $json .= "\"s\": {" @endphp
                                                                                <tr class="s">

                                                                                    <td>

                                                                                        <input class="ind" id="ddds" type="text" data="{{$cat2->d()->d()->s()->id()}}" disabled><br>{{$cat2->d()->d()->s()->l($generations)}}<br>{{ $cat2->d()->d()->s()->breed }} {{ $cat2->d()->d()->s()->ems_color }} {{ $cat2->d()->d()->s()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->s()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->d()->s()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddss" data="{{$cat2->d()->d()->s()->s()->id()}}" disabled><br>{{$cat2->d()->d()->s()->s()->l($generations)}}<br>{{ $cat2->d()->d()->s()->s()->breed }} {{ $cat2->d()->d()->s()->s()->ems_color }} {{ $cat2->d()->d()->s()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="dddsd" data="{{$cat2->d()->d()->s()->d()->id()}}" disabled><br>{{$cat2->d()->d()->s()->d()->l($generations)}}<br>{{ $cat2->d()->d()->s()->d()->breed }} {{ $cat2->d()->d()->s()->d()->ems_color }} {{ $cat2->d()->d()->s()->d()->dob() }}

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

                                                                                        <input class="ind" id="dddd" type="text" data="{{$cat2->d()->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->d()->l($generations)}}<br>{{ $cat2->d()->d()->d()->breed }} {{ $cat2->d()->d()->d()->ems_color }} {{ $cat2->d()->d()->d()->dob() }}


                                                                                        @php $json .= "\"name\": \"" . $cat2->d()->d()->d()->id() . ($generations >= 5 ? "\"," : "\"") @endphp

                                                                                    </td>

                                                                                    <td class="anc">
                                                                                        <table data-level="5">
                                                                                            <tbody>
                                                                                                @if ($cat2->d()->d()->d()->s() && $generations >= 5)
                                                                                                @php $json .= "\"s\": {" @endphp
                                                                                                <tr class="s">
                                                                                                    <td>
                                                                                                        <input type="text" class="ind" id="dddds" data="{{$cat2->d()->d()->d()->s()->id()}}" disabled><br>{{$cat2->d()->d()->d()->s()->l($generations)}}<br>{{ $cat2->d()->d()->d()->s()->breed }} {{ $cat2->d()->d()->d()->s()->ems_color }} {{ $cat2->d()->d()->d()->s()->dob() }}

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
                                                                                                        <input type="text" class="ind" id="ddddd" data="{{$cat2->d()->d()->d()->d()->id()}}" disabled><br>{{$cat2->d()->d()->d()->d()->l($generations)}}<br>{{ $cat2->d()->d()->d()->d()->breed }} {{ $cat2->d()->d()->d()->d()->ems_color }} {{ $cat2->d()->d()->d()->d()->dob() }}

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