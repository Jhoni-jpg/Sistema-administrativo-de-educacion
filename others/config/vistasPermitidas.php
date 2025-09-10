<?php

class VistasPermitidas
{
    public $vistas = [
        'login',
        'menuPrincipal',
        'panelAdministrativo',
        'registro',
        '404'
    ];

    public function validacionVistas($vista)
    {
        return is_string($vista) && in_array($vista, $this->vistas);
    }
}
