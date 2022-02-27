<?php

namespace Shimoning\LineLogin\Validation;

class ValidationRuleParser
{
    protected $entity;

    /** @var mixed */
    protected $data;

    /**
     * 標準で用意してある検証ルール
     *
     * @var array
     */
    protected $presetRules = [ 'numeric', 'string', 'boolean', 'array', 'in' ];

    /**
     * 検証に引数を取るルール
     *
     * @var array
     */
    protected $dependentRules = [ 'in' ];

    public function __construct($entity, $data)
    {
        $this->entity = $entity;
        $this->data = $data;
    }

    /**
     * ルールをパースする
     *
     * @param array $rules
     * @return ValidationExecuter[]
     */
    public function parse(array $rules)
    {
        $parsed = [];
        foreach ($rules as $rule) {
            $exploded = \explode(':', $rule);

            $rule = $exploded[0];
            $method = $this->getMethod($rule);
            if (\is_null($method)) {
                continue;
            }

            $parameters = $this->parsePayload($rule, $exploded[1] ?? null);

            $parsed[] = new ValidationExecuter($method, $parameters);
        }

        return $parsed;
    }

    /**
     * 有効な検証メソッドを取得する
     *
     * @param string $rule
     * @return array|null
     */
    protected function getMethod(string $rule): ?array
    {
        if (\in_array($rule, $this->presetRules)) {
            return [
                \Shimoning\LineLogin\Validation\Rules\PresetRules::class,
                $rule,
            ];
        }

        $method = 'validate' . \strtoupper($rule);
        if (\method_exists($this->entity, $method)) {
            return [$this->entity, $method];
        }

        return null;
    }

    /**
     * 検証に使う値をパースする
     *
     * @param string $rule
     * @param string|array $payload
     * @return array|null
     */
    protected function parsePayload(string $rule, ?string $payload): ?array
    {
        if (isset($payload) && \in_array($rule, $this->dependentRules, true)) {
            return \explode(',', $payload);
        }
        return null;
    }
}
