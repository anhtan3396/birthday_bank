<?php

namespace App\Http\Controllers\Backend;

use App\Models\MSetting;
use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller{
    public function index(Request $request, SettingRepository $settingRepository)
    {
        $s_key    = $request->input('s_key');
        $s_name  = $request->input('s_name');
        $search_query = MSetting::query();
        if($s_key)
        {
            $search_query->where('s_key', 'like', '%'.$s_key.'%');
        }
        if($s_name)
        {
            $search_query->where('s_name', 'like', '%'.$s_name.'%');
        }
        
        $settings = $settingRepository->getAllSetting($search_query);
        return view('Backend.settings.list', ['settings' => $settings]);
    }

    public function show()
    {
        $list = MSetting::all()->toArray();
        $array_new_setting = array();
        foreach($list as $row) {
            $array_new_setting[] = $row['s_key'];
        }
        $array_new_setting = array_unique($array_new_setting);
        return view('Backend.settings.create', ['array' => $array_new_setting]);
    }
    public function create(Request $request, SettingRepository $settingRepository )
    {
        
        $validator = Validator::make($request->all(), [
        's_key'                 => 'required|max:255',
        's_value'               => 'required|max:11|numeric',
        's_name'                => 'required|max:255'
    
        ],
        [ 
        's_key.required'         => 'Vui lòng nhập từ khóa.',
        's_value.required'       => 'Vui lòng nhập giá trị cho từ khóa',
        's_name.required'        => 'Vui lòng nhập tên cho từ khóa',
        's_key.max'              => 'Từ khóa có tối đa :max ký tự.',
        's_value.max'            => 'Giá trị từ khóa có tối đa :max ký tự.',
        's_value.numeric'        => 'Vui lòng nhập giá trị từ khóa là kiểu số.',
        's_name.max'             => 'Tên từ khóa có tối đa :max ký tự.',
        ]);


    if ($validator->fails())
    {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    else{
        $s_key        = $request->input('s_key');
        $s_value      = $request->input('s_value');
        $s_name       = $request->input('s_name');
        
        $setting = $settingRepository->create(
            [
            "s_key"         =>$s_key,
            "s_value"       =>$s_value, 
            "s_name"        =>$s_name, 
            ]);
        return redirect('settings/list');
        }

    }

    public function edit($id, SettingRepository $settingRepository)
    {
        $list = MSetting::all()->toArray();
        $array_new_setting = array();
        foreach($list as $row) {
            $array_new_setting[] = $row['s_key'];
        }
        $array_new_setting = array_unique($array_new_setting);
        $validator = Validator::make(['setting_id' => $id], [
                'setting_id'   => 'exists:m_settings,setting_id'
            ], [
                'setting_id.required'      => 'Không tồn tại dữ liệu',
            ]);

        if ($validator->fails())
        {
            return redirect()->back();
        }
        else
        {
            $setting = $settingRepository->find((int)$id);
            return view('Backend.settings.update', ['setting' => $setting,'array' => $array_new_setting]);  
        }
    }

    public function update(Request $request, $id, SettingRepository $settingRepository)
    {
        $validator = Validator::make($request->all(), [
        's_value'               => 'required|max:11|numeric',
        's_name'                => 'required|max:255'
    
        ],
        [ 
        's_value.required'       => 'Vui lòng nhập giá trị cho từ khóa',
        's_name.required'        => 'Vui lòng nhập tên cho từ khóa',
        's_value.max'            => 'Giá trị từ khóa có tối đa :max ký tự.',
        's_value.numeric'        => 'Vui lòng nhập giá trị từ khóa là kiểu số.',
        's_name.max'             => 'Tên từ khóa có tối đa :max ký tự.',
        ]);


        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $s_key        = $request->get('s_key');
            $s_value      = $request->get('s_value');
            $s_name       = $request->get('s_name');

            $setting = $settingRepository->update(
                [
                "s_key"         =>$s_key,
                "s_value"       =>$s_value, 
                "s_name"        =>$s_name, 
                ]);
            return redirect('settings/list');
            }
    }

    public function destroy($id, SettingRepository $settingRepository)
    {
        $settingRepository->update(
            [
                "deleted_flag"          => 1, 
            ],
            $id,
                "setting_id"
            );
        return redirect()->back();
    }

    public function deleteall(Request $rq, SettingRepository $settingRepository)
    {
        $list_id = $rq->get('list_id');
        foreach ($list_id as $id) {
            //update delete_flag
            $settingRepository->update(
                [
                    "deleted_flag"          => 1,
                ],
                $id,
                    "setting_id"
                );
        }
        return redirect()->back();
    }
}