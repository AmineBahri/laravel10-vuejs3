<?php 

use App\Models\Page;

	function get_permissions($pages,$permission)
	{
		$pageId = Page::where('page',$pages)->value('id');
        return auth()->user()->role->permissions()->where('page_id',$pageId)->where($permission,1)->exists();
	}

	function second_function()
	{
		// code...
	}
?>