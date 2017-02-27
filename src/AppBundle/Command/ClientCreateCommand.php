<?php
declare(strict_types = 1);

namespace AppBundle\Command;

use AppBundle\Entity\Client;
use AppBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * AppBundle\Command\ClientCreateCommand
 *
 * @author Ivan Molchanov <molchanoviv@yandex.ru>
 */
class ClientCreateCommand extends ContainerAwareCommand
{
    /**
     * @var UserManager
     */
    protected $userManager;


    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('api:oauth:client:create')
            ->setDescription('Creates a new client')
            ->addArgument('username', InputArgument::REQUIRED, 'User name')
            ->addOption(
                'redirect-uri',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets the redirect uri. Use multiple times to set multiple uris.',
                ['http://', 'https://']
            )
            ->addOption(
                'grant-type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Set allowed grant type. Use multiple times to set multiple grant types',
                []
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \LogicException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->userManager = $this->getContainer()->get('app.manager.user_manager');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws UsernameNotFoundException
     * @throws \Exception
     * @throws \LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $user = $this->userManager->findOneBy(['username' => $username]);
        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User with name %s not found', $username));
        }
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        /** @var $client Client */
        $client = $clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->addAllowedGrantTypes($input->getOption('grant-type'));
        $client->setUser($user);
        $clientManager->updateClient($client);

        $output->writeln(sprintf('Added a new client with  public id <info>%s</info>', $client->getPublicId()));
        $output->writeln(sprintf('Added a new client with  secret <info>%s</info>', $client->getSecret()));
    }
}
