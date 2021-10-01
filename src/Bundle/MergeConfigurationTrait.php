<?php

/*
 * This file is part of the NumberNine package.
 *
 * (c) William Arin <williamarin.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NumberNine\Common\Bundle;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function NumberNine\Common\Util\ArrayUtil\array_merge_recursive_distinct;
use function NumberNine\Common\Util\ArrayUtil\array_merge_recursive_fixed;

trait MergeConfigurationTrait
{
    /**
     * Merge configuration into one config
     */
    protected function mergeConfigIntoOne(
        ContainerBuilder $container,
        string $name,
        array $config = [],
        bool $reverse = false
    ): void {
        $originalConfig = $container->getExtensionConfig($name);
        if (!count($originalConfig)) {
            $originalConfig[] = [];
        }

        $originalConfig[0] = $reverse
            ? array_merge_recursive_distinct($originalConfig[0], $config)
            : array_merge_recursive_distinct($config, $originalConfig[0]);

        $this->setExtensionConfig($container, $name, $originalConfig);
    }

    /**
     * Set extension config
     *
     * Usable for extensions which requires to have just one config.
     * http://api.symfony.com/2.3/Symfony/Component/Config/Definition/Builder/ArrayNodeDefinition.html
     * #method_disallowNewKeysInSubsequentConfigs
     */
    public function setExtensionConfig(ContainerBuilder $container, string $name, array $config = []): void
    {
        $classRef = new ReflectionClass(ContainerBuilder::class);
        $extensionConfigsRef = $classRef->getProperty('extensionConfigs');
        $extensionConfigsRef->setAccessible(true);

        $newConfig = $extensionConfigsRef->getValue($container);
        $newConfig[$name] = $config;
        $extensionConfigsRef->setValue($container, $newConfig);

        $extensionConfigsRef->setAccessible(false);
    }
}
