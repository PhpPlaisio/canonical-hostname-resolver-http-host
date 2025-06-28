<?php
declare(strict_types=1);

namespace Plaisio\CanonicalHostnameResolver\Test\Plaisio;

use Plaisio\PlaisioKernel;
use Plaisio\Request\CoreRequest;
use Plaisio\Request\Request;

/**
 * Mock framework for testing purposes.
 */
class TestKernel extends PlaisioKernel
{
  //--------------------------------------------------------------------------------------------------------------------
  protected function getRequest(): Request
  {
    return new CoreRequest($_SERVER, $_GET, $_POST, $_COOKIE, new TestRequestParameterResolver());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
