<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'description',
        'expirydate',
        'image',
        'type',
        'createby'
    ];
    public static function storeBlog($request, $fileName = '') {
        if(!$request->id) {
            self::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'expirydate'=>$request->expirydate,
                'type'=>$request->type,
                'image'=>$fileName,
                'createby' =>session()->get('userId')
            ]);
            $data['status']=true;
            $data['msg']="Blog Create Success";
        } else {
            self::where('id',$request->id)->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'expirydate'=>$request->expirydate,
                'type'=>$request->type,
                'image'=>$fileName,
            ]);
            $data['status']=true;
            $data['msg']="Blog Updated Success";
        }
        return $data;
    }
    public static function getAllBlogs() {
        $blogList = Blog::where('createby',session()->get('userId'))->where('expirydate', '>=', date('Y-m-d'))->orWhere('expirydate',null)->get();
        return $blogList;
    }
    
    public static function getBlogDetails($id) {
        $blogDetails = Blog::where('id', $id)->first();
        return $blogDetails;
    }
    public static function deleteBlogDetails($id) {
        $deleteDetails = Blog::where('id', $id)->delete();
        return $deleteDetails;
    }
}
