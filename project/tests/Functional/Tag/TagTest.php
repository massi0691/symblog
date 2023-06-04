<?php

namespace App\Tests\Functional\tag;

use App\Entity\Post\Tag;
use App\Repository\Post\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TagTest extends WebTestCase
{
    public function testPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var TagRepository */
        $tagRepository = $entityManager->getRepository(Tag::class);

        /** @var Tag */
        $tag = $tagRepository->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('tag.index', ['slug' => $tag->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', 'Etiquette : ' . ucfirst($tag->getName()));
    }

    public function testPaginationWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var TagRepository */
        $tagRepository = $entityManager->getRepository(Tag::class);

        /** @var Tag */
        $tag = $tagRepository->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('tag.index', ['slug' => $tag->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $posts = $crawler->filter('div.card');
        $this->assertEquals(9, count($posts));

        $link = $crawler->selectLink('2')->extract(['href'])[0];

        $crawler = $client->request(Request::METHOD_GET, $link);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $posts = $crawler->filter('div.card');
        $this->assertGreaterThanOrEqual(1, count($posts));
    }
}
