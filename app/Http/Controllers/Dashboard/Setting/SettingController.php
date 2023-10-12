<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Traits\UploadFile;

class SettingController extends Controller
{

    use UploadFile;

    public function __construct()
    {
        $this->middleware('permission:settings edit');
    }

    public function index(){
        return view('dashboard.pages.settings.index',[
            'settings'=>Setting::paginate(15)
        ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $query = trim($request->get('query'));
            $settings = Setting::query()->where('key','like',"%{$query}%")->paginate(15);
            return view('dashboard.pages.settings.setting-search',[
                'settings'=>$settings
            ]);
        }
    }


    public function edit(Setting $setting){
        return view('dashboard.pages.settings.edit',[
            'setting'=>$setting,
        ]);
    }

    public function update(SettingUpdateRequest $request,Setting $setting){

        if($value = $request->file('image')){
            $value = $this->newImage(Setting::$path,$request,$setting->value);
        }elseif($value = $request->value){
            $value = $value;
        }elseif($value = $request->type){
            $value = $value;
        }
        
        if(!$value ?? true){
            return redirect()->back()->with('error','we could not make your action');
        }

        $setting->update([
            'value'=>$value,
        ]);
        return redirect()->back()->with('success','setting Updated Successfully');
    }

}
