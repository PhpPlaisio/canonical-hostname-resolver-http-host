<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\CanonicalHostnameResolver\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\CanonicalHostnameResolver\HttpHostCanonicalHostnameResolver;
use SetBased\Exception\RuntimeException;

//----------------------------------------------------------------------------------------------------------------------
/**
 * Test cases for class HttpHostCanonicalHostnameResolver.
 */
class HttpHostCanonicalHostnameResolverTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Unsets $_SERVER['HTTP_HOST']. Note we set $_SERVER['HTTP_HOST'] after creating the resolver objects.
   */
  public function setUp()
  {
    parent::setUp();

    unset($_SERVER['HTTP_HOST']);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number.
   */
  public function testGetDomain1a()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.example.com';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without port number anf host name in upper case.
   */
  public function testGetDomain1b()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.EXAMPLE.COM';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with trailing and leading (does this happen?).
   */
  public function testGetDomain1c()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = " www.example.com\t\n\r";

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname with port number
   */
  public function testGetDomain2()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = 'www.example.com:8080';

    $this->assertSame('www.example.com', $resolver->getCanonicalHostname());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without host name.
   *
   * @expectedException RuntimeException
   */
  public function testGetDomain3()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $resolver->getCanonicalHostname();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test method getCanonicalHostname without host name.
   *
   * @expectedException RuntimeException
   */
  public function testGetDomain4()
  {
    $resolver = new HttpHostCanonicalHostnameResolver();

    $_SERVER['HTTP_HOST'] = null;

    $resolver->getCanonicalHostname();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
