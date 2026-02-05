<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index(){
        $managers = User::where('role','manager')->where('blocked',false)->get();
        return view('dashboard.management.auth.register',compact('managers'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:8',
            'role' => 'required|in:manager,blogger,user',
        ]);

        if(!$request->role == ''){
              User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'created_at' => now(),
        ]);
        return back()->with('success','Registered successfully');
        }else{
            return back()->withErrors(['error' => 'The role field is required.'])->withInput();
        }

    }
    public function status($id){
        $manager = User::where('id',$id)->first();
        if($manager->status == 'active'){
            $manager->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status updated successfully');
        }else{
            $manager->update([
                'status' => 'deactive',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status updated successfully');
        }
    }

    public function manager_down($id){
        $user = User::where('id',$id)->first();

        if($user->role =='manager'){
           User::where('id',$id)->update([
                'role' => 'user',
                'updated_at' => now(),
            ]);
            return back()->with('success','Manager Demotion Successfully..!');
        }
    }
    public function manager_block(Request $request,$id){
        $user = User::where('id',$id)->first();
        if($user->role =='manager'){
           User::find($user->id)->update([
                'blocked' => true,
                'blocked_at' => now(),
            ]);
            return back()->with('success','Manager Blocked Successfully..!');
        }else{
            return back()->withErrors(['error' => 'Invalid role for blocking.'])->withInput();
        }
    }

    public function manager_delete($id){
        $manager = User::where('id',$id)->first();
        if($manager){
            $manager->delete();
            return back()->with('success','Manager deleted successfully');
        }else{
            return back()->withErrors(['error' => 'Manager not found.'])->withInput();
        }
    }

    // assign existing role
    public function assign_existing_role(){
        $users = User::where('role','user')->where('blocked',false)->get();
        $bloggers = User::where('role','blogger')->get();
        return view('dashboard.management.assign_existing_role.index',compact('users','bloggers'));
    }
    public function assign_existing_role_store(Request $request){
        $request->validate([
            'role'=>'required|in:manager,blogger,user',
        ]);
        $user = User::where('id',$request->user_id)->first();
        if($user){
            $user->update([
                'role' => $request->role,
                'updated_at' => now()
            ]);
            return back()->with('success','Role assigned successfully');
        }else{
            return back()->withErrors(['error' => 'User not found.'])->withInput();
        }
    }

    // blogger part start
    public function assign_existing_role_blogger_down(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'blogger'){
            $user->update([
                'role' => 'user',
                'updated_at' => now()
            ]);
            return back()->with('success','Role downgraded successfully');
    }else{
            return back()->withErrors(['error' => 'Invalid role for downgrade.'])->withInput();
        }
}

    public function assign_existing_role_blogger_block(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'blogger'){
            User::find($user->id)->update([
                'blocked' => true,
                'blocked_at' => now(),
            ]);
            return back()->with('success','Blogger blocked successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for blocking.'])->withInput();
        }
    }
    public function assign_existing_role_blogger_delete(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'blogger'){
            $user->delete();
            return back()->with('success','Blogger deleted successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for deletion.'])->withInput();
        }
    }
    //blogger part end

    // user part start
    public function user_edit($id){
        $user = User::where('id',$id)->first();
        return view('dashboard.management.assign_existing_role.edit',compact('user'));
    }

    public function user_update(Request $request, $id){
        $user = User::where('id',$id)->first();
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required',
        ]);
        if($user){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);
            return redirect()->route('management.assign.existing.role')->with('success','User updated successfully');
        }else{
            return back()->withErrors(['error' => 'User not found.'])->withInput();
        }
    }
    public function assign_existing_role_user_delete(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'user'){
            $user->delete();
            return back()->with('success','User deleted successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for deletion.'])->withInput();
        }
    }

    // user part end
}
