<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
	public function show ()
	{
		$table = Table::first();
		return view('admin.table' , compact('table'));
	}

	public function edit (Request $request)
	{
		$table = Table::first();
		if(!$table) $table = new Table;
		$table->fill($request->all());
		$table->save();
		return back();
	}
}
