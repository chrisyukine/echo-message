<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\MessageFetch\FetchWorker\ToutiaoDiffMessageWorker;

class PushHandleTest extends TestCase
{
    public function testDailyDiff()
    {
        $cls = new ToutiaoDiffMessageWorker();
        dump($cls->handle());
    }
}
