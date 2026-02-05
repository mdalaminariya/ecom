<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Vtiful\Kernel\Format;
use function Illuminate\Support\now;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountSettingsController extends Controller
{
    public function index(){
        return view('dashboard.accountsettings.index');
    }

    public function name_update(Request $request){
        $request->validate([
            'name'=>'required|string|max:225',
        ]);

        User::find(auth()->id())->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);
       return redirect()->back()->with('success','Name updated successfully');
    }

    public function email_update(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users,email,'.auth()->id(),
        ]);

        User::find(auth()->id())->update([
            'email' => $request->email,
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success','E-mail updated successfully');
    }

    public function password_update(Request $request){
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find(auth()->id());
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['error' => 'The current password is incorrect.']);
        }else{

        $user->update([
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success','Password updated successfully');
    }
    }
    public function image_update(Request $request){
        $manager = new ImageManager(new Driver());
        if($request->hasFile('image')){
            if(auth()->user()->image){
                $old_image = base_path('public/images/profile/'.auth()->user()->image);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }
            $new_name = Auth::user()->id .'-'.now()->format('M d, Y').'-'.rand(1,999).'.'.$request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->toPng()->save(base_path('public/images/profile/'.$new_name));
             User::find(auth()->id())->update([
            'image' => $new_name,
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success','Image updated successfully');
        }else{
            return redirect()->back()->withErrors(['error' => 'Please select an image to upload.']);
        }
    }
}
