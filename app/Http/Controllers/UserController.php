<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     public function index() 
    {
        $auth = Auth::user()->id;
        $data = User::select('id', 'name', 'email', 'created_at')
            ->where('id', '!=', $auth)
            ->get();
        return view('user', compact('data'));
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

     public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            
        ]);
        
       
        return redirect()->back()->with(AlertHelper::success('User berhasil ditambahkan', 'Success'));
    }

    public function update(Request $request, $id) 
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);
        
        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        } else {
            $request->request->remove('password');
        }
        
        $user->update($request->only('name', 'email', 'password'));
        
        
        return redirect()->back()->with(AlertHelper::success('User berhasil diperbarui', 'Success'));
    }

     public function destroy($id) 
    {
        try {
            $user = User::findOrFail($id);
            
            $user->delete();
            
            return redirect()->back()->with(AlertHelper::success('User berhasil dihapus', 'Success'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with(AlertHelper::error('Gagal menghapus user', 'Error'));
        }
    }
    
}
