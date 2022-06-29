<?php
namespace App\Controller\Component;

use Cake\Controller\Component\FlashComponent as FlashComponentBase;

class FlashComponent extends FlashComponentBase
{
    /**
     * @inheritDoc
     */
    public function set($message, array $options = [])
    {
        [$plugin, $element] = pluginSplit($options['element'] ?? $this->getConfig('element'));

        if ($plugin === null) {
            $class = ($options['params']['class'] ?? null);

            if (is_string($class) && in_array($class, ['success', 'error', 'info', 'warning'])) {
                $options['element'] = $class;
            }

            unset($options['params']['class'], $options['params']['attributes']);
        }

        parent::set($message, $options);
    }
}
