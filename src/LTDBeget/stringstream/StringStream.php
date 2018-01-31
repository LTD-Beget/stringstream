<?php
/**
 * @author: Viskov Sergey
 * @date: 3/18/16
 * @time: 1:15 PM
 */

namespace LTDBeget\stringstream;


use LTDBeget\ascii\AsciiChar;

/**
 * String stream data structure
 * Class StringStream
 * @package LTDBeget\stringstream
 */
class StringStream
{
    /**
     * StringStream constructor.
     * @param string $string
     * @throws \BadMethodCallException
     */
    public function __construct(string $string)
    {
        $this->stream = new \ArrayIterator(preg_split('#(?<!^)(?!$)#u', $string));
        $this->pointerAtStart = true;
        $this->pointerAtEnd = false;
    }

    /**
     * Current char of stream
     * @return string
     */
    public function current() : string
    {
        return current($this->stream);
    }

    /**
     * @return int
     */
    public function ord() : int
    {
        return ord($this->current());
    }

    /**
     * Current char of stream as AsciiChar
     * @return AsciiChar
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function currentAscii() : AsciiChar
    {
        return AsciiChar::get($this->ord());
    }

    /**
     * Position in stream of current char
     * @return int
     */
    public function position() : int
    {
        return key($this->stream);
    }

    /**
     * go to next char in stream
     */
    public function next()
    {
        $this->pointerAtStart = false;
        $this->pointerAtEnd = next($this->stream) === false;
    }

    /**
     * go to previous char of stream
     */
    public function previous()
    {
        $this->pointerAtEnd = false;
        $this->pointerAtStart = prev($this->stream) === false;
    }

    /**
     * go to start of stream
     */
    public function start()
    {
        reset($this->stream);
    }

    /**
     * is start of stream
     * @return bool
     */
    public function isStart() : bool
    {
        return $this->pointerAtStart;
    }

    /**
     * go to end of stream
     */
    public function end()
    {
        end($this->stream);
    }

    /**
     * is end of stream
     * @return bool
     */
    public function isEnd() : bool
    {
        return $this->pointerAtEnd;
    }

    /**
     * ignore chars in stream while it is white space
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function ignoreWhitespace()
    {
        ignoreWhitespace:
        if (! $this->isEnd() && $this->currentAscii()->isWhiteSpace()) {
            $this->next();
            goto ignoreWhitespace;
        }
    }

    /**
     * ignore chars in stream while it is horizontal space
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function ignoreHorizontalSpace()
    {
        ignoreHorizontalSpace:
        if (!$this->isEnd() && $this->currentAscii()->isHorizontalSpace()) {
            $this->next();
            goto ignoreHorizontalSpace;
        }
    }

    /**
     * ignore chars in stream while it is vertical space
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function ignoreVerticalSpace()
    {
        ignoreHorizontalSpace:
        if (! $this->isEnd() && $this->currentAscii()->isVerticalSpace()) {
            $this->next();
            goto ignoreHorizontalSpace;
        }
    }

    /**
     * @var array
     */
    private $stream;

    /**
     * if next returns false it member will be true, else false
     * @var bool
     */
    private $pointerAtEnd;

    /**
     * if prev returns false it member will be true, else false
     * @var bool
     */
    private $pointerAtStart;
}
