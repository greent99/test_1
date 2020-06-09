<?php

namespace App\Admin\Controllers\admin;

use App\Admin\Model\admin\Language;
use App\Admin\Model\admin\Setting;
use App\Admin\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class LanguageController extends Controller implements FromCollection,WithHeadings
{
    //common element
    use Exportable;
    private function deleteAll()
    {
        return Setting::getValueUrl('deleteall')->value;
    }
    private function path()
    {
        return Setting::getValueUrl('pathlanguage')->value;
    }

    private function Rroot()
    {
        return Setting::getValueUrl('root')->value;
    }

    private function Rpaginate()
    {
        return Setting::getValueUrl('paginate')->value;
    }

    //end common element
    public function Index(Request $request)
    {
        if(checkRight($request,Auth::user()))
        {
            $data =Language::getLanguageFull($this->Rpaginate());
            return view('admin/pages/languages/index',['data'=>$data]);
        }
    }
    public function getAdd(Request $request)
    {
        if(checkRight($request,Auth::user())) {
            return view('admin/pages/languages/add');
        }
    }
    public function postAdd(Request $request)
    {
        if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot()){
            $validator = $this->validator($request->all());
            if(!$validator->fails())
            {
                $filename = changeTitle($request->name);
                $language = new Language();
                $language->name = $request->name;
                $language->url = $request->url;
                $language->icon = $request->icon;
                $language->sort = $request->sort;
                if ($request->hasFile('image'))
                {

                    $check = upload_image($this->path(), $request->file('image'), $filename);
                    if ($check == false)
                    {
                        return view('admin.pages.languages.add',['data'=>$validator->getdata(),'message'=>Lang::get('en.er_notupload').' '.Lang::get('en.pt_image'),'status'=>false]);
                    }
                    $language->image = $check;
                }
                if($language->save())
                {
                    return redirect(route('add_language'));
                }
            }

            return view('admin.pages.languages.add',['data'=>$validator->getdata()])->with('error',$validator->getMessageBag());
        }
    }

    public function getUpdate(Request $request,$id)
    {
        if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot())
        {
            $language = Language::find($id);
            if(!isset($language))
            {
               return redirect(route('language'))->with(['flag'=>true,'message'=>Lang::get('en.er_notexist').' '.Lang::get('en.tb_id')]);
            }
            $id = $request->id;
            return view('admin/pages/languages/update', ['data' => $language]);
        }
    }

    public function postUpdate(Request $request,$id)
    {
        if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot())
        {
            $image='';
            $data = Language::find($id);
            if(isset($data))
            {
                $validator = $this->validator($request->all());
                if(!$validator->fails())
                {
                    $filename = changeTitle($request->name);
                    if ($request->hasFile('image'))
                    {
                        $check = upload_image($this->path(), $request->file('image'), $filename);
                        if (!$check)
                        {
                            return view('admin.pages.languages.update',['data'=>$validator->getdata(),'message'=>Lang::get('en.er_notupload').' '.Lang::get('en.pt_image'),'status'=>false]);
                        }
                        if(deleteImage('public',$data->image))
                        {
                            $image = $check;
                        }
                    }
                    else
                    {
                        $image=$data->image;
                    }
                    $data=array(
                        'name'=>$request->name,
                        'url'=>$request->url,
                        'icon'=>$request->icon,
                        'sort'=>$request->sort,
                        'image'=>$image
                    );
                    $checkUpdate = Language::updateLanguage($id,$data);
                    if($checkUpdate)
                    {
                        return redirect(route('language'));
                    }
                }
                return view('admin.pages.languages.add',['data'=>$validator->getdata()])->with('error',$validator->getMessageBag());
            }
        }
    }


    public function getDelete(Request $request,$id)
    {
        if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot())
        {

        }
    }

    public function postDelete(Request $request)
    {
        //check ajax request
        if ($request->ajax())
        {
            $data = $request->data;
            $idArr = $data['idArr'];
            //check quyen
            if (checkRight($request, Auth::user()) || Auth::user()->root == $this->Rroot())
            {
                //xoa mang cac phan tu
                foreach ($idArr as $id)
                {
                    if (!$this->deleteOneObj($id, $this->deleteAll())) {
                        return json_encode(['data' => null, 'status' => false, 'message' => Lang::get('en.pt_unsuccess')]);
                    }
                }
                return json_encode(['data'=>'oke']);
                return json_encode(['data' => $idArr, 'status' => true, 'message' => Lang::get('en.pt_success')]);
            }
            else
                return false;
        }

    }

    public function getRenderImport(Request $request,$type)
    {

    }

    public function postRenderImport(Request $request,$type)
    {

    }

    public function getRenderExport(Request $request)
    {
        if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot())
        {
            $attrArr = $request->attrarr;
            $type = $request->type;
            $idArr =$request->idarr;
            if($type == 'excel')
            {
                $controller = new LanguageController();
                $currentDate = date("d.m.Y");
                $filename = 'language_'.$currentDate.'.xlsx';
                return ($controller)->download($filename);
            }
        }

    }

    public function postRenderExport(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->data;
            $attrArr = $data['attrArr'];
            $type = $data['type'];
            $idArr = $data['rowArr'];
            return json_encode(['idArr'=>$idArr,'attrArr'=>$attrArr]);
            if(checkRight($request,Auth::user()) || Auth::user()->root==$this->Rroot())
            {
                if($type == 'excel')
                {
                    $controller = new LanguageController();
                    $currentDate = date("d.m.Y");
                    $filename = 'language_'.$currentDate.'.xls';
                    $controller->download($filename);
                    return json_encode($request->data['attrArr']);
                }
            }
        }

    }

    private function deleteOneObj($id,$status=0)
    {
        $data= Language::find($id);
        if(!isset($data))
        {
            return false;
        }
        if($status==1)
        {
            $data->delete=1;
            $data->save();
            return true;
        }
        else
        {
            if(isset($data->image)) {
               return json_encode(['data'=>'oke']);
                if (deleteImage('public', $data->image)) {
                    $data->delete();
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $data->delete();
                return true;
            }
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'name'=>'required|min:3|max:100',
                'url'=>'required|max:50',
            ],
            [
                'name.required'=>Lang::get('en.pt_name').' '.Lang::get('en.er_required'),
                'name.min'=>Lang::get('en.pt_name').' '.Lang::get('en.er_min').' 3 '.Lang::get('en.pt_character'),
                'name.max'=>Lang::get('en.pt_name').' '.Lang::get('en.er_max').' 100 '.Lang::get('en.pt_character'),
                'url.required'=>Lang::get('en.pt_url').' '.Lang::get('en.er_required'),
                'url.max'=>Lang::get('en.pt_url').' '.Lang::get('en.er_max').' 50 '.Lang::get('en.pt_character'),
            ]);
    }

    public function collection()
    {
//        $data = Language::renderExcel(null,null);
//        dd($data);
//        $attrArr = $_REQUEST['attrarr'];
//        $idArr = $_REQUEST['idarr'];
        $data = Language::all();
        foreach ($data as $language)
        {
            $arr[] = array(
                '0' => $language->id,
                '1' => $language->name,
            );
        }
        return (collect($arr));

    }
    public function headings(): array
    {
       // return $_REQUEST['attrarr'];
        return [
            'id',
            'Name',
        ];
    }
}
