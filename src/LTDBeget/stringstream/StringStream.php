<?php
/**
 * @author: Viskov Sergey
 * @date  : 3/18/16
 * @time  : 1:15 PM
 */

namespace LTDBeget\stringstream;

use LTDBeget\ascii\AsciiChar;

/**
 * String stream data structure
 * Class StringStream
 *
 * @package LTDBeget\stringstream
 */
class StringStream
{
    private array $stream;
    private int $position;
    private int $length;

    /**
     * StringStream constructor.
     */
    public function __construct(string $string)
    {
        $this->stream = $this->splitString($string);
        $this->length = count($this->stream);
        $this->position = 0;
    }

    /**
     * Current char of stream or empty string if end is reached
     */
    public function current(): string
    {
        return $this->stream[$this->position] ?? '';
    }

    /**
     * ASCII code of current char
     */
    public function ord(): int
    {
        $current = $this->current();

        return $current === '' ? 0 : ord($current);
    }

    /**
     * Current char of stream as AsciiChar
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function currentAscii(): AsciiChar
    {
        return AsciiChar::get($this->ord());
    }

    /**
     * Position in stream of current char
     */
    public function position(): int
    {
        return $this->position;
    }

    /**
     * Go to next char in stream
     */
    public function next(): void
    {
        $this->position = min($this->length, $this->position + 1);
    }

    /**
     * Go to previous char of stream
     */
    public function previous(): void
    {
        $this->position = max(0, $this->position - 1);
    }

    /**
     * Go to start of stream
     */
    public function start(): void
    {
        $this->position = 0;
    }

    /**
     * Is start of stream
     */
    public function isStart(): bool
    {
        return $this->position === 0;
    }

    /**
     * Go to last character in stream
     */
    public function last(): void
    {
        $this->position = max(0, $this->length - 1);
    }

    /**
     * Go to position past last character in stream
     */
    public function end(): void
    {
        $this->position = $this->length;
    }

    /**
     * Is end of stream
     */
    public function isEnd(): bool
    {
        return $this->position === $this->length;
    }

    /**
     * Ignore chars in stream while it is white space
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function ignoreWhitespace(): void
    {
        while (!$this->isEnd() && $this->currentAscii()->isWhiteSpace()) {
            $this->next();
        }
    }

    /**
     * Ignore chars in stream while it is horizontal space
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function ignoreHorizontalSpace(): void
    {
        while (!$this->isEnd() && $this->currentAscii()->isHorizontalSpace()) {
            $this->next();
        }
    }

    /**
     * Ignore chars in stream while it is vertical space
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function ignoreVerticalSpace(): void
    {
        while (!$this->isEnd() && $this->currentAscii()->isVerticalSpace()) {
            $this->next();
        }
    }

    private function splitString(string $string): array
    {
        if ($string === '') {
            return [];
        }

        return (array)(preg_split('#(?<!^)(?!$)#u', $string));
    }
}
