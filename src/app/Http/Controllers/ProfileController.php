<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Profile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            $extension = $request->file('profile_img')->getClientOriginalExtension();
            $fileName = time().'_' .'id-'.(auth()->id()). '.' .$extension;
            $targetPath = 'profiles/';

            $file = $request->file('profile_img');
            $image = Image::make($file)->resize(800, null, function($constraint) {
                $constraint->aspectRatio();
            })
            ->encode($extension, 75);

            Storage::disk('public')->put($targetPath.$fileName, $image);

            $imgPath = 'storage/profiles/';
            Profile::updateOrCreate(['user_id' => auth()->id()], [
                'nickname' => $request->nickname,
                'profile_img' => $imgPath.$fileName,
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
