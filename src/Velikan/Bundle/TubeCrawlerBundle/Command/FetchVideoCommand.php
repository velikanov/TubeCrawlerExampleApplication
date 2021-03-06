<?php

namespace Velikan\Bundle\TubeCrawlerBundle\Command;

use AppBundle\Entity\Tube;
use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class FetchVideoCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('tube_crawler:video:fetch')
            ->setDescription('Fetch tube videos')
            ->addOption(
                'tube-id',
                't',
                InputOption::VALUE_OPTIONAL,
                'If set, the videos will be fetcher for specified tube'
            )
            ->addOption(
                'pages',
                'p',
                InputOption::VALUE_OPTIONAL,
                'Number of pages to fetch',
                10
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $tubeManipulator = $container->get('velikan_tube_crawler.tube_manipulator');

        $tubes = [];

        if ($tubeId = $input->hasArgument('tube-id')) {
            $tubes[] = $tubeManipulator->find($tubeId);
        } else {
            $tubes = $tubeManipulator->findAll();
        }

        $uriFetchAdapter = $container->get('velikan_tube_crawler.uri_fetch_adapter');

        $parsedVideoCounter = 0;
        $videoParser = $container->get('velikan_tube_crawler.video_parser');
        /** @var Tube $tube */
        $tube = null;

        $fetchAdapterFunction = function($responseBody, $pageIndex) use (&$tube, $tubeManipulator, $videoParser, $output, &$parsedVideoCounter) {
            $videos = $videoParser->parse(
                $responseBody,
                $tube->getVideoBlockSelector(),
                $tube->getVideoUriSelector(),
                $tube->getVideoImageSelector(),
                $tube->getVideoTitleSelector()
            );

            foreach ($videos as $parsedVideo) {
                $video = new Video();

                $video->setTube($tube);
                $video->setVideoUri($parsedVideo['uri']);
                $video->setImageUri($parsedVideo['image']);
                $video->setTitle($parsedVideo['title']);

                $tubeManipulator->testAndCreateVideo($video);
            }

            $parsedVideoCounter += count($videos);

            $output->writeln(sprintf('Parsed %d videos for page %d (%d overall)', count($videos), $pageIndex, $parsedVideoCounter));
        };

        /** @var Tube $tube */
        foreach ($tubes as $tube) {


            $output->writeln('Fetching videos for <info>'.$tube->getName().'</info>');

            $routeCollection = new RouteCollection();
            $routeCollection->add('uri', new Route($tube->getUrn()));
            $requestContext = new RequestContext(Tube::$schemeList[$tube->getScheme()].'://'.$tube->getHost());
            $generator = new UrlGenerator($routeCollection, $requestContext);

            $startingPageNumber = $tube->getStartingPageNumber();

            for ($i = $startingPageNumber; $i < $input->getOption('pages') + $startingPageNumber; $i++) {
                $uri = urldecode($generator->generate('uri', [
                    'page' => $i,
                ]));

                $uriFetchAdapter->addUri($uri);
            }

            $uriFetchAdapter->fetch($fetchAdapterFunction, $tube->getCanFetchMultithreaded(), $tube->getThreadCount());
        }
    }
}