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
     * @OA\Get(
     *    path="/books",
     *    operationId="index",
     *    tags={"Books"},
     *    summary="Get list of Books",
     *    description="Get list of Books",
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
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
     * @OA\Post(
     *      path="/books",
     *      operationId="store",
     *      tags={"Books"},
     *      summary="Store Book in DB",
     *      description="Store Book in DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name", "author", "isbn"},
     *            @OA\Property(property="name", type="string", format="string", example="Luzes da Noite"),
     *            @OA\Property(property="author", type="string", format="string", example="Camoes"),
     *            @OA\Property(property="publisher", type="string", format="string", example="Editora Plus"),
     *            @OA\Property(property="isbn", type="string", format="string", example="234617I53"),
     * 
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
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
     * @OA\Get(
     *    path="/books/{id}",
     *    operationId="show",
     *    tags={"Books"},
     *    summary="Get Book Detail",
     *    description="Get Book Detail",
     *    @OA\Parameter(name="id", in="path", description="Id of Book", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="status_code", type="integer", example="200"),
     *          @OA\Property(property="data",type="object")
     *           ),
     *        )
     *       )
     *  )
     */
    public function show($id)
    {
        $book=Book::findorFail($id);
        $msg="Single Book Data";
        ## passing parameters to Trait for generating response
        return $this->showone($msg,$book);
    
    }

    /**
     * @OA\Put(
     *     path="/books/{id}",
     *     operationId="update",
     *     tags={"Books"},
     *     summary="Update book in DB",
     *     description="Update Book in DB",
     *     @OA\Parameter(name="id", in="path", description="Id of Book", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           required={"name", "author", "isbn"},
     *            @OA\Property(property="name", type="string", format="string", example="Luzes da Noite"),
     *            @OA\Property(property="author", type="string", format="string", example="Camoes"),
     *            @OA\Property(property="publisher", type="string", format="string", example="Editora Plus"),
     *            @OA\Property(property="isbn", type="string", format="string", example="234617I53"),
     * 
     *        ),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status_code", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
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
     * @OA\Delete(
     *    path="/books/{id}",
     *    operationId="destroy",
     *    tags={"Books"},
     *    summary="Delete Book",
     *    description="Delete Book",
     *    @OA\Parameter(name="id", in="path", description="Id of Book", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status_code", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       )
     *      )
     *  )
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
