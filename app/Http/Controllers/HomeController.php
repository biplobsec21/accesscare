<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Menu;
use App\Page;

class HomeController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('public.index');
	}
	public function page(Request $request){
		$keyword = $request->keyword;
		if($keyword == 'home-root'){
			return redirect('/');
		}
		$menu = Menu::where('slug','=',$keyword)->first();
		$pagesContent = Page::where('menu_id','=',$menu->id);
		$menuname = $menu->name;
		return view('public.pages.'.$menu->file_name)
				->with('menuname',$menuname)
				->with('menu_id',$menu->id)
				->with('pagesContent', $pagesContent);
		
	}
}
