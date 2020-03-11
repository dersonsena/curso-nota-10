<?php

namespace App\Domains\Bill;

use App\Infra\GridView\ActionGridColumn as ActionGridColumnBase;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;

class ActionGridColumn extends ActionGridColumnBase
{
    /**
     * @var string
     */
    public $template = '{receive} {reverse} {receipt} {update} {delete}';

    /**
     * @var array
     */
    public $headerOptions = ['style' => 'width: 260px', 'class'=>'text-center'];

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['update'])) {
            $this->createUpdateButton();
        }

        if (!isset($this->buttons['delete'])) {
            $this->createDeleteButton();
        }

        if (!isset($this->buttons['receive']) || is_null($this->buttons['receive'])) {
            $this->createReceiveButton();
        }

        if (!isset($this->buttons['reverse']) || is_null($this->buttons['reverse'])) {
            $this->createReverseButton();
        }

        if (!isset($this->buttons['receipt']) || is_null($this->buttons['receipt'])) {
            $this->createReceiptButton();
        }
    }

    protected function createReceiveButton()
    {
        $this->buttons['receive'] = function ($url, Bill $model, $key) {
            if ($model->isReceived() || $model->isCanceled()) {
                return '';
            }

            $options = array_merge($this->domainActions::receive($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }

    protected function createReverseButton()
    {
        $this->buttons['reverse'] = function ($url, Bill $model, $key) {
            if ($model->isOpen() || $model->isCanceled()) {
                return '';
            }

            $options = array_merge($this->domainActions::reverse($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }

    protected function createReceiptButton()
    {
        $this->buttons['receipt'] = function ($url, Bill $model, $key) {
            if ($model->isOpen() || $model->isCanceled()) {
                return '';
            }

            $options = array_merge($this->domainActions::receipt($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }
}
