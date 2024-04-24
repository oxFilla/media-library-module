<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

use OxidEsales\Codeception\Module\Database\DatabaseDefaultsFileGenerator;
use OxidEsales\Facts\Config\ConfigFile;
use OxidEsales\Facts\Facts;

if ($shopRootPath = getenv('SHOP_ROOT_PATH')){
    require_once($shopRootPath . '/source/bootstrap.php');
}

$facts = new Facts();
return [
    'SHOP_URL' => $facts->getShopUrl(),
    'SHOP_SOURCE_PATH' => $facts->getSourcePath(),
    'VENDOR_PATH' => $facts->getVendorPath(),
    'DB_NAME' => $facts->getDatabaseName(),
    'DB_USERNAME' => $facts->getDatabaseUserName(),
    'DB_PASSWORD' => $facts->getDatabasePassword(),
    'DB_HOST' => $facts->getDatabaseHost(),
    'DB_PORT' => $facts->getDatabasePort(),
    'DUMP_PATH' => getTestDataDumpFilePath(),
    'MODULE_DUMP_PATH' => getModuleTestDataDumpFilePath(),
    'FIXTURES_PATH' => getTestFixtureSqlFilePath(),
    'MYSQL_CONFIG_PATH' => getMysqlConfigPath(),
    'SELENIUM_SERVER_PORT' => getenv('SELENIUM_SERVER_PORT') ?: '4444',
    'SELENIUM_SERVER_HOST' => getenv('SELENIUM_SERVER_HOST') ?: 'selenium',
    'BROWSER_NAME' => getenv('BROWSER_NAME') ?: 'chrome',
    'PHP_BIN' => getenv('PHPBIN') ?: 'php',
    'SCREEN_SHOT_URL' => getenv('CC_SCREEN_SHOTS_PATH') ?: '',
    'THEME_ID' => getenv('THEME_ID') ?: 'apex'
];

function getTestDataDumpFilePath(): string
{
    return __DIR__ . '/../Support/Data/generated/dump.sql';
}

function getModuleTestDataDumpFilePath()
{
    return __DIR__ . '/../Support/Data/dump.sql';
}

function getTestFixtureSqlFilePath(): string
{
    $facts = new Facts();

    return __DIR__ . '/../../fixtures/testdata_' . strtolower($facts->getEdition()) . '.sql';
}

function getShopSuitePath($facts)
{
    $testSuitePath = getenv('TEST_SUITE');

    if (!$testSuitePath) {
        $testSuitePath = $facts->getShopRootPath() . '/tests';
    }

    return $testSuitePath;
}

function getShopTestPath()
{
    $facts = new Facts();

    if ($facts->isEnterprise()) {
        $shopTestPath = $facts->getEnterpriseEditionRootPath() . '/Tests';
    } else {
        $shopTestPath = getShopSuitePath($facts);
    }

    return $shopTestPath;
}

function getMysqlConfigPath()
{
    $facts = new Facts();
    $configFilePath = $facts->getSourcePath() . '/config.inc.php';
    $configFile = new ConfigFile($configFilePath);
    $generator = new DatabaseDefaultsFileGenerator($configFile);

    return $generator->generate();
}