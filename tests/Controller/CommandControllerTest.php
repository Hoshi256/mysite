<?php

namespace App\Test\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CommandRepository $repository;
    private string $path = '/command/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Command::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Command index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'command[price]' => 'Testing',
            'command[quantity]' => 'Testing',
            'command[total]' => 'Testing',
            'command[product]' => 'Testing',
        ]);

        self::assertResponseRedirects('/command/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Command();
        $fixture->setPrice('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setTotal('My Title');
        $fixture->setProduct('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Command');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Command();
        $fixture->setPrice('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setTotal('My Title');
        $fixture->setProduct('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'command[price]' => 'Something New',
            'command[quantity]' => 'Something New',
            'command[total]' => 'Something New',
            'command[product]' => 'Something New',
        ]);

        self::assertResponseRedirects('/command/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getTotal());
        self::assertSame('Something New', $fixture[0]->getProduct());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Command();
        $fixture->setPrice('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setTotal('My Title');
        $fixture->setProduct('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/command/');
    }
}
