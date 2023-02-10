<?php

namespace App\Test\Controller;

use App\Entity\Countries;
use App\Repository\CountriesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CountriesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CountriesRepository $repository;
    private string $path = '/countries/crud/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Countries::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Country index');

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
            'country[name]' => 'Testing',
            'country[population]' => 'Testing',
            'country[capital]' => 'Testing',
            'country[monney]' => 'Testing',
            'country[continentid]' => 'Testing',
        ]);

        self::assertResponseRedirects('/countries/crud/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Countries();
        $fixture->setName('My Title');
        $fixture->setPopulation('My Title');
        $fixture->setCapital('My Title');
        $fixture->setMonney('My Title');
        $fixture->setContinentid('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Country');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Countries();
        $fixture->setName('My Title');
        $fixture->setPopulation('My Title');
        $fixture->setCapital('My Title');
        $fixture->setMonney('My Title');
        $fixture->setContinentid('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'country[name]' => 'Something New',
            'country[population]' => 'Something New',
            'country[capital]' => 'Something New',
            'country[monney]' => 'Something New',
            'country[continentid]' => 'Something New',
        ]);

        self::assertResponseRedirects('/countries/crud/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getPopulation());
        self::assertSame('Something New', $fixture[0]->getCapital());
        self::assertSame('Something New', $fixture[0]->getMonney());
        self::assertSame('Something New', $fixture[0]->getContinentid());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Countries();
        $fixture->setName('My Title');
        $fixture->setPopulation('My Title');
        $fixture->setCapital('My Title');
        $fixture->setMonney('My Title');
        $fixture->setContinentid('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/countries/crud/');
    }
}
