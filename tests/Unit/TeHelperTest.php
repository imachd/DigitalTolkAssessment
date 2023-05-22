<?php

namespace Tests\Unit\Helpers;

use DTApi\Helpers\TeHelper;
use Carbon\Carbon;

class TeHelperTest extends TestCase
{
    /**
     * @test
     */
    public function due_time_if_the_difference_is_less_than_90_hours()
    {
        $dueTime = Carbon::now()->addHours(89);
        $createdAt = Carbon::now();

        $expected = $dueTime;
        $actual = TeHelper::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function created_at_with_90_minutes_added_if_the_difference_is_less_than_24_hours()
    {
        $dueTime = Carbon::now()->addHours(23);
        $createdAt = Carbon::now();

        $expected = Carbon::now()->addMinutes(90);
        $actual = TeHelper::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function created_at_with_16_hours_added_if_the_difference_is_between_24_and_72_hours()
    {
        $dueTime = Carbon::now()->addHours(71);
        $createdAt = Carbon::now();

        $expected = Carbon::now()->addHours(16);
        $actual = TeHelper::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function due_time_with_48_hours_subtracted_if_the_difference_is_greater_than_72_hours()
    {
        $dueTime = Carbon::now()->addHours(73);
        $createdAt = Carbon::now();

        $expected = Carbon::now()->subHours(48);
        $actual = TeHelper::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($expected, $actual);
    }
}
