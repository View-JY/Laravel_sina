<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
	public function __construct()
	{

	}

	public function index()
	{
		return;
	}

	public function home()
	{
		return view('static_pages.home');
	}

	public function help()
	{
		return view('static_pages.help');
	}

	public function about()
	{
		return view('static_pages.about');
	}
}

