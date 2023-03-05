<?php

namespace App\Service;

interface ServiceInterface
{
    public function all();

    public function get_model_name();

    public function create();

    public function edit();

    public function update();

    public function delete();


}
