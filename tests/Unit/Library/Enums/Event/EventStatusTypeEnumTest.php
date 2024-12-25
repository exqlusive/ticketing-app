<?php

namespace Tests\Unit\Library\Enums\Event;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use App\Library\Enums\Event\EventStatusTypeEnum;

class EventStatusTypeEnumTest extends TestCase
{
    #[Test]
    public function testDisplayName(): void
    {
        $this->assertEquals('Cancelled', EventStatusTypeEnum::CANCELLED->displayName());
        $this->assertEquals('Draft', EventStatusTypeEnum::DRAFT->displayName());
        $this->assertEquals('Postponed', EventStatusTypeEnum::POSTPONED->displayName());
        $this->assertEquals('Published', EventStatusTypeEnum::PUBLISHED->displayName());
        $this->assertEquals('Rescheduled', EventStatusTypeEnum::RESCHEDULED->displayName());
        $this->assertEquals('Sold Out', EventStatusTypeEnum::SOLD_OUT->displayName());
    }

    #[Test]
    public function testIsActive(): void
    {
        $this->assertFalse(EventStatusTypeEnum::CANCELLED->isActive());
        $this->assertFalse(EventStatusTypeEnum::DRAFT->isActive());
        $this->assertFalse(EventStatusTypeEnum::POSTPONED->isActive());
        $this->assertFalse(EventStatusTypeEnum::RESCHEDULED->isActive());
        $this->assertTrue(EventStatusTypeEnum::PUBLISHED->isActive());
        $this->assertTrue(EventStatusTypeEnum::SOLD_OUT->isActive());
    }

    #[Test]
    public function testActiveStatuses(): void
    {
        $expected = [
            EventStatusTypeEnum::PUBLISHED->value,
            EventStatusTypeEnum::SOLD_OUT->value,
        ];

        $this->assertEquals($expected, EventStatusTypeEnum::activeStatuses());
    }
}
