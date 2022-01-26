<?php

namespace LTDBeget\stringstream\test;

use LTDBeget\stringstream\StringStream;
use PHPUnit\Framework\TestCase;

class StringStreamTest extends TestCase
{
    public function testEmpty(): void
    {
        $stream = new StringStream('');

        $this->assertSame('', $stream->current());
        $this->assertSame(0, $stream->position());
        $this->assertTrue($stream->isStart());
        $this->assertTrue($stream->isEnd());

        $stream->next();
        $this->assertTrue($stream->isStart());
        $this->assertTrue($stream->isEnd());

        $stream->previous();
        $this->assertTrue($stream->isStart());
        $this->assertTrue($stream->isEnd());
    }

    /**
     * @dataProvider provideIterateData
     */
    public function testIterate(string $string, array $expected): void
    {
        $stream = new StringStream($string);

        $iterated = [];

        while (!$stream->isEnd()) {
            $iterated[] = $stream->current();

            $stream->next();
        }

        $this->assertSame($expected, $iterated);
    }

    /**
     * @dataProvider provideIterateData
     */
    public function testReverse(string $string, array $expected): void
    {
        $stream = new StringStream($string);
        $stream->end();

        $reversed = [];

        while (!$stream->isStart()) {
            $stream->previous();

            $reversed[] = $stream->current();
        }

        $this->assertSame(array_reverse($expected), $reversed);
    }

    public function provideIterateData(): array
    {
        return [
            ['', []],
            ['hey', ['h', 'e', 'y']],
            ['🚀⭐', ['🚀', '⭐']]
        ];
    }

    public function testIgnoreWhitespace(): void
    {
        $stream = new StringStream("   \t \n data");
        $stream->ignoreWhitespace();

        $this->assertSame('d', $stream->current());
    }

    public function testIgnoreHorizontalSpace(): void
    {
        $stream = new StringStream("   \t data");
        $stream->ignoreHorizontalSpace();

        $this->assertSame('d', $stream->current());
    }

    public function testIgnoreVerticalSpace(): void
    {
        $stream = new StringStream("\n\ndata");
        $stream->ignoreVerticalSpace();

        $this->assertSame('d', $stream->current());
    }

    public function testStartEnd(): void
    {
        $stream = new StringStream('hi');

        $this->assertSame('h', $stream->current());
        $this->assertSame(0, $stream->position());
        $stream->last();
        $this->assertSame('i', $stream->current());
        $this->assertSame(1, $stream->position());
        $stream->start();
        $this->assertSame('h', $stream->current());
        $this->assertSame(0, $stream->position());

        $stream->previous();
        $this->assertSame('h', $stream->current());
        $this->assertSame(0, $stream->position());
    }
}
