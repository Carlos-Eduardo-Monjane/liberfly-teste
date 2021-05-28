<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class BookController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books=Book::all();
        $msg="All Books data Fetched Successfully";
        $code=200;
        ## passing parameters to Trait for generating response
        return $this->showall($msg,$books);
    }
 


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ## Validate the data
        try{
            $validator=Validator::make($request->all(),[
                'name' => 'required|max:100','author'=>'required|max:100',
                'publisher'=>'required|max:100','isbn'=>'required|integer'
                 ]);
           if ($validator->fails()) {
                    return response(['title'=>'Unable to create record','content'=>$validator->messages()->first()],500);
            }
        ## creating new record    
        $book=Book::Create( ['name'=>$request->name,
                'author'=>$request->author,
                'publisher'=>$request->publisher,
                'isbn'=>$request->isbn,
              ]);
        $msg="Book Created Successfully ";
        ## passing parameters to Trait for generating response
        return $this->successResponse(['message'=>$msg,'data'=>$book],200); 
   
    }catch(\Exception $e){
        
     return $this->errorResponse('Unable to add new book',500);
     }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book=Book::findorFail($id);
        $msg="Single Book Data";
        ## passing parameters to Trait for generating response
        return $this->showone($msg,$book);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
        $book=Book::findOrFail($id);
        $book->name = isset($request->name) ? $request->name : $book->name;
        $book->author =isset($request->author) ? $request->author : $book->author;
        $book->publisher =isset($request->publisher) ? $request->publisher : $book->publisher;
        $book->isbn = isset($request->isbn) ? $request->isbn : $book->isbn;
        $book->save();
        $msg="Book Updated Successfully ";
        
        return $this->successResponse(['message'=>$msg,'data'=>$book],200); 
      }catch(\Exception $e){
        ## passing parameters to Trait for generating response
        return $this->errorResponse('Unable to update book',500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $book=Book::findOrFail($id);
          $book->delete();
          $msg="Book Deleted Successfully ";
          ## passing parameters to Trait for generating response
          return $this->successResponse(['message'=>$msg,'data'=>$book],200);
        }catch(\Exception $e){
        
            return $this->errorResponse('Unable to del new book',500);
            } 
    }
}
