<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $users = User::with('posts')->get();
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {

        $this->authorize('delete', $user);

        $user->posts()->delete(); 
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User and associated posts deleted successfully');
    }
}
