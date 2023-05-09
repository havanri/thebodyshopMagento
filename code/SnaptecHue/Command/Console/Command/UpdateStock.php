<?php

namespace SnaptecHue\Command\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Psr\Log\LoggerInterface;
class UpdateStock extends Command
{
    private const NAME = 'name';
    private const CUSTOM_QUANTITY_STOCK = 1000;
    private $state;
    private $productRepository;
    private $productCollectionFactory;
    public function __construct(
        State $state,
        ProductRepositoryInterface $productRepository,
        ProductCollectionFactory $productCollectionFactory,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    protected function configure()
    {
        $this->setName('snaptechue:updatestock')
            ->setDescription('Update stock quantity for all products in catalog.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = Cli::RETURN_SUCCESS;
        try {
            // Run in adminhtml area
            $this->state->emulateAreaCode(Area::AREA_ADMINHTML, function () use ($output) {
                $productCollection = $this->productCollectionFactory->create();
                $productCollection->setPageSize(0); // to get all products
                $productIds = $productCollection->getAllIds();

                foreach ($productIds as $productId) {
                    $product = $this->productRepository->getById($productId);
                    $product->setStockData(['qty' => self::CUSTOM_QUANTITY_STOCK]);
                    $this->productRepository->save($product);
                }

                $output->writeln('<info>Stock quantity for all products updated.</info>');
                // $this->logger->info('snaptechue:updatestock sucessful!');
            });
        } catch (LocalizedException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            // $this->logger->info('snaptechue:updatestock failure!');
            $exitCode = Cli::RETURN_FAILURE;
        }

        return $exitCode;
    }
}
