<?php

namespace App\View\Components;

use Closure;
use App\Models\MenuGroup;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CobaComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menus = MenuGroup::query()
            ->with('items', function ($query) {
                return $query->where('status', true)->orderBy('posision');
            })
            ->where('status', true)
            ->orderBy('posision')
            ->get();
        return view('components.coba-component', compact('menus'));
    }
}
