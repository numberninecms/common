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

use LogicException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

trait BundleTrait
{
    /** @var ExtensionInterface|null */
    protected $extension;
    abstract public function getName(): string;
    abstract protected function createContainerExtension();

    protected function getAlias(): string
    {
        $basename = preg_replace('/Bundle$/', '', $this->getName());
        return Container::underscore((string)$basename);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $extension = $this->createContainerExtension();

            if (null !== $extension) {
                if (!$extension instanceof ExtensionInterface) {
                    throw new LogicException(sprintf(
                        'Extension %s must implement ' .
                        'Symfony\Component\DependencyInjection\Extension\ExtensionInterface.',
                        get_class($extension)
                    ));
                }

                if ($this->getAlias() !== $extension->getAlias()) {
                    throw new LogicException(
                        sprintf(
                            'Users will expect the alias of the default extension of a bundle to be the underscored ' .
                            'version of the bundle name ("%s"). You can override "Bundle::getContainerExtension()" ' .
                            'if you want to use "%s" or another alias.',
                            $this->getAlias(),
                            $extension->getAlias()
                        )
                    );
                }

                $this->extension = $extension;
            }
        }

        return $this->extension;
    }
}
