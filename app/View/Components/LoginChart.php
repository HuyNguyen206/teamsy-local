<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LoginChart extends Component
{

    /**
     * The alert message.
     *
     * @var string
     */
    public $chart;

    /**
     * Create the component instance.
     *
     * @param $chart
     */
    public function __construct()
    {
        $chart = new \App\Charts\LoginChart();
        $api = route('login-chart');

        $chart->labels(['Total subscribers', 'Total users', 'Total logins'])
            ->load($api);
        $this->chart = $chart;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.login-chart');
    }
}
