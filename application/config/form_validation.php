<?php

$config =
    array(
    'usuario_form'=> array(
                    'nome'              => array('field' => 'nome',             'label' => 'nome',              'rules'  => 'required'),
                    'email'             => array('field' => 'email',            'label' => 'email',             'rules'  => 'required|valid_email'),
                    'senha'             => array('field' => 'senha',            'label' => 'senha',             'rules'  => 'required'),       
        )
    );

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

