<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


/**
 * FormArea component.
 *
 * Reusable textarea input with label, placeholder, rows, and initial value.
 * Exposes typed public properties for easy usage in Blade.
 */
class FormArea extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string      $name        Field name attribute
     * @param string      $label       Optional label text
     * @param string|null $id          Explicit id; defaults to $name when null
     * @param string|null $placeholder Optional placeholder text
     * @param int         $rows        Number of visible text rows
     * @param string|null $value       Initial value
     */
    public function __construct(
        public string $name,
        public string $label = '',
        public ?string $id = null,
        public ?string $placeholder = '',
        public int $rows = 4,
        public ?string $value = null,
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
        return view('components.layouts.form-area');
    }
}
