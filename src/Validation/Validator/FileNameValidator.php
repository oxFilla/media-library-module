<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\MediaLibrary\Validation\Validator;

use OxidEsales\MediaLibrary\Media\DataType\FilePathInterface;
use OxidEsales\MediaLibrary\Validation\Exception\ValidationFailedException;

class FileNameValidator implements FilePathValidatorInterface
{
    //@todo: setting
    public const FORBIDDEN_CHARACTERS = '/<>:"|?*\\';

    public function validateFile(FilePathInterface $filePath): void
    {
        $fileName = $filePath->getFileName();

        $this->checkFilenameNotEmpty($fileName);
        $this->checkFilenameDoesNotStartWithDot($fileName);
        $this->checkForbiddenCharacters($fileName);
    }

    private function checkForbiddenCharacters(string $fileName): void
    {
        $forbiddenCharacters = str_split(self::FORBIDDEN_CHARACTERS);
        foreach ($forbiddenCharacters as $oneForbiddenCharacter) {
            if (strpos($fileName, $oneForbiddenCharacter) !== false) {
                throw new ValidationFailedException("Forbidden character found: " . $oneForbiddenCharacter);
            }
        }
    }

    public function checkFilenameNotEmpty(string $fileName): void
    {
        if (!$fileName) {
            throw new ValidationFailedException("Filename cannot be empty");
        }
    }

    public function checkFilenameDoesNotStartWithDot(string $fileName): void
    {
        if ($fileName[0] === '.') {
            throw new ValidationFailedException("Filename cannot start with .");
        }
    }
}
