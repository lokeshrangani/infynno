<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        if(session()->has('userId')){
            return view('blog');
        }else{
            return view('welcome');
        }
    }

    public function store(Request $request)
    {
        if(session()->has('userId')){
            $data=array();
            if($request->hasFile('blogimage')){
                $filenameWithExt = $request->file('blogimage')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('blogimage')->getClientOriginalExtension();
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                $allowedfileExtension=['jpeg','jpg','png'];
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $request->file('blogimage')->storeAs('public/image', $fileNameToStore);
                    $responseBlog = Blog::storeBlog($request, $fileNameToStore);
                }else{
                    $data['status']=false;
                    $data['msg']="File Type not Allowed";
                    return response()->json($data);
                }
            } else {
                if($request->id != null){
                    $imageUrl = Blog::where('id',$request->id)->first(['image']);
                    $responseBlog = Blog::storeBlog($request,$imageUrl->image);
                }else{
                    $responseBlog = Blog::storeBlog($request);
                }
            }
            return response()->json($responseBlog);
        }else{
            return redirect()->route('index');
        }    
    }

    public function list()
    {
        $blogList = Blog::getAllBlogs();
        $finalDataArr['data'] = $blogList;
        $finalDataArr['status'] = true;
        if(count($blogList) > 0) {
            $finalDataArr['data'] = $blogList;
        } else {
            $finalDataArr['data'] = null;
        }
        return response()->json($finalDataArr);
    }
    public function show($id)
    {
        $blogDetails = Blog::getBlogDetails($id);
        $finalDataArr['data'] = $blogDetails;
        $finalDataArr['status'] = true;
        return response()->json($finalDataArr);
    }
    
    public function destroy($id)
    {
        $deleteDetails = Blog::deleteBlogDetails($id);
        $finalDataArr['data'] = $deleteDetails;
        $finalDataArr['status'] = true;
        return response()->json($finalDataArr);
    }
}
