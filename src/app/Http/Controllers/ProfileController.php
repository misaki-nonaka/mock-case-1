<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function mypage(Request $request){
        $activePage = $request->query('page', 'sell');
        $contents = User::with('profile')->with('exhibits')->with(['purchases' => function($q) {
            $q->where('status', 'paid')->with('buyItem');
        }])
        ->find(auth()->id());
        return view('mypage', compact('activePage', 'contents'));
    }

    public function editProfile(){
        $profile = Profile::where('user_id', auth()->id())->first();
        return view('profile', compact('profile'));
    }

    public function updateProfile(ProfileRequest $request){
        if($request->hasFile('profile_img')){
            $fileName = time().'_' .'id-'.(auth()->id()). '.' .($request->file('profile_img')->getClientOriginalExtension());
            $target_path = 'public/profiles';
            $request->file('profile_img')->storeAs($target_path, $fileName);

            $img_path = 'storage/profiles/';
            Profile::updateOrCreate(['user_id' => auth()->id()], [
                'nickname' => $request->nickname,
                'profile_img' => $img_path.$fileName,
                'zipcode' => $request->zipcode,
                'address' => $request->address,
                'building' => $request->building
            ]);
        }
        else{
            Profile::updateOrCreate(['user_id' => auth()->id()], [
                'nickname' => $request->nickname,
                'zipcode' => $request->zipcode,
                'address' => $request->address,
                'building' => $request->building
            ]);
        }
        return redirect('/mypage');
    }
}
