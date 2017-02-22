@if(isset($buttons))
	<?php $array = $buttons ; unset($buttons); ?>
	@foreach($array as $button)
		{{--@include('templates.say' , ['array'=>$button]);--}}
		@include("manage.posts.editor-subButton" , $button)
	@endforeach
@else



	@if(!isset($condition) or $condition)
		@if($command=='-')
			<li role="separator" class="divider"></li>
		@else
			<li>
				<a href="{{v0()}}" onclick="postSubmit('{{ $command }}')" class="{{$class or ''}}">
					{{ trans("posts.form.$command") }}
				</a>
			</li>
		@endif
	@endif



@endif
