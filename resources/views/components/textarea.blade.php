@php
    $hasError = false;
    if ($name) { $hasError = $errors->has($name); }

    // Auto-resize configuration
    $rows = $attributes->get('rows', 4);
    $initialHeight = ($rows * 1.5) + 0.75;
@endphp
<div class="@if($disabled) opacity-60 @endif">
    @if ($label || $cornerHint)
        <div class="flex {{ !$label && $cornerHint ? 'justify-end' : 'justify-between' }} mb-1">
            @if ($label)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$label"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif
            @if ($cornerHint)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$cornerHint"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif
        </div>
    @endif
    <div class="relative rounded-md @unless($shadowless) shadow-sm @endunless">
        @if ($prefix || $icon)
            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none
                {{ $hasError ? 'text-negative-500' : 'text-secondary-400' }}">
                @if ($icon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$icon"
                        class="w-5 h-5"
                    />
                @elseif($prefix)
                    <span class="flex items-center self-center pl-1">
                        {{ $prefix }}
                    </span>
                @endif
            </div>
        @elseif($prepend)
            {{ $prepend }}
        @endif

        @if ($autosize)
            <textarea
                x-data="textareaAutosize({
                    initialHeight: {{ $initialHeight }},
                    shouldAutosize: true
                })"
                x-init="render()"
                x-intersect.once="resize()"
                x-on:resize.window="resize()"
                x-on:input="resize()"
                {{ $attributes->class([
                    $getInputClasses($hasError),
                    'resize-none [field-sizing:content]'
                ])->merge([
                    'autocomplete' => 'off',
                    'rows' => $rows
                ]) }}
                style="min-height: {{ $initialHeight }}rem;"
            >{{ $slot }}</textarea>
        @else
            <textarea {{ $attributes->class([
                $getInputClasses($hasError),
            ])->merge([
                'autocomplete' => 'off',
                'rows' => $rows
            ]) }}>{{ $slot }}</textarea>
        @endif

        @if ($suffix || $rightIcon || ($hasError && !$append))
            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none
                {{ $hasError ? 'text-negative-500' : 'text-secondary-400' }}">
                @if ($rightIcon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$rightIcon"
                        class="w-5 h-5"
                    />
                @elseif($suffix)
                    <span class="flex items-center justify-center pr-1">
                        {{ $suffix }}
                    </span>
                @elseif($hasError)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        name="exclamation-circle"
                        class="w-5 h-5"
                    />
                @endif
            </div>
        @elseif($append)
            {{ $append }}
        @endif
    </div>
    @if (!$hasError && $hint)
        <label @if($id) for="{{ $id }}" @endif class="mt-2 text-sm text-secondary-500 dark:text-secondary-400">
            {{ $hint }}
        </label>
    @endif
    @if ($name)
        <x-dynamic-component
            :component="WireUi::component('error')"
            :name="$name"
        />
    @endif
</div>

@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('textareaAutosize', (config) => ({
        initialHeight: config.initialHeight,
        shouldAutosize: config.shouldAutosize,
        supportsFieldSizing: false,

        init() {
            // Check if browser supports field-sizing CSS property
            this.supportsFieldSizing = CSS.supports('field-sizing', 'content');

            // Only use JavaScript fallback if field-sizing is not supported
            if (!this.supportsFieldSizing) {
                this.render();
            }
        },

        render() {
            if (this.supportsFieldSizing) return;

            if (this.$el.scrollHeight > 0) {
                this.$el.style.height = this.initialHeight + 'rem';
                this.$el.style.height = this.$el.scrollHeight + 'px';
            }
        },

        resize() {
            if (this.shouldAutosize && !this.supportsFieldSizing) {
                this.render();
            }
        }
    }));
});
</script>
@endpush
@endonce