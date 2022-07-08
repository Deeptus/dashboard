<?php

namespace AporteWeb\Dashboard\View\Components;

use Illuminate\View\Component;

class SidebarMenu extends Component {
    public $name;
    public $active;
    public $label;

    public function __construct($name, $active, $label) {
        $this->name = $name;
        $this->active = $active;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Dashboard::components.sidebar-menu', [
            'name' => $this->name,
            'active' => $this->active,
            'label' => $this->label,
        ]);
    }
}
