<?php

namespace App\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    /**
     * @return int|string|null
     */
    public function userField()
    {
        return parent::userField();
    }
}
