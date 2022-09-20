<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/user/{email}/{password}', function (Request $request, $email, $password) {
	Log::info('Somebody tried to log in');
	
	$users = User::all();
	foreach($users as $user) {
		echo $user->name;
		echo "<br/>";
	}
	echo "YES! email = ".$email."; password = ".$password."; userCount = X";
	echo "<br/>";
	echo "path() = ".$request->path();
	echo "<br/>";
	echo "url() = ".$request->url();
	echo "<br/>";
	echo "fullUrl() = ".$request->fullUrl();
	echo "<br/>";
	echo "getHost() = ".$request->getHost();
	echo "<br/>";
	echo "getHttpHost() = ".$request->getHttpHost();
	echo "<br/>";
	echo "<br/>";
	
	$attempt = Auth::attempt(array('email' => $email, 'password' => $password));
	if ($attempt) {
		Log::info('login succeeded');
		$request->session()->put('key', 2234);
		return redirect()->route('entrance');
	} else {
		Log::info('login failed');
		echo("KO!");
	}
    //return view('welcome');
});

Route::get('entrance', function (Request $request) {
	if ($request->session()->pull('key') != 2234) {
		echo 'Who are you?';
	} else {
		$request->session()->put('key', 3234);
		return view('entrance');
	}
})->name('entrance');

Route::get('entrance2', function (Request $request) {
	if ($request->session()->pull('key') != 3234) {
		echo 'You are not allowed to enter entrance2';
	} else {
		return view('entrance2');
	}
})->name('entrance2');
