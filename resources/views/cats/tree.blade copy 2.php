@extends('layouts.cat-profile-wide')

@section('subtitle', trans('app.family_tree'))

@section('cat-content')

@section('ext_css')
<script src="/js/jquery.min.js"></script>
<script src="/js/inbreeding.js"></script>
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
.mm {
    margin-top: 25px !important;
}
.m {
    margin-top: 50px !important;
}
@endif

@if ($generations == 1)
.five, .four, .three, .two {
    display: none;
}
.one {
    height: 25px !important;
}
.m {
    margin-top: 25px !important;
}
@endif */
</style>
@endsection


<div id="generations">Generations: <span class="generations">{{$generations}}</span></div>
<div id="wrapper" class="family-tree">
    <!-- <div id="x" style="left: 0;margin-top: -25px;height: 25px;">{{ $cat->l() }}</div> -->
        @if ($cat->s())
        <div id="f" class="one" style="left: 0;height: 400px;">{{ $cat->s()->l() }}</div>
            @if ($cat->s()->s())
            <div id="ff" class="two" style="left: calc((100%/5)*1);height: 200px;">{{ $cat->s()->s()->l() }}</div>
                @if ($cat->s()->s()->s())
                <div id="fff" class="three" style="left: calc((100%/5)*2);height: 100px;">{{ $cat->s()->s()->s()->l() }}</div>
                    @if ($cat->s()->s()->s()->s())
                    <div id="ffff" class="four" style="left: calc((100%/5)*3);height: 50px;">{{ $cat->s()->s()->s()->s()->l() }}</div>
                        @if ($cat->s()->s()->s()->s()->s())
                        <div id="fffff" class="five" style="left: calc((100%/5)*4);height: 25px;">{{ $cat->s()->s()->s()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->s()->s()->s()->d())
                        <div id="ffffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*1);">{{ $cat->s()->s()->s()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->s()->s()->s()->d())
                    <div id="fffm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*1);">{{ $cat->s()->s()->s()->d()->l() }}</div>
                        @if ($cat->s()->s()->s()->d()->s())
                        <div id="fffmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*2);">{{ $cat->s()->s()->s()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->s()->s()->d()->d())
                        <div id="fffmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*3);">{{ $cat->s()->s()->s()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->s()->s()->d())
                <div id="ffm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*1);">{{ $cat->s()->s()->d()->l() }}</div>
                    @if ($cat->s()->s()->d()->s())
                    <div id="ffmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*2);">{{ $cat->s()->s()->d()->s()->l() }}</div>
                        @if ($cat->s()->s()->d()->s()->s())
                        <div id="ffmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*4);">{{ $cat->s()->s()->d()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->s()->d()->s()->d())
                        <div id="ffmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*5);">{{ $cat->s()->s()->d()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->s()->s()->d()->d())
                    <div id="ffmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*3);">{{ $cat->s()->s()->d()->d()->l() }}</div>
                        @if ($cat->s()->s()->d()->d()->s())
                        <div id="ffmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*6);">{{ $cat->s()->s()->d()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->s()->d()->d()->d())
                        <div id="ffmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*7);">{{ $cat->s()->s()->d()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
            @if ($cat->s()->d())
            <div id="fm" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*1);">{{ $cat->s()->d()->l() }}</div>
                @if ($cat->s()->d()->s())
                <div id="fmf" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*2);">{{ $cat->s()->d()->s()->l() }}</div>
                    @if ($cat->s()->d()->s()->s())
                    <div id="fmff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*4);">{{ $cat->s()->d()->s()->s()->l() }}</div>
                        @if ($cat->s()->d()->s()->s()->s())
                        <div id="fmfff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*8);">{{ $cat->s()->d()->s()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->d()->s()->s()->d())
                        <div id="fmffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*9);">{{ $cat->s()->d()->s()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->s()->d()->s()->d())
                    <div id="fmfm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*5);">{{ $cat->s()->d()->s()->d()->l() }}</div>
                        @if ($cat->s()->d()->s()->d()->s())
                        <div id="fmfmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*10);">{{ $cat->s()->d()->s()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->d()->s()->d()->d())
                        <div id="fmfmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*11);">{{ $cat->s()->d()->s()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->s()->d()->d())
                <div id="fmm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*3);">{{ $cat->s()->d()->d()->l() }}</div>
                    @if ($cat->s()->d()->d()->s())
                    <div id="fmmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*6);">{{ $cat->s()->d()->d()->s()->l() }}</div>
                        @if ($cat->s()->d()->d()->s()->s())
                        <div id="fmmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*12);">{{ $cat->s()->d()->d()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->d()->d()->s()->d())
                        <div id="fmmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*13);">{{ $cat->s()->d()->d()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->s()->d()->d()->d())
                    <div id="fmmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*7);">{{ $cat->s()->d()->d()->d()->l() }}</div>
                        @if ($cat->s()->d()->d()->d()->s())
                        <div id="fmmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*14);">{{ $cat->s()->d()->d()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->s()->d()->d()->d()->d())
                        <div id="fmmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*15);">{{ $cat->s()->d()->d()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
        @endif
        @if ($cat->d())
        <div id="m" class="one" style="left: 0;height: 400px;margin-top: calc(400px*1);">{{ $cat->d()->l() }}</div>
            @if ($cat->d()->s())
            <div id="mf" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*2);">{{ $cat->d()->s()->l() }}</div>
                @if ($cat->d()->s()->s())
                <div id="mff" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*4);">{{ $cat->d()->s()->s()->l() }}</div>
                    @if ($cat->d()->s()->s()->s())
                    <div id="mfff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*8);">{{ $cat->d()->s()->s()->s()->l() }}</div>
                        @if ($cat->d()->s()->s()->s()->s())
                        <div id="mffff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*16);">{{ $cat->d()->s()->s()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->s()->s()->s()->d())
                        <div id="mfffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*17);">{{ $cat->d()->s()->s()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->d()->s()->s()->d())
                    <div id="mffm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*9);">{{ $cat->d()->s()->s()->d()->l() }}</div>
                        @if ($cat->d()->s()->s()->d()->s())
                        <div id="mffmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*18);">{{ $cat->d()->s()->s()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->s()->s()->d()->d())
                        <div id="mffmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*19);">{{ $cat->d()->s()->s()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->d()->s()->d())
                <div id="mfm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*5);">{{ $cat->d()->s()->d()->l() }}</div>
                    @if ($cat->d()->s()->d()->s())
                    <div id="mfmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*10);">{{ $cat->d()->s()->d()->s()->l() }}</div>
                        @if ($cat->d()->s()->d()->s()->s())
                        <div id="mfmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*20);">{{ $cat->d()->s()->d()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->s()->d()->s()->d())
                        <div id="mfmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*21);">{{ $cat->d()->s()->d()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->d()->s()->d()->d())
                    <div id="mfmm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*11);">{{ $cat->d()->s()->d()->d()->l() }}</div>
                        @if ($cat->d()->s()->d()->d()->s())
                        <div id="mfmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*22);">{{ $cat->d()->s()->d()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->s()->d()->d()->d())
                        <div id="mfmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*23);">{{ $cat->d()->s()->d()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
            @endif
            @if ($cat->d()->d())
            <div id="mm" class="two" style="left: calc((100%/5)*1);height: 200px;margin-top: calc(200px*3);">{{ $cat->d()->d()->l() }}</div>
                @if ($cat->d()->d()->s())
                <div id="mmf" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*6);">{{ $cat->d()->d()->s()->l() }}</div>
                    @if ($cat->d()->d()->s()->s())
                    <div id="mmff" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*12);">{{ $cat->d()->d()->s()->s()->l() }}</div>
                        @if ($cat->d()->d()->s()->s()->s())
                        <div id="mmfff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*24);">{{ $cat->d()->d()->s()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->d()->s()->s()->d())
                        <div id="mmffm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*25);">{{ $cat->d()->d()->s()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->d()->d()->s()->d())
                    <div id="mmfm" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*13);">{{ $cat->d()->d()->s()->d()->l() }}</div>
                        @if ($cat->d()->d()->s()->d()->s())
                        <div id="mmfmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*26);">{{ $cat->d()->d()->s()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->d()->s()->d()->d())
                        <div id="mmfmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*27);">{{ $cat->d()->d()->s()->d()->d()->l() }}</div>
                        @endif
                    @endif
                @endif
                @if ($cat->d()->d()->d())
                <div id="mmm" class="three" style="left: calc((100%/5)*2);height: 100px;margin-top: calc(100px*7);">{{ $cat->d()->d()->d()->l() }}</div>
                    @if ($cat->d()->d()->d()->s())
                    <div id="mmmf" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*14);">{{ $cat->d()->d()->d()->s()->l() }}</div>
                        @if ($cat->d()->d()->d()->s()->s())
                        <div id="mmmff" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*28);">{{ $cat->d()->d()->d()->s()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->d()->d()->s()->d())
                        <div id="mmmfm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*29);">{{ $cat->d()->d()->d()->s()->d()->l() }}</div>
                        @endif
                    @endif
                    @if ($cat->d()->d()->d()->d())
                    <div id="mmmm" class="four" class="four" style="left: calc((100%/5)*3);height: 50px;margin-top: calc(50px*15);">{{ $cat->d()->d()->d()->d()->l() }}</div>
                        @if ($cat->d()->d()->d()->d()->s())
                        <div id="mmmmf" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*30);">{{ $cat->d()->d()->d()->d()->s()->l() }}</div>
                        @endif
                        @if ($cat->d()->d()->d()->d()->d())
                        <div id="mmmmm" class="five" style="left: calc((100%/5)*4);height: 25px;margin-top: calc(25px*31);">{{ $cat->d()->d()->d()->d()->d()->l() }}</div>
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
