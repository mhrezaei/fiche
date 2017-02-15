<?php

if(!isset($target)) {
	$target = 'javascript:void(0)' ;
	$on_click = '' ;
}
elseif(str_contains($target,'(')) {
	$on_click = $target ;
	$target = 'javascript:void(0)' ;
}
else {
	$target = url($target) ;
}

?>


<a href="{{$target}}" class="btn btn-{{$type or 'default'}}" title="{{$caption or ''}}" onclick="{{$on_click or ''}}">
	<i class="fa fa-{{$icon or 'dot-circle-o'}}"></i>
	{{ $caption }}
</a>
