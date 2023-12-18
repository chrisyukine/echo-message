<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\MessageFetch\FetchWorker\ToutiaoDiffMessageDailyWorker;

class PushHandleTest extends TestCase
{
    public function testDailyDiff()
    {
        $cls = new ToutiaoDiffMessageDailyWorker();
        dump($cls->handle());
    }
}
