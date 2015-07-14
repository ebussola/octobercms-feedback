<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 28/06/15
 * Time: 10:19
 */

namespace eBussola\Feedback\Classes;


interface Method
{

    /**
     * Used to register new form fields to Channel.
     * Modify and prepare Channel model.
     *
     * @return void
     */
    public function boot();

    /**
     * @param array $methodData
     * @param array $data
     * @return mixed
     */
    public function send($methodData, $data);

}