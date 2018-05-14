<?php

namespace App\Client;

use Github\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class GithubClientTest extends TestCase
{
    /**
     * @var Client|ObjectProphecy
     */
    private $client;

    protected function setUp()
    {
        $this->client = $this->prophesize(Client::class);
    }

    public function testFetchAllOrganizationRepositories()
    {
        $this->githubClient = new GithubClient($this->client->reveal());

        $this->assertTrue(true);
    }
}
