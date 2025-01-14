<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\MediaLibrary\Image\Service;

use OxidEsales\MediaLibrary\Image\DataTransfer\ImageSizeInterface;
use Symfony\Component\Filesystem\Path;

interface ThumbnailResourceInterface
{
    public function getDefaultThumbnailSize(): ImageSizeInterface;

    public function getPathToThumbnailFiles(string $folderName): string;

    public function getPathToThumbnailFile(string $fileName, ?string $folderName = null): string;

    public function getUrlToThumbnailFiles(string $folderName): string;

    public function getUrlToThumbnailFile(string $fileName, ?string $folderName = null): string;
}
