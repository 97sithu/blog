<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
   public function create()
   {
   	$comment=new Comment;
   	$comment->content=request()->content;
   	$comment->article_id=request()->article_id;
      $comment->user_id=request()->user_id;
   	$comment->save();
   	return back();
   }
   public function delete($id){
   	$comment=Comment::find($id);
      if(Gate::allows('comment-delete',$comment)){
         $comment->delete();
      return redirect('/comment')->with('info','A comment deleted');
      }
   	return back()->with('error','unauthorize to  delete');
   }
   public function _construct(){
      $this->middleware('auth')->except(['index','detail']);
    }
}
