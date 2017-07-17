@extends('manage.frame.use.0')

@section('section')

	@php
		if(!isset($request_role) or !$request_role) {
			$request_role = 'admin' ;
		}
	@endphp

	@if(!$model->id)
		<div id="divInquiry">
			@include('manage.users.volunteer-editor-inquiry' )
		</div>
	@endif
	<div id="divForm" class="{{ $model->id? '' : 'noDisplay' }}" data-src="manage/users/act/-id-/volunteer-editor-form/{{$request_role}}" data-id="">
		@include("manage.users.volunteer-editor-form")
	</div>
	<div id="divCard" class="noDisplay" data-src="manage/users/act/-id-/volunteer-editor-show/{{$request_role}}" data-id="">
	</div>


@endsection