<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Article;

class ArticleController extends Controller
{
	 public function index()
	{
		$data= Article::orderBy('id','desc')->paginate(5);
			return view('articles.index',
				["articles"=>$data]);
	}
	public function detail($id){
		$data= Article::find($id);
		return view('articles.detail',[
			'article'=>$data
		]
	);
	}
	public function add(){
		$data=[
		       ["id"=>1, "name"=>"News"], 
		       ["id"=>2, "name"=>"Tech"], ];
		return view('articles.add',[
			'categories'=>$data]);       
	}
	public function create(){
		$validator=validator(request()->all(),[
			'title'=>'required',
			'body'=>'required',
			'category_id'=>'required',
		]);
		if ($validator->fails()){
			return back()->withErrors($validator);
		}
		$articles=new Article;
		$articles->title=request()->title;
		$articles->body=request()->body;
		$articles->category_id=request()->category_id;
		$articles->save();
		return redirect('/articles');
	}
	public function delete($id){
		$article=Article::find($id);
		if(Gate::allows('article-delete',$article)){
			$article->delete();
		return redirect('/articles')->with('info','Article deleted');
		}else{
		return back()->with('error',"Unauthorize to delete");
		}
	
	}
		

    public function _construct(){
    	$this->middleware('auth')->except(['index','detail']);
    }
}
 