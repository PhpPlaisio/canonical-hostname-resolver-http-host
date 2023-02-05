<?php
declare(strict_types=1);

namespace Plaisio\CanonicalHostnameResolver;

use Plaisio\Exception\BadRequestException;

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
  private ?string $canonicalHostname = null;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the canonical hostname (a.k.a. preferred fully qualified domain name).
   *
   * @return string
   *
   * @api
   * @since 1.0.0
   */
  public function getCanonicalHostname(): string
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
  private function setCanonicalHostname(): void
  {
    $hostname = $_SERVER['HTTP_HOST'] ?? '';

    // XXX hosts name toevoegen aan request
    // $this->nub->request->getHostname();
    if ($hostname==='')
    {
      throw new BadRequestException('Unable to derive canonical hostname');
    }

    // Remove port number, if any.
    $p = strpos($hostname, ':');
    if ($p!==false)
    {
      $hostname = substr($hostname, 0, $p);
    }

    $this->canonicalHostname = strtolower(trim($hostname));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
