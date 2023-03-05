<?php

namespace App\Service;

use App\Models\Author;

class AuthorService extends BaseService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Author();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
