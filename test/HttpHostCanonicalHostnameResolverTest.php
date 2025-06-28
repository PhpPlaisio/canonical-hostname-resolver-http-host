<?php
declare(strict_types=1);

namespace Plaisio\CanonicalHostnameResolver\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\CanonicalHostnameResolver\HttpHostCanonicalHostnameResolver;
use Plaisio\CanonicalHostnameResolver\Test\Plaisio\TestKernel;
use Plaisio\Exception\BadRequestException;
use Plaisio\PlaisioKernel;

/**
 * Test cases for class HttpHostCanonicalHostnameResolver.
 */
class HttpHostCanonicalHostnameResolverTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Our concrete instance of Abc.
   *
   * @var PlaisioKernel
   */
  private PlaisioKernel $kernel;

  //--------------------------------------------------------------------------------------------------------------------

  /**
   * Unsets $_SERVER['HTTP_HOST']. Note we set $_SERVER['HTTP_HOST'] after creating the resolver objects.
   */
  public function setUp(): void
  {
    unset($_SERVER['HTTP_HOST']);

    $this->kernel = new TestKernel();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number.
   */
  public function testGetDomain1a(): void
  {
    $_SERVER['HTTP_HOST'] = 'www.example.com';

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->assertSame('www.example.com', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number and host name in upper case.
   */
  public function testGetDomain1b(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.EXAMPLE.COM';

    $this->assertSame('www.example.com', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with trailing and leading (does this happen?).
   */
  public function testGetDomain1c(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = " www.example.com\t\n\r";

    $this->assertSame('www.example.com', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0'.
   */
  public function testGetDomain1d(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = '0';

    $this->assertSame('0', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0.0'.
   */
  public function testGetDomain1e(): void
  {
    $_SERVER['HTTP_HOST'] = '0.0';

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->assertSame('0.0', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with domain '0.0.0'.
   */
  public function testGetDomain1f(): void
  {
    $_SERVER['HTTP_HOST'] = '0.0.0';

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->assertSame('0.0.0', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with port number
   */
  public function testGetDomain2(): void
  {
    $_SERVER['HTTP_HOST'] = 'www.example.com:8080';

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->assertSame('www.example.com', $resolver->canonicalHostname);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without a hostname.
   */
  public function testGetDomain3(): void
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->expectException(BadRequestException::class);
    $resolver->canonicalHostname;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without a hostname.
   */
  public function testGetDomain4a(): void
  {
    $_SERVER['HTTP_HOST'] = null;

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->expectException(BadRequestException::class);
    $resolver->canonicalHostname;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without a hostname.
   */
  public function testGetDomain4b(): void
  {
    $_SERVER['HTTP_HOST'] = '';

    $resolver = new HttpHostCanonicalHostnameResolver();

    $this->expectException(BadRequestException::class);
    $resolver->canonicalHostname;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
