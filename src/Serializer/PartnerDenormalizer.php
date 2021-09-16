<?php

namespace App\Serializer;

use App\Entity\Client;
use App\Entity\Partner;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class PartnerDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = "PartnerDenormalizerCalled";

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        $alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return ($type == Client::class) && $alreadyCalled === false;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED_DENORMALIZER] = true;

        /** @var Client $obj */
        $obj = $this->denormalize($data, $type, $format, $context);
        $obj->setPartner($this->security->getUser());
        return $obj;

    }

}