<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * FormSelect component.
 *
 * Reusable select/dropdown with label and required flag.
 * Accepts options as an array or Collection (e.g. ['value' => 'Label'] or a list of ['value' => ..., 'label' => ...]).
 * Exposes typed public properties for convenient usage in Blade.
 */
class FormSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string                                       $name     Field name attribute
     * @param string                                       $label    Label text
     * @param \Illuminate\Support\Collection|array<mixed>  $options  Select options (key/value or list of value/label pairs)
     * @param string|null                                  $id       Explicit id; defaults to $name when null
     * @param bool                                         $required Whether the field is required
     */
    public function __construct(
        public string $name,
        public string $label,
        public \Illuminate\Support\Collection|array $options,
        public ?string $id = null,
        public bool $required = false
    ) {
        $this->id = $this->id ?? $name;
    }

    /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.form-select');
    }
}
