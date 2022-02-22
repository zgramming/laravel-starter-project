@extends('templates.template')
@section('title_header') Halaman User @endsection

@section('extends-css')
@endsection

@section('content')
<div class="d-flex flex-sm-column flex-md-row flex-lg-row justify-content-between my-3">
    <h3>Breadcrumb</h3>
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Breadcrumb</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">test</div>
    <div class="card-body">ss</div>
</div>
@endsection

@section('extends-js')
@endsection
