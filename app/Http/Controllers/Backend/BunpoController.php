<?php
namespace App\Http\Controllers\Backend;
use App\Models\MBunpo;
use App\Repositories\BunpoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class BunpoController extends Controller
{
    //view list_bunpo and result search multi
    public function index(Request $request,BunpoRepository $bunpoRepository )
    {
        $bunpo_id = $request->input('bunpo_id');
        $hiragana = $request->input('hiragana');
        $katakana = $request->input('katakana');
        $kanji    = $request->input('kanji');
        $meaning  = $request->input('meaning');
        $practice = $request->input('is_type_practice');
        $test     = $request->input('is_type_test');
        $is_n1    = $request->input('is_n1');
        $is_n2    = $request->input('is_n2');
        $is_n3    = $request->input('is_n3');
        $is_n4    = $request->input('is_n4');
        $is_n5    = $request->input('is_n5');
        $search_query = MBunpo::query();
        if($hiragana)
        {
            $search_query->where('hiragana', 'like', '%'.$hiragana.'%');
        }
        if($katakana)
        {
            $search_query->where('katakana', 'like', '%'.$katakana.'%');
        }
        if($kanji)
        {
            $search_query->where('kanji', 'like', '%'.$kanji.'%');
        }
        if($meaning)
        {
            $search_query->where('meaning', 'like', '%'.$meaning.'%');
        }
        if($practice)
        {
            $search_query->where('is_type_practice',$practice);
        }
        if($test)
        {
            $search_query->where('is_type_test',$test);
        }
        if($is_n1)
        {
            $search_query->where('is_n1',$is_n1);
        }
        if($is_n2)
        {
            $search_query->where('is_n2',$is_n2);
        }
        if($is_n3)
        {
            $search_query->where('is_n3',$is_n3);
        }
        if($is_n4)
        {
            $search_query->where('is_n4',$is_n4);
        }
        if($is_n5)
        {
            $search_query->where('is_n5',$is_n5);
        }
        $bunpos = $bunpoRepository->getAllBunpo($search_query);
        return view('Backend.bunpos.list_bunpos', [
            'bunpos'    => $bunpos,
            'hiragana'  => $hiragana,
            'katakana'  => $katakana,
            'kanji'     => $kanji,
            'meaning'   => $meaning,
            'practice'  => $practice,
            'test'      => $test,
            'N1'        => $is_n1,
            'N2'        => $is_n2,
            'N3'        => $is_n3,
            'N4'        => $is_n4,
            'N5'        => $is_n5,
            ]); 
    }
    //view form create
    public function createNewBunpoForm()
    {
        return view('Backend.bunpos.create_bunpo');
    }
    //create bunpo
    public function createNewBunpo(Request $request, BunpoRepository $bunpoRepository)
    {
        if ($request->input('hiragana') == '' && $request->input('katakana') == '') 
        {
            $validator = Validator::make(
                $request->all(), 
                [
                'image'         =>'required|max:4096',
                'hiragana'      =>'required|unique:m_bunpo,hiragana',
                'katakana'      =>'required|unique:m_bunpo,katakana',
                'kanji'         =>'sometimes|max:1000',
                'meaning'       =>'required|max:255',
                'sound'         =>'required|max:4096',
                ]
                ,
                [
                'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                'image.required'        => 'Vui lòng chọn hình ảnh',
                'hiragana.required'     => 'Vui lòng nhập từ vựng hiragana hoặc katakana',
                'hiragana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'katakana.required'     => 'Vui lòng nhập từ vựng katakana hoặc hiragana',
                'katakana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'kanji.sometimes'       => 'Vui lòng nhập từ vựng kanji',
                'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                'sound.required'        => 'Vui lòng chọn âm thanh thích hợp',
                'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                ]
                );
            if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
            {
                $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();    
            }
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else
            {
                $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->input('hiragana');
                $katakana = $request->input('katakana');
                $kanji  = $request->input('kanji');
                $meaning  = $request->input('meaning');
                $soundURL = "";
                if($request->input('is_type_practice'))
                {
                    $is_type_practice = 1;
                }
                if($request->input('is_type_test'))
                {
                    $is_type_test = 1;
                }
                if($request->input('is_n1'))
                {
                    $is_n1 = 1;
                }
                if($request->input('is_n2'))
                {
                    $is_n2 = 1;
                }
                if( $request->input('is_n3'))
                {
                    $is_n3 = 1;
                }
                if($request->input('is_n4'))
                {
                    $is_n4 = 1;
                }
                if($request->input('is_n5'))
                {
                    $is_n5 = 1;
                }
                $bunpo = $bunpoRepository->create(
                    [
                    "image"             => $imageURL,
                    "hiragana"          => $hiragana,
                    "katakana"          => $katakana,
                    "kanji"             => $kanji,
                    "meaning"           => $meaning,
                    "sound"             => $soundURL,
                    "is_n1"             => $is_n1,
                    "is_n2"             => $is_n2,
                    "is_n3"             => $is_n3,
                    "is_n4"             => $is_n4,
                    "is_n5"             => $is_n5,
                    "is_type_practice"  => $is_type_practice,
                    "is_type_test"      => $is_type_test
                    ]
                    );
                if ($bunpo->bunpo_id > 0) {
                    if(Input::hasfile('image'))
                    {
                        $nameImage = Input::file('image')->getClientOriginalExtension();
                        $imageURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). ".". $nameImage;
                        if(File::exists(public_path('upload/image/bunpo/') . $imageURL))
                        {
                            unlink(public_path('upload/image/bunpo/') . $imageURL);   
                        } 
                        Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                    }else
                    {
                        $imageURL = "";
                    }
                    if(Input::hasfile('sound'))
                    {
                        $nameSound = Input::file('sound')->getClientOriginalExtension();
                        if($nameSound == 'mp3')
                        {
                            $soundURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). "." . $nameSound;
                            if(File::exists(public_path('upload/audio/bunpo') . $soundURL))
                            {
                                unlink(public_path('upload/audio/bunpo').$soundURL);   
                            }
                            Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                        }
                        else
                        {
                            return redirect()->back()->withErrors(['sound' => "Vui lòng chọn đúng kiểu âm thanh"])->withInput();
                        }
                    }else
                    {
                        $soundURL = "";
                    }
                    $bunpoRepository->update([
                        'image'     =>  $imageURL,
                        'sound'     =>  $soundURL
                        ], $bunpo->bunpo_id, "bunpo_id");
                    return redirect('bunpos')->with('notify', "Thêm thành công!");
                }
                else {
                    return redirect('bunpos')->with('notify', "Thêm thất bại!");
                }
            }
        }
        else
        {
            if ($request->input('hiragana') != '' && $request->input('katakana') == '') 
            {
                $validator = Validator::make(
                    $request->all(), 
                    [
                    'image'         =>'required|max:4096',
                    'hiragana'      =>'required|unique:m_bunpo,hiragana',
                    'katakana'      =>'sometimes',
                    'kanji'         =>'sometimes|max:1000',
                    'meaning'       =>'required|max:255',
                    'sound'         =>'required|max:4096',
                    ]
                    ,
                    [
                    'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                    'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                    'image.required'        => 'Vui lòng chọn hình ảnh',
                    'hiragana.required'     => 'Vui lòng nhập từ vựng hiragana hoặc katakana',
                    'hiragana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                    'kanji.sometimes'       => 'Vui lòng nhập từ vựng kanji',
                    'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                    'sound.required'        => 'Vui lòng chọn âm thanh thích hợp',
                    'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                    'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                    'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                    ]
                    );
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {
                    $is_type_practice  = 0;
                    $is_type_test   = 0;
                    $is_n1 = 0;
                    $is_n2 = 0;
                    $is_n3 = 0;
                    $is_n4 = 0;
                    $is_n5 = 0;
                    $imageURL = "";
                    $hiragana = $request->input('hiragana');
                    $kanji  = $request->input('kanji');
                    $meaning  = $request->input('meaning');
                    $soundURL = "";
                    if($request->input('is_type_practice'))
                    {
                        $is_type_practice = 1;
                    }
                    if($request->input('is_type_test'))
                    {
                        $is_type_test = 1;
                    }
                    if($request->input('is_n1'))
                    {
                        $is_n1 = 1;
                    }
                    if($request->input('is_n2'))
                    {
                        $is_n2 = 1;
                    }
                    if( $request->input('is_n3'))
                    {
                        $is_n3 = 1;
                    }
                    if($request->input('is_n4'))
                    {
                        $is_n4 = 1;
                    }
                    if($request->input('is_n5'))
                    {
                        $is_n5 = 1;
                    }
                    $bunpo = $bunpoRepository->create(
                        [
                        "image"             => $imageURL,
                        "hiragana"          => $hiragana,
                        "kanji"             => $kanji,
                        "meaning"           => $meaning,
                        "sound"             => $soundURL,
                        "is_n1"             => $is_n1,
                        "is_n2"             => $is_n2,
                        "is_n3"             => $is_n3,
                        "is_n4"             => $is_n4,
                        "is_n5"             => $is_n5,
                        "is_type_practice"  => $is_type_practice,
                        "is_type_test"      => $is_type_test
                        ]
                        );
                    if ($bunpo->bunpo_id > 0) {
                        if(Input::hasfile('image'))
                        {
                            $nameImage = Input::file('image')->getClientOriginalExtension();
                            $imageURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). ".". $nameImage;
                            if(File::exists(public_path('upload/image/bunpo/') . $imageURL))
                            {
                                unlink(public_path('upload/image/bunpo/') . $imageURL);   
                            } 
                            Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                        }else
                        {
                            $imageURL = "";
                        }
                        if(Input::hasfile('sound'))
                        {
                            $nameSound = Input::file('sound')->getClientOriginalExtension();
                            if($nameSound == 'mp3')
                            {
                                $soundURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). "." . $nameSound;
                                if(File::exists(public_path('upload/audio/bunpo') . $soundURL))
                                {
                                    unlink(public_path('upload/audio/bunpo').$soundURL);   
                                }
                                Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                            }
                            else
                            {
                                return redirect()->back()->withErrors(['sound' => "Vui lòng chọn đúng kiểu âm thanh"])->withInput();
                            }
                        }else
                        {
                            $soundURL = "";
                        }
                        $bunpoRepository->update([
                            'image'     =>  $imageURL,
                            'sound'     =>  $soundURL
                            ], $bunpo->bunpo_id, "bunpo_id");
                        return redirect('bunpos')->with('notify', "Thêm thành công!");
                    }
                    else {
                        return redirect('bunpos')->with('notify', "Thêm thất bại!");
                    }
                }
            }
            if ($request->input('hiragana') == '' && $request->input('katakana') != '') 
            {
                $validator = Validator::make(
                    $request->all(), 
                    [
                    'image'         =>'required|max:4096',
                    'hiragana'      =>'sometimes',
                    'katakana'      =>'required|unique:m_bunpo,katakana',
                    'kanji'         =>'sometimes|max:1000',
                    'meaning'       =>'required|max:255',
                    'sound'         =>'required|max:4096',
                    ]
                    ,
                    [
                    'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                    'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                    'image.required'        => 'Vui lòng chọn hình ảnh',
                    'katakana.required'     => 'Vui lòng nhập từ vựng katakana hoặc hiragana',
                    'katakana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                    'kanji.sometimes'       => 'Vui lòng nhập từ vựng kanji',
                    'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                    'sound.required'        => 'Vui lòng chọn âm thanh thích hợp',
                    'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                    'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                    'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                    ]
                    );
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {
                    $is_type_practice  = 0;
                    $is_type_test   = 0;
                    $is_n1 = 0;
                    $is_n2 = 0;
                    $is_n3 = 0;
                    $is_n4 = 0;
                    $is_n5 = 0;
                    $imageURL = "";
                    $katakana = $request->input('katakana');
                    $kanji  = $request->input('kanji');
                    $meaning  = $request->input('meaning');
                    $soundURL = "";
                    if($request->input('is_type_practice'))
                    {
                        $is_type_practice = 1;
                    }
                    if($request->input('is_type_test'))
                    {
                        $is_type_test = 1;
                    }
                    if($request->input('is_n1'))
                    {
                        $is_n1 = 1;
                    }
                    if($request->input('is_n2'))
                    {
                        $is_n2 = 1;
                    }
                    if( $request->input('is_n3'))
                    {
                        $is_n3 = 1;
                    }
                    if($request->input('is_n4'))
                    {
                        $is_n4 = 1;
                    }
                    if($request->input('is_n5'))
                    {
                        $is_n5 = 1;
                    }
                    $bunpo = $bunpoRepository->create(
                        [
                        "image"             => $imageURL,
                        "hiragana"          => $hiragana,
                        "katakana"          => $katakana,
                        "kanji"             => $kanji,
                        "meaning"           => $meaning,
                        "sound"             => $soundURL,
                        "is_n1"             => $is_n1,
                        "is_n2"             => $is_n2,
                        "is_n3"             => $is_n3,
                        "is_n4"             => $is_n4,
                        "is_n5"             => $is_n5,
                        "is_type_practice"  => $is_type_practice,
                        "is_type_test"      => $is_type_test
                        ]
                        );
                    if ($bunpo->bunpo_id > 0) {
                        if(Input::hasfile('image'))
                        {
                            $nameImage = Input::file('image')->getClientOriginalExtension();
                            $imageURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). ".". $nameImage;
                            if(File::exists(public_path('upload/image/bunpo/') . $imageURL))
                            {
                                unlink(public_path('upload/image/bunpo/') . $imageURL);   
                            } 
                            Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                        }else
                        {
                            $imageURL = "";
                        }
                        if(Input::hasfile('sound'))
                        {
                            $nameSound = Input::file('sound')->getClientOriginalExtension();
                            if($nameSound == 'mp3')
                            {
                                $soundURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). "." . $nameSound;
                                if(File::exists(public_path('upload/audio/bunpo') . $soundURL))
                                {
                                    unlink(public_path('upload/audio/bunpo').$soundURL);   
                                }
                                Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                            }
                            else
                            {
                                return redirect()->back()->withErrors(['sound' => "Vui lòng chọn đúng kiểu âm thanh"])->withInput();
                            }
                        }else
                        {
                            $soundURL = "";
                        }
                        $bunpoRepository->update([
                            'image'     =>  $imageURL,
                            'sound'     =>  $soundURL
                            ], $bunpo->bunpo_id, "bunpo_id");
                        return redirect('bunpos')->with('notify', "Thêm thành công!");
                    }
                    else {
                        return redirect('bunpos')->with('notify', "Thêm thất bại!");
                    }
                }
            }
            $validator = Validator::make(
                $request->all(), 
                [
                'image'         =>'required|max:4096',
                'hiragana'      =>'sometimes|unique:m_bunpo,hiragana',
                'katakana'      =>'sometimes|unique:m_bunpo,katakana',
                'kanji'         =>'sometimes',
                'meaning'       =>'required|max:255',
                'sound'         =>'required|max:4096',
                ]
                ,
                [
                'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                'image.required'        => 'Vui lòng chọn hình ảnh',
                'hiragana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'katakana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'kanji.unique'          => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                'sound.required'        => 'Vui lòng chọn âm thanh thích hợp',
                'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                ]
                );
            if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
            {
                $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();    
            }
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else
            {
                $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->input('hiragana');
                $katakana = $request->input('katakana');
                $kanji  = $request->input('kanji');
                $meaning  = $request->input('meaning');
                $soundURL = "";
                if($request->input('is_type_practice'))
                {
                    $is_type_practice = 1;
                }
                if($request->input('is_type_test'))
                {
                    $is_type_test = 1;
                }
                if($request->input('is_n1'))
                {
                    $is_n1 = 1;
                }
                if($request->input('is_n2'))
                {
                    $is_n2 = 1;
                }
                if( $request->input('is_n3'))
                {
                    $is_n3 = 1;
                }
                if($request->input('is_n4'))
                {
                    $is_n4 = 1;
                }
                if($request->input('is_n5'))
                {
                    $is_n5 = 1;
                }
                $bunpo = $bunpoRepository->create(
                    [
                    "image"             => $imageURL,
                    "hiragana"          => $hiragana,
                    "katakana"          => $katakana,
                    "kanji"             => $kanji,
                    "meaning"           => $meaning,
                    "sound"             => $soundURL,
                    "is_n1"             => $is_n1,
                    "is_n2"             => $is_n2,
                    "is_n3"             => $is_n3,
                    "is_n4"             => $is_n4,
                    "is_n5"             => $is_n5,
                    "is_type_practice"  => $is_type_practice,
                    "is_type_test"      => $is_type_test
                    ]
                    );
                if ($bunpo->bunpo_id > 0) {
                    if(Input::hasfile('image'))
                    {
                        $nameImage = Input::file('image')->getClientOriginalExtension();
                        $imageURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). ".". $nameImage;
                        if(File::exists(public_path('upload/image/bunpo/') . $imageURL))
                        {
                            unlink(public_path('upload/image/bunpo/') . $imageURL);   
                        } 
                        Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                    }else
                    {
                        $imageURL = "";
                    }
                    if(Input::hasfile('sound'))
                    {
                        $nameSound = Input::file('sound')->getClientOriginalExtension();
                        if($nameSound == 'mp3')
                        {
                            $soundURL = $bunpo->bunpo_id . "." . date("H_i_s",time()). "." . $nameSound;
                            if(File::exists(public_path('upload/audio/bunpo') . $soundURL))
                            {
                                unlink(public_path('upload/audio/bunpo').$soundURL);   
                            }
                            Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                        }
                        else
                        {
                            return redirect()->back()->withErrors(['sound' => "Vui lòng chọn đúng kiểu âm thanh"])->withInput();
                        }
                    }else
                    {
                        $soundURL = "";
                    }
                    $bunpoRepository->update([
                        'image'     =>  $imageURL,
                        'sound'     =>  $soundURL
                        ], $bunpo->bunpo_id, "bunpo_id");
                    return redirect('bunpos')->with('notify', "Thêm thành công!");
                }
                else {
                    return redirect('bunpos')->with('notify', "Thêm thất bại!");
                }
            }
        }
    }
    // view update a bunpo
    public function editBunpoForm($id, BunpoRepository $bunpoRepository)
    {
        $validator = Validator::make(['bunpo_id' => $id], [
            'bunpo_id'   => 'exists:m_bunpo,bunpo_id'
            ], [
            'bunpo_id.required'      => 'Không tồn tại từ vựng',
            ]);
        if ($validator->fails())
        {
            return redirect()->back();
        }
        else
        {
            $bunpo = $bunpoRepository->find((int)$id);
            return view('Backend.bunpos.edit_bunpo', ['bunpo' => $bunpo]);  
        }
    }
    //update a bunpo
    public function updateBunpo(Request $request, $id, BunpoRepository $bunpoRepository)
    {
        $bunpo = $bunpoRepository->find($id);
        if ($request->input('hiragana') == '' && $request->input('katakana') == '') 
        {
            $validator = Validator::make(
                $request->all(), 
                [
                'image'         =>'sometimes|max:4096',
                'hiragana'      =>'required|unique:m_bunpo,hiragana',
                'katakana'      =>'required|unique:m_bunpo,katakana',
                'kanji'         =>'sometimes|max:100',
                'meaning'       =>'required|max:100',
                'sound'         =>'sometimes|max:4096',
                ]
                ,
                [
                'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                'image.sometimes'       => 'Vui lòng chọn hình ảnh',
                'hiragana.required'     => 'Vui lòng nhập từ vựng hiragana hoặc katakana',
                'hiragana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'katakana.required'     => 'Vui lòng nhập từ vựng katakana hoặc hiragana',
                'katakana.unique'       => 'Từ vựng đã tồn tại. Vui lòng nhập lại',
                'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                'sound.sometimes'       => 'Vui lòng chọn âm thanh thích hợp',
                'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                ]
                );
            if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
            {
                $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();    
            }
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else
            {   
                $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->get('hiragana');
                $katakana = $request->get('katakana');
                $kanji  = $request->get('kanji');
                $meaning  = $request->get('meaning');
                $soundURL = "";
                $bunpoRepository->update(
                    [
                    "is_type_practice"       =>$request->get('is_type_practice') ? 1 : 0,
                    "is_type_test"           =>$request->get('is_type_test') ? 1 : 0,
                    "is_n1"             =>$request->get('is_n1') ? 1 : 0,
                    "is_n2"             =>$request->get('is_n2') ? 1 : 0,
                    "is_n3"             =>$request->get('is_n3') ? 1 : 0,
                    "is_n4"             =>$request->get('is_n4') ? 1 : 0,
                    "is_n5"             =>$request->get('is_n5') ? 1 : 0,
                    "hiragana"          =>$request->get('hiragana'),
                    "katakana"          =>$request->get('katakana'),
                    "kanji"          =>$request->get('kanji'),
                    "meaning"        =>$request->get('meaning')
                    ],
                    $id,
                    "bunpo_id"
                    );
                if (Input::hasfile('image'))
                {
                    $nameImage = Input::file('image')->getClientOriginalExtension();
                    $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                    $oldImage = $bunpo->image;
                    if($oldImage != '')
                    {
                        if(File::exists(public_path('upload/image/bunpo/') . $oldImage))
                        {
                            unlink(public_path('upload/image/bunpo/') . $oldImage);   
                        } 
                    }
                    Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                    $bunpoRepository->update(
                        [
                        "image"          => $imageURL,
                        ],
                        $id,
                        "bunpo_id"
                        );   
                }
                if(Input::hasfile('sound'))
                {
                    $nameSound = Input::file('sound')->getClientOriginalExtension();
                    $oldSound = $bunpo->sound;
                    if($nameSound == 'mp3')
                    {
                        $soundURL = $id . "." . date("H_i_s",time()). "." . $nameSound;
                        if($oldSound != '')
                        {
                            if(File::exists(public_path('upload/audio/bunpo/') . $oldSound))
                            {
                                unlink(public_path('upload/audio/bunpo/').$oldSound);   
                            }
                        }
                        Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                        $bunpoRepository->update(
                            [
                            "sound"          =>$soundURL,
                            ],
                            $id,
                            "bunpo_id"
                            );
                    }else
                    {
                        return redirect()->back()->withErrors("Vui lòng chọn đúng kiểu âm thanh")->withInput();
                    }
                }
                return redirect('bunpos');
            }
        }
        else
        {   
            if($request->get("hiragana") == $bunpo->hiragana || $request->get("katakana") == $bunpo->katakana)
            {
                $validator = Validator::make(
                    $request->all(), 
                    [
                    'image'         =>'sometimes|max:4096',
                    'hiragana'      =>'sometimes',
                    'katakana'      =>'sometimes',
                    'kanji'         =>'sometimes',
                    'meaning'       =>'required|max:255',
                    'sound'         =>'sometimes|max:4096',
                    ]
                    ,
                    [
                    'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                    'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                    'image.sometimes'       => 'Vui lòng chọn hình ảnh',
                    'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                    'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                    'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                    'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                    ]
                    );
                if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
                {
                    $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
                {
                    $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
                {
                    $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();    
                }
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {   
                    $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->get('hiragana');
                $katakana = $request->get('katakana');
                $kanji  = $request->get('kanji');
                $meaning  = $request->get('meaning');
                $soundURL = "";
                $bunpoRepository->update(
                    [
                    "is_type_practice"       =>$request->get('is_type_practice') ? 1 : 0,
                    "is_type_test"           =>$request->get('is_type_test') ? 1 : 0,
                    "is_n1"             =>$request->get('is_n1') ? 1 : 0,
                    "is_n2"             =>$request->get('is_n2') ? 1 : 0,
                    "is_n3"             =>$request->get('is_n3') ? 1 : 0,
                    "is_n4"             =>$request->get('is_n4') ? 1 : 0,
                    "is_n5"             =>$request->get('is_n5') ? 1 : 0,
                    "hiragana"          =>$request->get('hiragana'),
                    "katakana"          =>$request->get('katakana'),
                    "kanji"          =>$request->get('kanji'),
                    "meaning"        =>$request->get('meaning')
                    ],
                    $id,
                    "bunpo_id"
                    );
                    if (Input::hasfile('image'))
                    {
                        $nameImage = Input::file('image')->getClientOriginalExtension();
                        $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                        $oldImage = $bunpo->image;
                        if($oldImage != '')
                        {
                            if(File::exists(public_path('upload/image/bunpo/') . $oldImage))
                            {
                                unlink(public_path('upload/image/bunpo/') . $oldImage);   
                            } 
                        }
                        Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                        $bunpoRepository->update(
                            [
                            "image"          => $imageURL,
                            ],
                            $id,
                            "bunpo_id"
                            );   
                    }
                    if(Input::hasfile('sound'))
                    {
                        $nameSound = Input::file('sound')->getClientOriginalExtension();
                        $oldSound = $bunpo->sound;
                        if($nameSound == 'mp3')
                        {
                            $soundURL = $id . "." . date("H_i_s",time()). "." . $nameSound;
                            if($oldSound != '')
                            {
                                if(File::exists(public_path('upload/audio/bunpo/') . $oldSound))
                                {
                                    unlink(public_path('upload/audio/bunpo/').$oldSound);   
                                }
                            }
                            Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                            $bunpoRepository->update(
                                [
                                "sound"          =>$soundURL,
                                ],
                                $id,
                                "bunpo_id"
                                );
                        }else
                        {
                            return redirect()->back()->withErrors("Vui lòng chọn đúng kiểu âm thanh")->withInput();
                        }
                    }
                    return redirect('bunpos');
                }
            }
            else
            {
                $validator = Validator::make(
                    $request->all(), 
                    [
                    'image'         =>'sometimes|max:4096',
                    'hiragana'      =>'sometimes|unique:m_bunpo,hiragana',
                    'katakana'      =>'sometimes|unique:m_bunpo,katakana',
                    'kanji'         =>'sometimes|max:100',
                    'meaning'       =>'required|max:100',
                    'sound'         =>'sometimes|max:4096',
                    ]
                    ,
                    [
                    'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                    'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                    'image.sometimes'       => 'Vui lòng chọn hình ảnh',
                    'hiragana.unique'       => 'Từ vựng đã tồn tại',
                    'katakana.unique'       => 'Từ vựng đã tồn tại',
                    'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                    'sound.sometimes'       => 'Vui lòng chọn âm thanh thích hợp',
                    'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                    'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                    'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                    ]
                    );
                if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
                {
                    $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
                {
                    $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
                {
                    $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                    return redirect()->back()->withErrors($validator)->withInput();    
                }
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                else
                {   
                    $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->get('hiragana');
                $katakana = $request->get('katakana');
                $kanji  = $request->get('kanji');
                $meaning  = $request->get('meaning');
                $soundURL = "";
                $bunpoRepository->update(
                    [
                    "is_type_practice"       =>$request->get('is_type_practice') ? 1 : 0,
                    "is_type_test"           =>$request->get('is_type_test') ? 1 : 0,
                    "is_n1"             =>$request->get('is_n1') ? 1 : 0,
                    "is_n2"             =>$request->get('is_n2') ? 1 : 0,
                    "is_n3"             =>$request->get('is_n3') ? 1 : 0,
                    "is_n4"             =>$request->get('is_n4') ? 1 : 0,
                    "is_n5"             =>$request->get('is_n5') ? 1 : 0,
                    "hiragana"          =>$request->get('hiragana'),
                    "katakana"          =>$request->get('katakana'),
                    "kanji"          =>$request->get('kanji'),
                    "meaning"        =>$request->get('meaning')
                    ],
                    $id,
                    "bunpo_id"
                    );
                    if (Input::hasfile('image'))
                    {
                        $nameImage = Input::file('image')->getClientOriginalExtension();
                        $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                        $oldImage = $bunpo->image;
                        if($oldImage != '')
                        {
                            if(File::exists(public_path('upload/image/bunpo/') . $oldImage))
                            {
                                unlink(public_path('upload/image/bunpo/') . $oldImage);   
                            } 
                        }
                        Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                        $bunpoRepository->update(
                            [
                            "image"          => $imageURL,
                            ],
                            $id,
                            "bunpo_id"
                            );   
                    }
                    if(Input::hasfile('sound'))
                    {
                        $nameSound = Input::file('sound')->getClientOriginalExtension();
                        $oldSound = $bunpo->sound;
                        if($nameSound == 'mp3')
                        {
                            $soundURL = $id . "." . date("H_i_s",time()). "." . $nameSound;
                            if($oldSound != '')
                            {
                                if(File::exists(public_path('upload/audio/bunpo/') . $oldSound))
                                {
                                    unlink(public_path('upload/audio/bunpo/').$oldSound);   
                                }
                            }
                            Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                            $bunpoRepository->update(
                                [
                                "sound"          =>$soundURL,
                                ],
                                $id,
                                "bunpo_id"
                                );
                        }else
                        {
                            return redirect()->back()->withErrors("Vui lòng chọn đúng kiểu âm thanh")->withInput();
                        }
                    }
                    return redirect('bunpos');
                }
            }

            $validator = Validator::make(
                $request->all(), 
                [
                'image'         =>'sometimes|max:4096',
                'hiragana'      =>'sometimes',
                'katakana'      =>'sometimes',
                'kanji'         =>'sometimes',
                'meaning'       =>'required|max:255',
                'sound'         =>'sometimes|max:4096',
                ]
                ,
                [
                'image.max'             => 'Hình ảnh chọn phải nhỏ hơn 4MB.',
                'image.uploaded'        => 'Vui lòng chọn đúng kiểu hình ảnh.',
                'image.sometimes'       => 'Vui lòng chọn hình ảnh',
                'meaning.required'      => 'Vui lòng nhập nghĩa tiếng việt',
                'sound.uploaded'        => 'Vui lòng chọn đúng kiểu âm thanh.',
                'sound.max'             => 'Âm thanh chọn phải nhỏ hơn 4MB',
                'sound.mimes'           => 'Vui lòng chọn đúng kiểu âm thanh.',
                ]
                );
            if(!$request->get('is_type_practice') && !$request->get('is_type_test') && !$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('error','Vui lòng chọn loại và trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_type_practice') && !$request->get('is_type_test'))
            {
                $validator->errors()->add('errorType','Vui lòng chọn loại cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if(!$request->get('is_n1') && !$request->get('is_n2') && !$request->get('is_n3') && !$request->get('is_n4') && !$request->get('is_n5'))
            {
                $validator->errors()->add('errorLevel','Vui lòng chọn trình độ cho từ vựng.');
                return redirect()->back()->withErrors($validator)->withInput();    
            }
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else
            {   
                $is_type_practice  = 0;
                $is_type_test   = 0;
                $is_n1 = 0;
                $is_n2 = 0;
                $is_n3 = 0;
                $is_n4 = 0;
                $is_n5 = 0;
                $imageURL = "";
                $hiragana = $request->get('hiragana');
                $katakana = $request->get('katakana');
                $kanji  = $request->get('kanji');
                $meaning  = $request->get('meaning');
                $soundURL = "";
                $bunpoRepository->update(
                    [
                    "is_type_practice"       =>$request->get('is_type_practice') ? 1 : 0,
                    "is_type_test"           =>$request->get('is_type_test') ? 1 : 0,
                    "is_n1"             =>$request->get('is_n1') ? 1 : 0,
                    "is_n2"             =>$request->get('is_n2') ? 1 : 0,
                    "is_n3"             =>$request->get('is_n3') ? 1 : 0,
                    "is_n4"             =>$request->get('is_n4') ? 1 : 0,
                    "is_n5"             =>$request->get('is_n5') ? 1 : 0,
                    "hiragana"          =>$request->get('hiragana'),
                    "katakana"          =>$request->get('katakana'),
                    "kanji"          =>$request->get('kanji'),
                    "meaning"        =>$request->get('meaning')
                    ],
                    $id,
                    "bunpo_id"
                    );
                if (Input::hasfile('image'))
                {
                    $nameImage = Input::file('image')->getClientOriginalExtension();
                    $imageURL = $id . "." . date("H_i_s",time()). ".". $nameImage;
                    $oldImage = $bunpo->image;
                    if($oldImage != '')
                    {
                        if(File::exists(public_path('upload/image/bunpo/') . $oldImage))
                        {
                            unlink(public_path('upload/image/bunpo/') . $oldImage);   
                        } 
                    }
                    Input::file('image')->move(public_path('upload/image/bunpo/'), $imageURL);
                    $bunpoRepository->update(
                        [
                        "image"          => $imageURL,
                        ],
                        $id,
                        "bunpo_id"
                        );   
                }
                if(Input::hasfile('sound'))
                {
                    $nameSound = Input::file('sound')->getClientOriginalExtension();
                    $oldSound = $bunpo->sound;
                    if($nameSound == 'mp3')
                    {
                        $soundURL = $id . "." . date("H_i_s",time()). "." . $nameSound;
                        if($oldSound != '')
                        {
                            if(File::exists(public_path('upload/audio/bunpo/') . $oldSound))
                            {
                                unlink(public_path('upload/audio/bunpo/').$oldSound);   
                            }
                        }
                        Input::file('sound')->move(public_path('upload/audio/bunpo'), $soundURL);
                        $bunpoRepository->update(
                            [
                            "sound"          =>$soundURL,
                            ],
                            $id,
                            "bunpo_id"
                            );
                    }else
                    {
                        return redirect()->back()->withErrors("Vui lòng chọn đúng kiểu âm thanh")->withInput();
                    }
                }
                return redirect('bunpos');
            }
        }
    }
    //detail a bunpo
    public function detailBunpo($id, BunpoRepository $bunpoRepository)
    {
        $validator = Validator::make(['bunpo_id' => $id], [
            'bunpo_id'   => 'exists:m_bunpo,bunpo_id'
            ], [
            'bunpo_id.require'   =>'Không tồn tại từ vựng',
            ]);
        if ($validator->fails())
        {
            return redirect()->back();
        }
        else
        {
            $bunpo = $bunpoRepository->find((int)$id);
            return view('Backend.bunpos.detail_bunpo', ['bunpo' => $bunpo]);  
        }
    }
    //destroy a bunpo
    public function destroyBunpo($id, BunpoRepository $bunpoRepository)
    {
        $bunpoRepository->update(
            [
            "deleted_flag"          => 1, 
            ],
            $id,
            "bunpo_id"
            );
        return redirect()->back();
    }
    //delete multi bunpo
    public function deleteall(Request $rq, BunpoRepository $bunpoRepository) 
    {
        $list_id = $rq->get('list_id');
        foreach ($list_id as $id) {
            $bunpoRepository->update(
                [
                "deleted_flag"          => 1,
                ],
                $id,
                "bunpo_id"
                );
        }
        return redirect()->back();
    }
}