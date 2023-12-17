<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\BlogCategory;
use App\models\eCommerce\BlogComment;
use App\models\eCommerce\BlogPost;
use App\models\eCommerce\PageBanner;

class BlogController extends Controller
{
    public function index()
    {
        $banner = PageBanner::where('page_name', 'blog')->first();
        $posts = BlogPost::where('status','Active')->orderBy('id', 'desc')->paginate(5);
        // dd($posts);
        return view('eCommerce.blog',compact('posts', 'banner'));
        
    }


    public function post_details($id)
    {
        $model = BlogPost::where('post_slug', $id)->first();
        return view('eCommerce.blog-details', compact('model'));
        
    }
    public function category_details($id)
    {
        $banner = PageBanner::where('page_name', 'blog')->first();
        $cate = BlogCategory::where('category_slug', $id)->first();
        $posts = BlogPost::where('status', 'Active')->where('blog_category_id',$cate->id)->orderBy('id', 'desc')->paginate(5);
        // dd($posts);
        return view('eCommerce.blog', compact('posts', 'banner'));
        
    }

    // submit-blog-comment
    public function submit_blog_comment(Request $request) {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'email|required|min:3|max:50',
            'phone' => 'numeric|required',
            'message' => 'required|min:3',
            'id' => 'required'
        ]);

        $model = new BlogComment;
        $model->blog_id = $request->id;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->message = $request->message;
        $model->status = 1;
        $model->save();

        return response()->json(['success' => true, 'load' => true, 'status' => 'success', 'message' => _lang('Your Comment is Successfully Submitted. Thanks!')]);
    }
}
