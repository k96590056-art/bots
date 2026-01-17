<?php

namespace App\Admin\Repositories;

use App\Models\GameTag as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class GameTag extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}