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
            'role' => 'required|in:manager,seller,user',
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
    public function manager_edit(Request $request,$id){
        $manager = User::where('id',$id)->first();
        return view('dashboard.management.assign_existing_role.managerEdit.edit',compact('manager'));
    }
        public function manager_update(Request $request, $id){
         $manager = User::where('id',$id)->first();
        if($manager){
            $manager->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);
            return redirect()->route('management.register')->with('success','Manager updated successfully');
        }else{
            return back()->withErrors(['error' => 'Manager not found.'])->withInput();
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
        $sellers = User::where('role','seller')->get();
        return view('dashboard.management.assign_existing_role.index',compact('users','sellers'));
    }
    public function assign_existing_role_store(Request $request){
        $request->validate([
            'role'=>'required|in:manager,seller,user',
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

    // seller part start
    public function assign_existing_role_seller_down(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'seller'){
            $user->update([
                'role' => 'user',
                'updated_at' => now()
            ]);
            return back()->with('success','Role downgraded successfully');
    }else{
            return back()->withErrors(['error' => 'Invalid role for downgrade.'])->withInput();
        }
}

      public function seller_edit($id){
        $seller = User::where('id',$id)->first();
        return view('dashboard.management.assign_existing_role.sellerEdit.edit',compact('seller'));
    }
    public function seller_update(Request $request, $id){
         $seller = User::where('id',$id)->first();
        if($seller){
            $seller->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]);
            return redirect()->route('management.assign.existing.role')->with('success','seller updated successfully');
        }else{
            return back()->withErrors(['error' => 'seller not found.'])->withInput();
        }
    }
    public function assign_existing_role_seller_delete(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'seller'){
            $user->delete();
            return back()->with('success','seller deleted successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for deletion.'])->withInput();
        }
    }
    //seller part end

    // user part start
    public function user_edit($id){
        $user = User::where('id',$id)->first();
        return view('dashboard.management.assign_existing_role.userEdit.edit',compact('user'));
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
        public function assign_existing_role_user_block(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'user'){
            User::find($user->id)->update([
                'blocked' => true,
                'blocked_at' => now(),
            ]);
            return back()->with('success','User blocked successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for blocking.'])->withInput();
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

    //block user show page start
    public function block_user(){
        $users = User::where('role','user')->where('blocked',true)->get();
        return view('dashboard.management.blocked.blockUser',compact('users'));
    }
    //block user show page end

    public function unblock_user(Request $request,$id){
        $user = User::where('id',$id)->first();

        if($user->role == 'user'){
        $user->update([
        'blocked' => false,
        'updated_at' => now(),
        ]);
         return back()->with('success','User Unblocked successfully');
    }else{
        return back()->withErrors('error','Can not found any user..!');
    }
}
    public function delete_block_user(Request $request, $id){
        $user = User::where('id',$id)->first();

        if($user->role == 'user'){
            $user->delete();
            return back()->with('success','User deleted successfully');
        }else{
            return back()->withErrors(['error' => 'Invalid role for deletion.'])->withInput();
        }
    }

}
