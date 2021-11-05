<?php

namespace App\Repositories;
use App\Models\MTestMondai;
use App\Repositories\BaseRepository;

class TestMondaiRepository extends BaseRepository
{

    /**
     * Create a new TestMondaiRepository instance.
     *
     * @param  App\Models\MTestMondai $mMTestMondai
     * @return void
     */
    public function __construct(
        MTestMondai $mMTestMondai
    ) 
    {
        $this->model = $mMTestMondai;
    }

}