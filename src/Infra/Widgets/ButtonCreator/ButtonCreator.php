<?php

namespace App\Infra\Widgets\ButtonCreator;

use yii\helpers\Html;

class ButtonCreator
{
    /**
     * @var string
     */
    const TYPE_LINK = 'link';

    /**
     * @var string
     */
    const TYPE_BUTTON = 'button';

    /**
     * @var string
     */
    const SIZE_LARGE = 'btn-lg';

    /**
     * @var string
     */
    const SIZE_NORMAL = '';

    /**
     * @var string
     */
    const SIZE_LITTLE = 'btn-sm';

    /**
     * @var string
     */
    const SIZE_TINY = 'btn-xs';

    /**
     * @var string
     */
    private $type = 'link';

    /**
     * @var string
     */
    private $size;

    /**
     * @var bool
     */
    private $onlyIcon = false;

    private function __construct(array $params)
    {
        $this->size = static::SIZE_NORMAL;

        if (isset($params['type'])) {
            $this->type = $params['type'];
        }

        if (isset($params['onlyIcon'])) {
            $this->onlyIcon = $params['onlyIcon'];
        }

        if (isset($params['size'])) {
            $this->size = $params['size'];
        }
    }

    /**
     * @param array $params
     * @return string
     */
    public static function build(array $params): string
    {
        $button = new static($params);

        if ($button->getType() === static::TYPE_LINK) {
            return static::renderLink($button, $params);
        }

        if ($button->getType() === static::TYPE_BUTTON) {
            return static::renderButton($button, $params);
        }

        return '';
    }

    /**
     * @param ButtonCreator $button
     * @param array $params
     * @return string
     */
    private static function renderLink(ButtonCreator $button, array $params): string
    {
        $icon = (isset($params['icon']) ? Html::tag('i', '', ['class' => $params['icon']]) . ' ' : '');
        $text = ($button->isOnlyIcon() ? $icon : $icon . ' ' . $params['text']);
        $params['htmlOptions']['class'] .= ' ' . $button->size;

        return Html::a($text, $params['to'], $params['htmlOptions']);
    }

    /**
     * @param ButtonCreator $button
     * @param array $params
     * @return string
     */
    private static function renderButton(ButtonCreator $button, array $params): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return bool
     */
    public function isOnlyIcon(): bool
    {
        return $this->onlyIcon;
    }
}
