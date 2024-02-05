<?php

namespace IKadar\HTTPClient\Request;

use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    private RequestFactory $factory;
    private string $testRoutesFilePath;

    protected function setUp(): void
    {
        $this->factory = new RequestFactory();

        // Assuming a test-specific YAML file exists with simplified routes for testing
        $this->testRoutesFilePath = __DIR__ . '/test_routes.yaml';
        $this->factory->loadRoutes($this->testRoutesFilePath);
    }

    public function testCreateRequestForGet()
    {
        // Test creating a GET request and validate its route and query parameters
        $getRequest = $this->factory->createRequest('getCompanies');
        $this->assertInstanceOf(GetRequest::class, $getRequest);

        // Additional assertions to check the route configuration
        $route = $getRequest->getEndPointRoute();
        $this->assertEquals('/companies', $route->getPath());
        $this->assertContains('GET', $route->getMethods());
        $this->assertEquals(['name', 'page', 'limit'], $route->getQueryParameters());
    }

    public function testCreateRequestForPost()
    {
        // Test creating a POST request and validate its configuration
        $postRequest = $this->factory->createRequest('getCompaniesByIds');
        $this->assertInstanceOf(PostRequest::class, $postRequest);

        // Additional assertions for the POST request route
        $route = $postRequest->getEndPointRoute();
        $this->assertEquals('/companies', $route->getPath());
        $this->assertContains('POST', $route->getMethods());
        $this->assertEmpty($route->getQueryParameters()); // Assuming no query parameters for this route
    }

//    public function testCreateRequestThrowsExceptionForUnsupportedRoute()
//    {
//        $this->expectException(\Exception::class);
//        $this->factory->createRequest('nonExistentRoute');
//    }

    // You may add additional tests here as needed
}


