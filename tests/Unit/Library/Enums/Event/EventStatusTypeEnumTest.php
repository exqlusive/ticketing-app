<?php

namespace Tests\Unit\Library\Enums\Event;

use App\Library\Enums\Event\EventStatusTypeEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EventStatusTypeEnumTest extends TestCase
{
    #[Test]
    public function test_display_name(): void
    {
        $this->assertEquals('Cancelled', EventStatusTypeEnum::CANCELLED->displayName());
        $this->assertEquals('Draft', EventStatusTypeEnum::DRAFT->displayName());
        $this->assertEquals('Postponed', EventStatusTypeEnum::POSTPONED->displayName());
        $this->assertEquals('Published', EventStatusTypeEnum::PUBLISHED->displayName());
        $this->assertEquals('Rescheduled', EventStatusTypeEnum::RESCHEDULED->displayName());
        $this->assertEquals('Sold Out', EventStatusTypeEnum::SOLD_OUT->displayName());
    }

    #[Test]
    public function test_is_active(): void
    {
        $this->assertFalse(EventStatusTypeEnum::CANCELLED->isActive());
        $this->assertFalse(EventStatusTypeEnum::DRAFT->isActive());
        $this->assertFalse(EventStatusTypeEnum::POSTPONED->isActive());
        $this->assertFalse(EventStatusTypeEnum::RESCHEDULED->isActive());
        $this->assertTrue(EventStatusTypeEnum::PUBLISHED->isActive());
        $this->assertTrue(EventStatusTypeEnum::SOLD_OUT->isActive());
    }

    #[Test]
    public function test_active_statuses(): void
    {
        $expected = [
            EventStatusTypeEnum::PUBLISHED->value,
            EventStatusTypeEnum::SOLD_OUT->value,
        ];

        $this->assertEquals($expected, EventStatusTypeEnum::activeStatuses());
    }
}
