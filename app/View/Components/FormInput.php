<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


/**
 * FormInput component.
 *
 * Reusable text-like input with label, placeholder, and optional preset value.
 * Exposes typed public properties for convenient usage in Blade.
 */
class FormInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string      $name        Field name attribute
     * @param string      $label       Optional label text
     * @param string      $type        Input type (e.g. text, email, password)
     * @param string|null $id          Explicit id; defaults to $name when null
     * @param string|null $value       Initial value
     * @param string|null $placeholder Optional placeholder text
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $type = 'text',
        public ?string $id = null,
        public ?string $value = null,
        public ?string $placeholder = '',
        )

    {
        $this->id = $this->id ?? $name;
    }

   /**
     * Get the view/contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.form-input');
    }
}
