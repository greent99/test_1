<?php

namespace App\Admin\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Language extends Model
{
    protected $table="language";
    public static function getLanguageFull($paginate,$sort='DESC',$invisible=0)
    {
        return Language::select()
            ->where('invisible',$invisible)
            ->where('delete','!=',1)
            ->orderBy('sort',$sort)
            ->orderBy('created_at',$sort)
            ->orderBy('updated_at',$sort)
            ->paginate($paginate);
    }
    public static function getLanguageFullSearch($keysearch,$invisble)
    {

    }
    public static function updateLanguage($id,$data)
    {
        return Language::where('id',$id)->update(['name'=>$data['name'],'url'=>$data['url'],'icon'=>$data['icon'],'sort'=>$data['sort']
            ,'image'=>$data['image']]);
    }
    public static function getValueOfAttrById($id,$attr)
    {
        return DB::table('language')->where('id',$id)->value($attr);
    }
    public static function renderExcel($idArr,$attrArr)
    {
        //dd($idArr);
        // return Language::select()->whereIn('id',$idArr)->get();
        return Language::all();
    }
}
