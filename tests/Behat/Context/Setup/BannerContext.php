<?php

declare(strict_types=1);

namespace Tests\Odiseo\SyliusBannerPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Odiseo\SyliusBannerPlugin\Entity\BannerInterface;
use Odiseo\SyliusBannerPlugin\Repository\BannerRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class BannerContext implements Context
{
    /** @var FactoryInterface */
    private $bannerFactory;

    /** @var BannerRepositoryInterface */
    private $bannerRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        FactoryInterface $bannerFactory,
        BannerRepositoryInterface $bannerRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $code
     * @Given there is an existing banner with :code code
     */
    public function thereIsABannerWithCode(string $code): void
    {
        $banner = $this->createBanner($code);

        $this->saveBanner($banner);
    }

    /**
     * @param int $quantity
     * @Given the store has( also) :quantity banners
     */
    public function theStoreHasBanners(int $quantity): void
    {
        for ($i = 1;$i <= $quantity;$i++) {
            $this->saveBanner($this->createBanner('Test'.$i));
        }
    }

    /**
     * @param string $code
     * @return BannerInterface
     */
    private function createBanner(string $code): BannerInterface
    {
        /** @var BannerInterface $banner */
        $banner = $this->bannerFactory->createNew();

        $banner->setCode($code);
        $banner->setCurrentLocale('en_US');

        $path = __DIR__.'/../../Resources/images/';
        $filename = 'logo_odiseo.png';
        $banner->setImageFile(new UploadedFile($path.$filename, $filename));
        $banner->setMobileImageFile(new UploadedFile($path.$filename, $filename));
        $banner->setUrl('https://odiseo.com.ar');

        return $banner;
    }

    /**
     * @param BannerInterface $banner
     */
    private function saveBanner(BannerInterface $banner): void
    {
        $this->bannerRepository->add($banner);
    }
}
