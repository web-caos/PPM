@extends('layouts.master')
@section('title')
Dashboard
@stop

@section('body')
<body>
@include('elements.slidingBar')
<div class="main-wrapper">
    @include('elements.topBar')
    @include('elements.pageSlideLeft')
    <!-- start: MAIN CONTAINER -->
    <div class="main-container inner">
        <!-- start: PAGE -->
        <div class="main-content">
            <div class="container">
            @include('elements.pageHeader')
            @include('elements.breadCrumb', $breadcrumb);
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
</div>
@stop

@section('extraJS')
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
@stop