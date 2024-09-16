<?php
namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\BlogRepositoryInterface;

class BlogRepository implements BlogRepositoryInterface {

    public function getList(){

        return Blog::all();

    }

    public function create($data){
        return [];
    }

    public function find($id){
        return $id;
    }


    public function update($id, array $data)
    {
        return $data;
    }

    public function delete($id)
    {
        return $id;
    }


}