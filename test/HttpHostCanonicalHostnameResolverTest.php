<?php
declare(strict_types=1);

namespace Plaisio\CanonicalHostnameResolver\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\CanonicalHostnameResolver\HttpHostCanonicalHostnameResolver;
use Plaisio\Exception\BadRequestException;

/**
 * Test cases for class HttpHostCanonicalHostnameResolver.
 */
class HttpHostCanonicalHostnameResolverTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Unsets $_SERVER['HTTP_HOST']. Note we set $_SERVER['HTTP_HOST'] after creating the resolver objects.
   */
  public function setUp(): void
  {
    parent::setUp();

    unset($_SERVER['HTTP_HOST']);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number.
   */
  public function testGetDomain1a(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.example.com';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number anf host name in upper case.
   */
  public function testGetDomain1b(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.EXAMPLE.COM';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with trailing and leading (does this happen?).
   */
  public function testGetDomain1c(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = " www.example.com\t\n\r";

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0'.
   */
  public function testGetDomain1d(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = '0';

    $this->assertSame('0', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0.0'.
   */
  public function testGetDomain1e(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = '0.0';

    $this->assertSame('0.0', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0.0.0'.
   */
  public function testGetDomain1f(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = '0.0.0';

    $this->assertSame('0.0.0', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with port number
   */
  public function testGetDomain2(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.example.com:8080';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without hostname.
   */
  public function testGetDomain3(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->expectException(BadRequestException::class);
    $resolver->getCanonicalHostname();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without hostname.
   */
  public function testGetDomain4a(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = null;

    $this->expectException(BadRequestException::class);
    $resolver->getCanonicalHostname();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without hostname.
   */
  public function testGetDomain4b(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = '';

    $this->expectException(BadRequestException::class);
    $resolver->getCanonicalHostname();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
