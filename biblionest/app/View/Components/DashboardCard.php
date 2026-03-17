<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public string $title;
    public string $value;
    public string $class;

    public function __construct(string $title, string $value, string $class = '')
    {
        $this->title = $title;
        $this->value = $value;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
