<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;

/**
 * Base64 encoded data processor for asynchronous import
 */
class Base64EncodedDataProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'base64_encoded_data';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistantUploader;

    /**
     * @param PersistentSourceProcessor $persistantUploader
     */
    public function __construct(
        PersistentSourceProcessor $persistantUploader
    ) {
        $this->persistantUploader = $persistantUploader;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        /** @var string $content */
        $content = base64_decode($source->getImportData());

        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistantUploader->processUpload($source, $response);
    }
}
