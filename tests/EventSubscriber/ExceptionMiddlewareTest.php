<?php
declare(strict_types = 1);

namespace Tests\EventSubscriber;

use Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\EventSubscriber\ExceptionMiddleware;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class IsApiMiddlewareTest
 *
 * @package Tests\EventSubscriber
 *
 * @covers  \Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\EventSubscriber\ExceptionMiddleware
 */
final class ExceptionMiddlewareTest extends
    TestCase
{
    /**
     * testOnKernelController
     *
     * @return void
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testOnKernelController() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        $mockHttpKernel = $this->createMock(HttpKernelInterface::class);
        $testRequest    = new Request();
        
        $testController = new class() {
            public function __invoke() : void
            {
            
            }
        };
        
        $testEvent = new ControllerEvent(
            $mockHttpKernel,
            [
                $testController,
                '__invoke',
            ],
            $testRequest,
            null
        );
        
        // act
        $output = $systemUnderTest->onKernelController($testEvent);
        
        // assert
        self::assertSame(
            $testEvent,
            $output
        );
    }
    
    /**
     * createSUT
     *
     * @return \Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\EventSubscriber\ExceptionMiddleware
     */
    private function createSUT() : ExceptionMiddleware
    {
        return new ExceptionMiddleware();
    }
    
    /**
     * testOnKernelControllerThrowsBadRequestHttpException
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testOnKernelControllerThrowsBadRequestHttpException() : void
    {
        // arrange
        $systemUnderTest = $this->createSUT();
        
        $mockHttpKernel = $this->createMock(HttpKernelInterface::class);
        $testRequest    = new Request();
        
        $testController = new class() implements
            IsApiControllerInterface {
            public function __invoke() : void
            {
            
            }
        };
        
        $testEvent = new ControllerEvent(
            $mockHttpKernel,
            [
                $testController,
                '__invoke',
            ],
            $testRequest,
            null
        );
        
        // expect
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('You need to use an XMLHttpRequest');
        
        // act
        $systemUnderTest->onKernelController($testEvent);
    }
}
