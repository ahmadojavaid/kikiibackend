@extends('layouts.contentLayoutMaster')

@section('vendor-style')
	{{-- Page Css files --}}
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
	<!-- vendor css files -->
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
	{{-- Page Css files --}}
	<link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">

@endsection

@section('vendor-script')
	{{-- vendor files --}}
	<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}" ></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>

	<!-- vendor files -->
	<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

@endsection

@section('upper-page-script')
	<script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
@endsection

@section('lower-page-script')
	<script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
	<script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection