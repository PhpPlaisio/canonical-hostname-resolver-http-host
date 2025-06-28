<?php
declare(strict_types=1);

namespace Plaisio\CanonicalHostnameResolver;

use Plaisio\Exception\BadRequestException;
use Plaisio\Kernel\Nub;
use SetBased\Exception\LogicException;

/**
 * A CanonicalHostnameResolver using HTTP HOST header.
 */
#[\AllowDynamicProperties]
class HttpHostCanonicalHostnameResolver implements CanonicalHostnameResolver
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the value of a property.
   *
   * Do not call this method directly as it is a PHP magic method that
   * will be implicitly called when executing `$value = $object->property;`.
   *
   * @param string $property The name of the property.
   *
   * @throws LogicException If the property is not defined.
   */
  public function __get(string $property): mixed
  {
    $getter = 'get'.$property;
    if (method_exists($this, $getter))
    {
      return $this->$property = $this->$getter();
    }

    throw new LogicException('Unknown property %s::%s', __CLASS__, $property);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the canonical hostname (a.k.a. preferred fully qualified domain name).
   */
  private function getCanonicalHostname(): string
  {
    $hostname = Nub::$nub->request->hostname;
    if ($hostname==='')
    {
      throw new BadRequestException('Unable to derive canonical hostname.');
    }

    // Remove port number, if any.
    $p = strpos($hostname, ':');
    if ($p!==false)
    {
      $hostname = substr($hostname, 0, $p);
    }

    $this->canonicalHostname = strtolower(trim($hostname));

    return $hostname;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
