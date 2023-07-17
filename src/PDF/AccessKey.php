<?php

namespace Partymeister\Competitions\PDF;

/**
 * Class AccessKey
 */
class AccessKey extends PDF
{

    protected $paginator;

    public function __construct($paginator)
    {
        parent::__construct();

        $this->paginator = $paginator;

        $this->setMargins(5, 5, 5);
        $this->AddStyle('URL', 'Courier', '', 12);
        $this->AddStyle('Accesskey', 'Courier', 'B', 14);
        $this->setAutoPageBreak(false);
        $this->setTemplate('logo', resource_path('assets/pdf/partymeister-competitions-accesskey'));
    }

    public function generate()
    {
        $this->addPage();
        foreach ($this->paginator as $key => $row) {
            if ($key % 2 == 0) {
                $x_offset = 0;
            } else {
                $x_offset = 100;
            }
            $this->useTemplate('logo', 10 + $x_offset, $this->getY(), 30);
            $y = $this->getY();
            $this->SetStyle('URL');
            $this->multiCell(100, 20, "https://party.evoke.eu", 0, 'L', 0, 1, $x_offset + 45, $y + 6);
            $this->SetStyle('Accesskey');
            $this->multiCell(100, 20, $row->access_key, 0, 'L', 0, 1, $x_offset + 45, $y + 12);
            $this->setY($y);

            if ($key % 2 == 1) {
                $this->setY($this->getY() + 22);
                if ($this->getY() > 280) {
                    $this->SetStyle('Accesskey');
                    $this->addPage();
                }
            }
        }
    }
}
