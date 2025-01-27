<?php

namespace App\Http\Controllers\Admin;

use \Hash;
use Illuminate\Http\Request;

class UserPanelController extends AdminBaseController
{
    
    // middleware auth aplicado en route

	/**
	 * Muestra formulario de datos del usuario
	 * @return [type] [description]
	 */
	public function show()
	{
		return view("back.account")->with("user", \Auth::user());
	}


	/**
	 * Actualiza datos del usuario
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update(Request $request)
	{
		$user = \Auth::user();

		if($request->name != $user->name)
		{
			$request->validate([
				"name" => "required|unique:users|max:100"
			]);

			$user->name = $request->name;
		}


		if($request->filled("current_password") || $request->filled("new_password") || $request->filled("new_password_2"))
		{

			if (!Hash::check($request->current_password, $user->password))
				return redirect()->back()->withErrors("La contraseña actual ingresada no es correcta.");			

			$request->validate([
				"new_password" => "required|min:6|max:100",
				"new_password_2" => "required|min:6|max:100|same:new_password",
			]);	

			$user->password = Hash::make($request->new_password);
		}

		$user->save();

		$request->session()->flash('success');
		return redirect()->back();
	}


}
