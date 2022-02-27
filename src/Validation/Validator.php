<?php

namespace Shimoning\LineLogin\Validation;

class Validator
{
    /** @var ValidationExecuter[] */
    protected $rules = [];

    /** @var mixed */
    protected $value;

    public function __construct(array $rules, $value)
    {
        $this->setRules($rules);
        $this->value = $value;
    }

    /**
     * 検証する
     *
     * @return boolean
     */
    public function passes(): bool
    {
        foreach ($this->rules as $rule) {
            if (! $rule->execute($this->value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * ルールをセットする
     *
     * @param array $rules
     * @return void
     */
    protected function setRules(array $rules)
    {
        $this->rules = (new ValidationRuleParser($this, $this->value))->parse($rules);
    }
}
