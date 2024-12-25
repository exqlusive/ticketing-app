<?php

namespace Tests\Unit\Library\Enums;

use App\Library\Enums\BaseEnumTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Dummy enum to test BaseEnumTrait.
 */
enum DummyEnum: string
{
    use BaseEnumTrait;

    case FIRST = 'first';
    case SECOND = 'second';
    case THIRD = 'third';
}

class BaseEnumTraitTest extends TestCase
{
    #[Test]
    public function testValues(): void
    {
        $expectedValues = ['first', 'second', 'third'];

        $this->assertEquals($expectedValues, DummyEnum::values());
    }

    #[Test]
    public function testNames(): void
    {
        $expectedNames = ['FIRST', 'SECOND', 'THIRD'];

        $this->assertEquals($expectedNames, DummyEnum::names());
    }
}
