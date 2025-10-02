<?php

namespace WireUi\View\Components;

class Textarea extends Input
{
    public bool $autosize;

    public function __construct(
        bool $autosize = false,
        bool $borderless = false,
        bool $shadowless = false,
        bool $disabled = false,
        ?string $label = null,
        ?string $hint = null,
        ?string $cornerHint = null,
        ?string $icon = null,
        ?string $rightIcon = null,
        ?string $prefix = null,
        ?string $suffix = null,
        ?string $prepend = null,
        ?string $append = null,
        bool $errorless = false,
        bool $spinner = false
    ) {
        $this->autosize = $autosize;

        parent::__construct(
            borderless: $borderless,
            shadowless: $shadowless,
            disabled: $disabled,
            label: $label,
            hint: $hint,
            cornerHint: $cornerHint,
            icon: $icon,
            rightIcon: $rightIcon,
            prefix: $prefix,
            suffix: $suffix,
            prepend: $prepend,
            append: $append,
            errorless: $errorless,
            spinner: $spinner
        );
    }

    protected function getView(): string
    {
        return 'wireui::components.textarea';
    }
}