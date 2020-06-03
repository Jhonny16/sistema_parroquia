<?php
namespace Dompdf\Frame;

use Dompdf\Frame;
use IteratorAggregate;

/**
 * Linked-list IteratorAggregate
 *
 * @access private
 * @package dompdf1
 */
class FrameList implements IteratorAggregate
{
    /**
     * @var Frame
     */
    protected $_frame;

    /**
     * @param Frame $frame
     */
    function __construct($frame)
    {
        $this->_frame = $frame;
    }

    /**
     * @return FrameListIterator
     */
    function getIterator()
    {
        return new FrameListIterator($this->_frame);
    }
}
