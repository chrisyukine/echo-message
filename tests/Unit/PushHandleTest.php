<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\MessageFetch\FetchWorker\DailyDiffMessageWorker;

class PushHandleTest extends TestCase
{
    public function testDailyDiff()
    {
        $cls = new DailyDiffMessageWorker();
        dump($cls->handle());
    }
}
