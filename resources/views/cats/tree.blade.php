@extends('layouts.cat-profile-wide')

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

@section('ext_css')
<style>
.family-tree {
    height: calc(25px*32);
}
.family-tree > div {
  border: 1px solid;
  width: calc(100%/5);
  position: absolute;
}
/* @if ($generations == 4)
.five {
    display: none;
}
.four {
    height: 25px !important;
}
.three {
    height: 50px !important;
}
.two {
    height: 100px !important;
}
.one {
    height: 200px !important;
}
@endif

@if ($generations == "3")
.five, .four {
    display: none;
}
.three {
    height: 25px !important;
}
.two {
    height: 50px !important;
}
.one {
    height: 100px !important;
}
@endif

@if ($generations == 2)
.five, .four, .three {
    display: none;
}
.two {
    height: 25px !important;
}
.one {
    height: 50px !important;
}
@endif

@if ($generations == 1)
.five, .four, .three, .two {
    display: none;
}
.one {
    height: 25px !important;
}
@endif */
</style>
@endsection


<div id="wrapper" class="family-tree">
    {{$generations}}
    <!-- <div id="x" style="left: 0;margin-top: -25px;height: 25px;">{{ $cat->l() }}</div> -->
        @if ($cat->f())
        <div id="f" class="one" style="left: 0;height: 400px;">{{ $cat->f()->l() }}</div>
            @if ($cat->f()->f())
            <div id="ff" class="two" style="left: calc((100%/5)*1);height: 200px;">{{ $cat->f()->f()->l() }}</div>
                @if ($cat->f()->f()->f())
                <div id="fff" class="three" style="left: calc((100%/5)*2);height: 100px;">{{ $cat->f()->f()->f()->l() }}</div>
                    @if ($cat->f()->f()->f()->f())
                    <div id="ffff" class="four" style="left: calc((100%/5)*3);height: 50px;">{{ $cat->f()->f()->f()->f()->l() }}</div>
                        @if ($cat->f()->f()->f()->f()->f())
                        <div id="fffff" class="five" style="left: calc((100%/5)*4);height: 25px;">{{ $cat->f()->f()->f()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->f()->f()->f()->m())
                        <div id="ffffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*1);">{{ $cat->f()->f()->f()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->f()->f()->f()->m())
                    <div id="fffm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*1);">{{ $cat->f()->f()->f()->m()->l() }}</div>
                        @if ($cat->f()->f()->f()->m()->f())
                        <div id="fffmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*2);">{{ $cat->f()->f()->f()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->f()->f()->m()->m())
                        <div id="fffmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*3);">{{ $cat->f()->f()->f()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->f()->f()->m())
                <div id="ffm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*1);">{{ $cat->f()->f()->m()->l() }}</div>
                    @if ($cat->f()->f()->m()->f())
                    <div id="ffmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*2);">{{ $cat->f()->f()->m()->f()->l() }}</div>
                        @if ($cat->f()->f()->m()->f()->f())
                        <div id="ffmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*4);">{{ $cat->f()->f()->m()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->f()->m()->f()->m())
                        <div id="ffmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*5);">{{ $cat->f()->f()->m()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->f()->f()->m()->m())
                    <div id="ffmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*3);">{{ $cat->f()->f()->m()->m()->l() }}</div>
                        @if ($cat->f()->f()->m()->m()->f())
                        <div id="ffmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*6);">{{ $cat->f()->f()->m()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->f()->m()->m()->m())
                        <div id="ffmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*7);">{{ $cat->f()->f()->m()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
            @if ($cat->f()->m())
            <div id="fm" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*1);">{{ $cat->f()->m()->l() }}</div>
                @if ($cat->f()->m()->f())
                <div id="fmf" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*2);">{{ $cat->f()->m()->f()->l() }}</div>
                    @if ($cat->f()->m()->f()->f())
                    <div id="fmff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*4);">{{ $cat->f()->m()->f()->f()->l() }}</div>
                        @if ($cat->f()->m()->f()->f()->f())
                        <div id="fmfff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*8);">{{ $cat->f()->m()->f()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->m()->f()->f()->m())
                        <div id="fmffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*9);">{{ $cat->f()->m()->f()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->f()->m()->f()->m())
                    <div id="fmfm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*5);">{{ $cat->f()->m()->f()->m()->l() }}</div>
                        @if ($cat->f()->m()->f()->m()->f())
                        <div id="fmfmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*10);">{{ $cat->f()->m()->f()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->m()->f()->m()->m())
                        <div id="fmfmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*11);">{{ $cat->f()->m()->f()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->f()->m()->m())
                <div id="fmm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*3);">{{ $cat->f()->m()->m()->l() }}</div>
                    @if ($cat->f()->m()->m()->f())
                    <div id="fmmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*6);">{{ $cat->f()->m()->m()->f()->l() }}</div>
                        @if ($cat->f()->m()->m()->f()->f())
                        <div id="fmmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*12);">{{ $cat->f()->m()->m()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->m()->m()->f()->m())
                        <div id="fmmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*13);">{{ $cat->f()->m()->m()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->f()->m()->m()->m())
                    <div id="fmmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*7);">{{ $cat->f()->m()->m()->m()->l() }}</div>
                        @if ($cat->f()->m()->m()->m()->f())
                        <div id="fmmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*14);">{{ $cat->f()->m()->m()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->f()->m()->m()->m()->m())
                        <div id="fmmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*15);">{{ $cat->f()->m()->m()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
        @endif
        @if ($cat->m())
        <div id="m" class="one" style="left: 0;height: 400px;margin-top: calc(400px*1);">{{ $cat->m()->l() }}</div>
            @if ($cat->m()->f())
            <div id="mf" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*2);">{{ $cat->m()->f()->l() }}</div>
                @if ($cat->m()->f()->f())
                <div id="mff" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*4);">{{ $cat->m()->f()->f()->l() }}</div>
                    @if ($cat->m()->f()->f()->f())
                    <div id="mfff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*8);">{{ $cat->m()->f()->f()->f()->l() }}</div>
                        @if ($cat->m()->f()->f()->f()->f())
                        <div id="mffff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*16);">{{ $cat->m()->f()->f()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->f()->f()->f()->m())
                        <div id="mfffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*17);">{{ $cat->m()->f()->f()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->m()->f()->f()->m())
                    <div id="mffm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*9);">{{ $cat->m()->f()->f()->m()->l() }}</div>
                        @if ($cat->m()->f()->f()->m()->f())
                        <div id="mffmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*18);">{{ $cat->m()->f()->f()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->f()->f()->m()->m())
                        <div id="mffmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*19);">{{ $cat->m()->f()->f()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->m()->f()->m())
                <div id="mfm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*5);">{{ $cat->m()->f()->m()->l() }}</div>
                    @if ($cat->m()->f()->m()->f())
                    <div id="mfmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*10);">{{ $cat->m()->f()->m()->f()->l() }}</div>
                        @if ($cat->m()->f()->m()->f()->f())
                        <div id="mfmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*20);">{{ $cat->m()->f()->m()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->f()->m()->f()->m())
                        <div id="mfmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*21);">{{ $cat->m()->f()->m()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->m()->f()->m()->m())
                    <div id="mfmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*11);">{{ $cat->m()->f()->m()->m()->l() }}</div>
                        @if ($cat->m()->f()->m()->m()->f())
                        <div id="mfmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*22);">{{ $cat->m()->f()->m()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->f()->m()->m()->m())
                        <div id="mfmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*23);">{{ $cat->m()->f()->m()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
            @if ($cat->m()->m())
            <div id="mm" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*3);">{{ $cat->m()->m()->l() }}</div>
                @if ($cat->m()->m()->f())
                <div id="mmf" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*6);">{{ $cat->m()->m()->f()->l() }}</div>
                    @if ($cat->m()->m()->f()->f())
                    <div id="mmff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*12);">{{ $cat->m()->m()->f()->f()->l() }}</div>
                        @if ($cat->m()->m()->f()->f()->f())
                        <div id="mmfff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*24);">{{ $cat->m()->m()->f()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->m()->f()->f()->m())
                        <div id="mmffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*25);">{{ $cat->m()->m()->f()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->m()->m()->f()->m())
                    <div id="mmfm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*13);">{{ $cat->m()->m()->f()->m()->l() }}</div>
                        @if ($cat->m()->m()->f()->m()->f())
                        <div id="mmfmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*26);">{{ $cat->m()->m()->f()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->m()->f()->m()->m())
                        <div id="mmfmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*27);">{{ $cat->m()->m()->f()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->m()->m()->m())
                <div id="mmm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*7);">{{ $cat->m()->m()->m()->l() }}</div>
                    @if ($cat->m()->m()->m()->f())
                    <div id="mmmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*14);">{{ $cat->m()->m()->m()->f()->l() }}</div>
                        @if ($cat->m()->m()->m()->f()->f())
                        <div id="mmmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*28);">{{ $cat->m()->m()->m()->f()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->m()->m()->f()->m())
                        <div id="mmmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*29);">{{ $cat->m()->m()->m()->f()->m()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->m()->m()->m()->m())
                    <div id="mmmm" class="four" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*15);">{{ $cat->m()->m()->m()->m()->l() }}</div>
                        @if ($cat->m()->m()->m()->m()->f())
                        <div id="mmmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*30);">{{ $cat->m()->m()->m()->m()->f()->l() }}</div>
                        @endif
                        @if ($cat->m()->m()->m()->m()->m())
                        <div id="mmmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*31);">{{ $cat->m()->m()->m()->m()->m()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
        @endif
    </div>
</div>
<hr>

@endsection

@section ('ext_css')
<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
@endsection
