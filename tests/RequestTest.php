<?php

namespace IKadar\HTTPClient\Request;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testRequestInitializationAndGetters()
    {
        $route = new Route('/test/{id}', requirements: [], methods: ['GET'], queryParameters: ['id']);
        $parameters = ['id' => 123];
        $options = ['option1' => 'value1'];

        $request = new GetRequest($route, $parameters, $options);

        $this->assertEquals($route, $request->getEndPointRoute());
        $this->assertEquals($parameters, $request->getParameters());
        $this->assertEquals($options, $request->getOptions());
        $this->assertEquals('test/123', $request->getEndPointUrl());
    }

    public function testSplitParameters()
    {
        $route = new Route('/test', requirements: [], methods: ['POST'], queryParameters: ['name']);
        $parameters = ['name' => 'TestName', 'extra' => 'ExtraData'];
        $options = [];

        $request = new PostRequest($route, $parameters, $options);

        // After initialization, 'extra' should be moved to payload (options["json"])
        $this->assertEquals(['name' => 'TestName'], $request->getParameters());
        $this->assertEquals(['json' => ['extra' => 'ExtraData']], $request->getOptions());
    }

    public function testFetch()
    {
        $route = new Route('/test/{id}', requirements: [], methods: ['GET'], queryParameters: ['id']);
        $parameters = ['id' => 456];
        $options = ['option2' => 'value2'];

        $getRequest = new GetRequest($route, $parameters, $options);

        // Expected behavior for the fetch method
        $expected = ['GET', 'test/456', $options];
        $this->assertEquals($expected, $getRequest->fetch());
    }
}
