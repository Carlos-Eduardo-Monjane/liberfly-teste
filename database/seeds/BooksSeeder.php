<?php

use Illuminate\Database\Seeder;
use App\Book;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::where('id','>',1)->delete();    
    
        $data=[
            ['name'=>'Book 1','author'=>'sample author','publisher'=>'sample publisher','isbn'=>123456],
            ['name'=>'Book 2','author'=>'sample author 2','publisher'=>'sample publisher 2','isbn'=>678910],
           

        ];


        foreach($data as $key=>$value){
      
            $var=new Book;
            $var->name=$value['name'];
            $var->author=$value['author'];
            $var->publisher=$value['publisher'];
            $var->isbn=$value['isbn'];
            $var->save();

        }

    }
}
