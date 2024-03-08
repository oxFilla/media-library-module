<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\MediaLibrary\Image\ThumbnailGenerator;

use OxidEsales\MediaLibrary\Image\DataTransfer\ImageSizeInterface;
use OxidEsales\MediaLibrary\Service\FileSystemServiceInterface;

class Svg implements ThumbnailGeneratorInterface
{
    public function __construct(
        protected FileSystemServiceInterface $fileSystemService
    ) {
    }

    public function isOriginSupported(string $sourcePath): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        return $extension === 'svg';
    }

    public function generateThumbnail(
        string $sourcePath,
        string $thumbnailPath,
        ImageSizeInterface $size,
        bool $blCrop,
    ): void {
        $this->fileSystemService->copy($sourcePath, $thumbnailPath);
    }
}