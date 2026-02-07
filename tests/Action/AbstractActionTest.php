<?php

namespace Ekyna\Component\Payum\Monetico\Action;

use Ekyna\Component\Payum\Monetico\Api\Api;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayInterface;
use Payum\Core\Security\TokenInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractActionTest
 * @package Ekyna\Component\Payum\Monetico
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractActionTest extends TestCase
{
    /**
     * @return MockObject&GatewayInterface
     */
    protected function createGatewayMock()
    {
        return $this->getMockBuilder(GatewayInterface::class)->getMock();
    }

    /**
     * @return MockObject&TokenInterface
     */
    protected function createTokenMock()
    {
        return $this->getMockBuilder(TokenInterface::class)->getMock();
    }

    /**
     * @return MockObject&Api
     */
    protected function createApiMock()
    {
        return $this->getMockBuilder(Api::class)->getMock();
    }

    /**
     * Returns the action instance.
     */
    protected function createAction()
    {
        $actionClass = $this->actionClass;

        return new $actionClass();
    }

    /**
     * Returns a supported request instance with an ArrayAccess model.
     */
    protected function createSupportedRequest()
    {
        $requestClass = $this->requestClass;

        return new $requestClass(new ArrayObject());
    }

    /**
     * @test
     */
    public function should_support_only_supported_request()
    {
        $action = $this->createAction();

        $this->assertTrue($action->supports($this->createSupportedRequest()));
        $this->assertFalse($action->supports(new \stdClass()));
    }

    /**
     * @test
     */
    public function throw_if_not_supported_request()
    {
        $action = $this->createAction();

        $this->expectException(RequestNotSupportedException::class);
        $action->execute(new \stdClass());
    }
}
