<?php

/**
 * This file is part of BillingTrack.
 *
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BT\Support\PDF;

abstract class PDFAbstract implements PDFInterface
{
    protected $paperSize;

    protected $paperOrientation;

    public function __construct()
    {
        $this->paperSize = config('fi.paperSize') ?: 'letter';
        $this->paperOrientation = config('fi.paperOrientation') ?: 'portrait';
    }

    public function setPaperSize($paperSize)
    {
        $this->paperSize = $paperSize;
    }

    public function setPaperOrientation($paperOrientation)
    {
        $this->paperOrientation = $paperOrientation;
    }
}
