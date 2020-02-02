<?php

namespace App\Application\ActiveRecord\Validators;

use GoSale\YiiCore\Helper\Utils;
use yii\validators\Validator;

class CpfCnpjValidator extends Validator
{
    /**
     * @var string
     */
    public $typeAttribute = 'type';

    /**
     * @var int
     */
    public $cpfValue = 1;

    /**
     * @var int
     */
    public $cnpjValue = 2;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = 'Insira um {attribute} válido.';
        }
    }

    /**
     * @inheritDoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!array_key_exists($this->typeAttribute, $model->attributes)) {
            $this->addError(
                $model,
                $attribute,
                "Não foi encontrado o atributo '{$this->typeAttribute}' para validar CPF/CNPJ",
                []
            );
        }

        $type = $model->{$this->typeAttribute};
        $value = Utils::transliterate($model->{$attribute});

        if ($this->isCpf($type) && strlen($value) !== 11) {
            $this->addError($model, $attribute, "CPF deve conter exatamente 11 caracteres", []);
        }

        if ($this->isCnpj($type) && strlen($value) !== 14) {
            $this->addError($model, $attribute, "CNPJ deve conter exatamente 14 caracteres", []);
        }

        $result = $this->validateValue($value);

        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
    }

    /**
     * @inheritDoc
     */
    protected function validateValue($value)
    {
        if (strlen($value) === 11) {
            return $this->validateCpf($value);
        } else {
            return $this->validateCnpj($value);
        }
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isCpf($value): bool
    {
        return $value === $this->cpfValue;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isCnpj($value): bool
    {
        return $value === $this->cnpjValue;
    }

    /**
     * @param $value
     * @return array
     */
    private function validateCpf($value): array
    {
        $valid = true;
        $cpf = preg_replace('/[^0-9]/', '', $value);

        for ($x = 0; $x < 10; $x ++) {
            if ($cpf == str_repeat($x, 11)) {
                $valid = false;
            }
        }

        if ($valid) {
            if (strlen($cpf) != 11) {
                $valid = false;
            } else {
                for ($t = 9; $t < 11; $t ++) {
                    $d = 0;
                    for ($c = 0; $c < $t; $c ++) {
                        $d += $cpf {$c} * (($t + 1) - $c);
                    }

                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        $valid = false;
                        break;
                    }
                }
            }
        }

        return ($valid) ? [] : [$this->message, []];
    }

    /**
     * @param $value
     * @return array
     */
    private function validateCnpj($value)
    {
        $valid = true;
        $cnpj = preg_replace('/[^0-9_]/', '', $value);

        for ($x=0; $x<10; $x++) {
            if ($cnpj == str_repeat($x, 14)) {
                $valid = false;
            }
        }
        if ($valid) {
            if (strlen($cnpj) != 14) {
                $valid = false;
            } else {
                for ($t = 12; $t < 14; $t ++) {
                    $d = 0;
                    $c = 0;
                    for ($m = $t - 7; $m >= 2; $m --, $c ++) {
                        $d += $cnpj {$c} * $m;
                    }
                    for ($m = 9; $m >= 2; $m --, $c ++) {
                        $d += $cnpj {$c} * $m;
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cnpj {$c} != $d) {
                        $valid = false;
                        break;
                    }
                }
            }
        }
        return ($valid) ? [] : [$this->message, []];
    }
}
