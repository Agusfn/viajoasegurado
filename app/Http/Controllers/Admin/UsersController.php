<?php

namespace App\Http\Controllers\Admin;

use \App\User;
use Illuminate\Http\Request;
use \Auth;

class UsersController extends AdminBaseController
{



	public function __construct()
	{
		parent::__construct();
		$this->middleware("admin_only");
	}


	public function list()
	{
		$users = User::all();
		return view("back.users.list")->with("users", $users);
	}


	public function details($id)
	{
		$user = User::find($id);
		
		if($user == null)
			return view("back.users.details")->with("user", $user);

		if($user->isSuperAdmin() || (Auth::user()->isAdmin() && $user->isAdmin())) {
			$can_modify_user = false;
		}
		else
			$can_modify_user = true;


		return view("back.users.details")->with([
			"user" => $user, 
			"can_modify" => $can_modify_user
		]);
		
		
	}




	public function update(Request $request, $id)
	{

		$user = User::find($id);

		if($user == null)
			return "Usuario no existe";

		if($user->isSuperAdmin() || (Auth::user()->isAdmin() && $user->isAdmin()))
			return "No se permite modificar a este usuario";


		if(Auth::user()->isSuperAdmin())
			$tipos_cuenta = "admin,operative";
		else if(Auth::user()->isAdmin())
			$tipos_cuenta = "operative";


		$request->validate([
			"tipo_cuenta" => "required|in:".$tipos_cuenta,
			"nombre_usuario" => "required|min:1|max:50",
			"email" => "required|email|max:100"
		]);


		if($request->filled("password")) {
			$request->validate([
				"password" => "required|min:7",
				"password_repeat" => "same:password"
			]);		
		}

		$user->role = $request->tipo_cuenta;
		$user->name = $request->nombre_usuario;
		$user->email = $request->email;

		if($request->filled("password")) {
			$user->password = bcrypt($request->password);
		}

		if($request->filled("disable_account"))
			$user->disabled = true;
		else
			$user->disabled = false;



		$user->save();

		$request->session()->flash('success');
		return back();
	}




	public function new()
	{
		return view("back.users.create");
	}

	public function create(Request $request)
	{

		if(Auth::user()->isSuperAdmin())
			$tipos_cuenta = "admin,operative";
		else if(Auth::user()->isAdmin())
			$tipos_cuenta = "operative";

		$request->validate([
			"tipo_cuenta" => "required|in:".$tipos_cuenta,
			"nombre_usuario" => "required|min:1|max:50",
			"email" => "required|email|max:100",
			"password" => "required|min:7",
			"password_repeat" => "same:password"
		]);

		User::create([
			"role" => $request->tipo_cuenta,
			"name" => $request->nombre_usuario,
			"email" => $request->email,
			"password" => bcrypt($request->password)
		]);

		return redirect('users');
	}		


	public function delete($id)
	{
		
		$user = User::find($id);

		if($user == null)
			return "Usuario no existe";

		if($user->isSuperAdmin() || (Auth::user()->isAdmin() && $user->isAdmin()))
			return "No puedes eliminar a este usuario";

		$user->delete();

		return redirect('users');


	}



}
