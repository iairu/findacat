@extends('layouts.app')
@section('title',trans('backup.index_title'))

@section('content')
<h3 class="page-header">{{ trans('backup.index_title') }}</h3>
<div class="row">
  <div class="text-danger text-right">There was an issue with your upload, please check your PHP settings that they allow for large file uploads.</div>
  <div class="text-danger text-right">Also make sure that the UUIDs are not yet present in the database or reset the database.</div>
</div>
@endsection