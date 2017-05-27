<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\CanonicalHostnameResolver;

use SetBased\Exception\RuntimeException;

//----------------------------------------------------------------------------------------------------------------------
/**
 * A CanonicalHostnameResolver using $_SERVER['HTTP_HOST'].
 */
class HttpHostCanonicalHostnameResolver implements CanonicalHostnameResolver
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The canonical host name.
   *
   * @var string|null
   */
  private $canonicalHostname;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the canonical hostname (a.k.a. preferred fully qualified domain name).
   *
   * @return string
   *
   * @api
   * @since 1.0.0
   */
  public function getCanonicalHostname()
  {
    if ($this->canonicalHostname===null)
    {
      $this->setCanonicalHostname();
    }

    return $this->canonicalHostname;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Derives the canonical host name.
   */
  private function setCanonicalHostname()
  {
    if (!isset($_SERVER['HTTP_HOST']))
    {
      throw new RuntimeException("Unable to derive canonical hostname");
    }

    $hostname = $_SERVER['HTTP_HOST'];

    // Remove port number, if any.
    $p = strpos($hostname, ':');
    if ($p!==false) $hostname = substr($hostname, 0, $p);

    $this->canonicalHostname = strtolower(trim($hostname));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
