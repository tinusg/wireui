<?php

namespace WireUi\View\Components;

class Textarea extends Input
{
    public bool $autosize;

    public function __construct(
        bool $autosize = false,
        ?string $label = null,
        ?string $hint = null,
        ?string $cornerHint = null,
        ?string $icon = null,
        ?string $rightIcon = null,
        ?string $prefix = null,
        ?string $suffix = null,
        bool $shadowless = false,
        bool $disabled = false,
        ?string $name = null,
        ?string $id = null,
    ) {
        $this->autosize = $autosize; // Assign the autosize property

        parent::__construct(
            label: $label,
            hint: $hint,
            cornerHint: $cornerHint,
            icon: $icon,
            rightIcon: $rightIcon,
            prefix: $prefix,
            suffix: $suffix,
            shadowless: $shadowless,
            disabled: $disabled,
            name: $name,
            id: $id,
        );
    }

    protected function getView(): string
    {
        return 'wireui::components.textarea';
    }
}