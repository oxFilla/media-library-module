<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\MediaLibrary\Tests\Integration\Media\DataType;

use OxidEsales\MediaLibrary\Image\DataTransfer\ImageSize;
use OxidEsales\MediaLibrary\Media\DataType\Media;
use PHPUnit\Framework\TestCase;

class MediaTest extends TestCase
{
    public function testGetters(): void
    {
        $imageSize = new ImageSize(100, 100);

        $sut = new Media(
            oxid: 'someOxid',
            shopId: 2,
            fileName: 'filename.jpg',
            fileSize: 25,
            fileType: 'image/gif',
            thumbFileName: 'thumbfilename.jpg',
            imageSize: $imageSize,
            folderId: 'someFolderId'
        );

        $this->assertSame('someOxid', $sut->getOxid());
        $this->assertSame(2, $sut->getShopId());
        $this->assertSame('filename.jpg', $sut->getFileName());
        $this->assertSame(25, $sut->getFileSize());
        $this->assertSame('image/gif', $sut->getFileType());
        $this->assertSame('thumbfilename.jpg', $sut->getThumbFileName());
        $this->assertSame($imageSize, $sut->getImageSize());
        $this->assertSame('someFolderId', $sut->getFolderId());
    }

    /** @dataProvider isDirectoryDataProvider */
    public function testIsDirectory(string $fileType, bool $expectedResult): void
    {
        $sut = new Media(
            oxid: 'someOxid',
            shopId: 2,
            fileName: 'filename.jpg',
            fileSize: 25,
            fileType: $fileType,
            thumbFileName: 'thumbfilename.jpg',
            imageSize: $this->createStub(ImageSize::class),
            folderId: 'someFolderId'
        );

        $this->assertSame($expectedResult, $sut->isDirectory());
    }

    public function isDirectoryDataProvider(): \Generator
    {
        yield "some gif image filetype" => ['fileType' => 'image/gif', 'expectedResult' => false];
        yield "some jpeg image filetype" => ['fileType' => 'image/jpeg', 'expectedResult' => false];
        yield "directory media type" => ['fileType' => Media::FILETYPE_DIRECTORY, 'expectedResult' => true];
    }
}
