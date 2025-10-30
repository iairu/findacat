@extends('layouts.app')

@section('content')
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert" style="margin: 20px 0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert" style="margin: 20px 0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('error') }}
    </div>
    @endif

    @include('cats.partials.action-buttons', ['cat' => $cat])
    <h2 class="page-header">
        {{ $cat->full_name }} <small>@yield('subtitle')</small>
    </h2>
    @yield('cat-content')
@endsection
