@extends('layouts.contentLayoutMaster')

@section('vendor-style')
	{{-- Page Css files --}}
	{{--  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">--}}
	{{--  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">--}}
@endsection

@section('page-style')
	{{-- Page Css files --}}
	{{--  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">--}}
	{{--  <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">--}}

@endsection

@section('vendor-script')
	{{-- Vendor js files --}}
	{{--  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>--}}
	{{--  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>--}}
	{{--  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>--}}
	{{--  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>--}}
@endsection

@section('upper-page-script')
	{{-- Page js files --}}
	{{--  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>--}}
	<script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
	{{--  <script src="{{ asset('assets') }}/global/plugins/jquery.min.js" type="text/javascript"></script>--}}
@endsection

@section('lower-page-script')
@endsection