<?php

class HomeController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

	public function getHome()
	{
        $data = array(
            'breadcrumb' => array(
                array(
                    'url' => '#',
                    'label' => 'PcPerfomance'
                ),
                array(
                    'url' => '',
                    'label' => 'Panoramica'
                ),
            ),
        );
		return View::make('pages.index', $data);
	}

}
