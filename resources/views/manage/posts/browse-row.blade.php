@include('manage.frame.widgets.grid-rowHeader' , [
	'refresh_url' => "manage/posts/update/$model->id"
])


{{--
|--------------------------------------------------------------------------
| Properties
|--------------------------------------------------------------------------
| Title, Status, Locale, Important Dates
--}}

<td>
	@include("manage.frame.widgets.grid-text" , [
		'text' => $model->title,
		'link' => $model->canEdit()? url("manage/posts/$model->type/edit/-id-") : '',
	])

	@include("manage.frame.widgets.grid-badges" , [$badges = [
		[
			'text' => trans('posts.form.copy'),
			'color' => "orange",
			'icon' => "pencil",
			'condition' => $model->isCopy(),
		],
		[
			'text' => trans("forms.status_text.$model->status"),
			'color' => trans("forms.status_color.$model->status"),
			'icon' => trans("forms.status_icon.$model->status"),
		],
		[
			'text' => trans('posts.form.rejected'),
			'color' => "danger",
			'icon' => "undo",
			'condition' => $model->isRejected(),
		],
		[
			'text' => trans('posts.form.is_not_available'),
			'color' => "danger",
			'icon' => "exclamation-triangle",
			'condition' => !$model->trashed() and $model->has('price') and !$model->is_available,
		],
		[
			'text' => trans("forms.lang.$model->locale"),
			'condition' => $model->has('locales'),
			'icon' => "globe",
		]
	]])

	@include("manage.frame.widgets.grid-date" , [
		'text' => trans('forms.general.created_at').': ',
		'text2' => trans('forms.general.by').' '.$model->creator->full_name,
		'date' => $model->created_at,
	])

	@include("manage.frame.widgets.grid-date" , [
		'text' => trans('forms.general.published_at').': ',
		'text2' => trans('forms.general.by').' '.$model->publisher->full_name,
		'date' => $model->published_at,
		'condition' => $model->isPublished(),
	])

	@include("manage.frame.widgets.grid-date" , [
		'text' => trans('forms.general.deleted_at').': ',
		'text2' => trans('forms.general.by').' '.$model->deleter->full_name,
		'date' => $model->deleted_at,
		'condition' => $model->trashed(),
		'color' => "danger",
	])

</td>


{{--
|--------------------------------------------------------------------------
| Price
|--------------------------------------------------------------------------
| Main Price ,Sell Price, sale expire, availabilty
--}}

@if($model->has('price'))
	<td>
		@include("manage.frame.widgets.grid-text" , [
			'condition' => $model->price,
			'text' => number_format($model->price).' '.setting()->ask('currency')->in($model->locale)->gain(),
		])

		@include("manage.frame.widgets.grid-tiny" , [
			'condition' => $model->sale_price > 0,
			'text' => trans('validation.attributes.sale_price').': '. number_format($model->sale_price). ' ' . setting()->in('model->locale')->gain('currency'),
			'color' => "teal",
			'icon' => "bolt",
		])
		@include("manage.frame.widgets.grid-tiny" , [
			'text' => trans('posts.form.discount_percent_in_parentheses' , ['percent' => $model->discount_percent,]),
			'condition' => $model->sale_price > 0,
			'color' => "teal",
			'icon' => "",
		])
		@include("manage.frame.widgets.grid-tiny" , [
			'text' => trans('forms.general.till').' '.jDate::forge($model->sale_expires_at)->format('j F Y [H:i]'),
			'color' => "teal",
			'icon' => "",
			'condition' => $model->sale_expires_at != '',
		])
	</td>
@endif


{{--
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
| Action Buttons
--}}
@include("manage.frame.widgets.grid-actionCol" , [ "actions" => [
	['eye' , trans('posts.form.view_in_site') , "urlN:$model->site_link" , $model->isPublished() and $model->has('preview')],
	['eye-slash', trans('posts.form.preview') , "urlN:$model->preview_link" , $model->has('preview')],
	['-' , $model->has('preview')],

	['pencil' , trans('forms.button.edit') , "url:manage/posts/$model->type/edit/-id-" , $model->canEdit()],
	['pencil-square-o' , trans('posts.form.quick_edit'), "modal:manage/posts/act/-id-/quick_edit" , $model->canEdit()],
	['clone' , trans('posts.form.clone') , "modal:manage/posts/act/-id-/clone" , $model->can('create')],
	['globe' , trans('posts.features.locales') , "modal:manage/posts/act/-id-/locales/" , $model->can('create') and $model->has('locales')],
	['-' , $model->can('create') or $model->canEdit()],

	['trash-o' , trans('forms.button.soft_delete') , "modal:manage/posts/act/-id-/delete" , $model->canDelete() and !$model->trashed()] ,
	['recycle' , trans('forms.button.undelete') , "modal:manage/posts/act/-id-/undelete" , $model->canDelete() and $model->trashed()],
	['times' , trans('forms.button.hard_delete') , "modal:manage/posts/act/-id-/destroy" , $model->canDelete() and $model->trashed()],
]])
