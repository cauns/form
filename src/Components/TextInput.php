<?php

namespace Filament\Forms2\Components;

class TextInput extends Field
{
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeLengthConstrained;
    use Concerns\HasPlaceholder;

    protected string $view = 'forms2::components.text-input';

    protected $isEmail = false;

    protected $isNumeric = false;

    protected $isPassword = false;

    protected $isTel = false;

    protected $isUrl = false;

    protected $maxValue = null;

    protected $minValue = null;

    protected $postfixLabel = null;

    protected $prefixLabel = null;

    protected $type = null;

    public function currentPassword(bool | callable $condition = true): static
    {
        $this->addValidationRule('current_password', $condition);

        return $this;
    }

    public function email(bool | callable $condition = true): static
    {
        $this->isEmail = $condition;

        $this->addValidationRule('email', $condition);

        return $this;
    }

    public function maxValue($value): static
    {
        $this->maxValue = $value;

        $this->addValidationRule(function (): string {
            $value = $this->getMaxValue();

            return "max:{$value}";
        });

        return $this;
    }

    public function minValue($value): static
    {
        $this->minValue = $value;

        $this->addValidationRule(function (): string {
            $value = $this->getMinValue();

            return "min:{$value}";
        });

        return $this;
    }

    public function numeric(bool | callable $condition = true): static
    {
        $this->isNumeric = $condition;

        $this->addValidationRule('numeric', $condition);

        return $this;
    }

    public function password(bool | callable $condition = true): static
    {
        $this->isPassword = $condition;

        return $this;
    }

    public function prefix(string | callable $label): static
    {
        $this->prefixLabel = $label;

        return $this;
    }

    public function postfix(string | callable $label): static
    {
        $this->postfixLabel = $label;

        return $this;
    }

    public function tel(bool | callable $condition = true): static
    {
        $this->isTel = $condition;

        return $this;
    }

    public function type(string | callable $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function url(bool | callable $condition = true): static
    {
        $this->isUrl = $condition;

        $this->addValidationRule('url', $condition);

        return $this;
    }

    public function getMaxValue()
    {
        return $this->evaluate($this->maxValue);
    }

    public function getMinValue()
    {
        return $this->evaluate($this->minValue);
    }

    public function getPrefixLabel(): ?string
    {
        if (! ($label = $this->evaluate($this->prefixLabel))) {
            return null;
        }

        return $label;
    }

    public function getPostfixLabel(): ?string
    {
        if (! ($label = $this->evaluate($this->postfixLabel))) {
            return null;
        }

        return $label;
    }

    public function getType(): string
    {
        if ($type = $this->evaluate($this->type)) {
            return $type;
        } elseif ($this->isEmail()) {
            return 'email';
        } elseif ($this->isNumeric()) {
            return 'number';
        } elseif ($this->isPassword()) {
            return 'password';
        } elseif ($this->isTel()) {
            return 'tel';
        } elseif ($this->isUrl()) {
            return 'url';
        }

        return 'text';
    }

    public function isEmail(): bool
    {
        return (bool) $this->evaluate($this->isEmail);
    }

    public function isNumeric(): bool
    {
        return (bool) $this->evaluate($this->isNumeric);
    }

    public function isPassword(): bool
    {
        return (bool) $this->evaluate($this->isPassword);
    }

    public function isTel(): bool
    {
        return (bool) $this->evaluate($this->isTel);
    }

    public function isUrl(): bool
    {
        return (bool) $this->evaluate($this->isUrl);
    }
}
