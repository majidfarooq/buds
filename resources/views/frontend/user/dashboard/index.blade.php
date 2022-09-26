@extends('frontend.layouts.app')
@section('title') {{'Dashboard'}} @endsection
@section('keywords') {{'Dashboard'}} @endsection
@section('description') {{'Dashboard'}} @endsection
@section('canonical'){{ Request::url() }}@endsection
@section('style')
 <style>
     #mainNav{
         position: relative !important;
         background-color: #0c0c0c !important;
         margin-bottom: 2em !important;
     }
 </style>
@endsection
@section('content')
 <div class="container-fluid signup-section">
  <div class="row">
   <div class="col-lg-12 col-md-12 p-4 px-5 signup-black min-vh-100"><h1>Dashboard</h1></div>
  </div>
 </div>
@endsection
@section('script')
 @include('flashy::message')
 <script></script>
@endsection
