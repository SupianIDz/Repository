<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy\Validation;

use Octopy\HTTP\Request;

trait ValidationRequest
{
    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $instance = [];

    /**
     * @param Request $request
     * @param array   $rules
     */
    public function validate(Request $request, array $validations = [])
    {
        $this->init();

        $errors = [];
        foreach ($validations as $key => $rules) {
            if (!is_array($rules)) {
                $rules = explode('|', $rules);
            }

            foreach ($rules as $rule) {
                list($rule) = $array = explode(':', $rule);
                unset($array[0]);
                if (isset($this->rules[$rule])) {
                    $validator = $this->rules[$rule];

                    if ($validator->validate($request, $key, ...$array) == false) {
                        $errors[] = $validator->message($key);
                    }
                }
            }
        }

        if (count($errors) > 0) {
            if ($request->ajax()) {
                die(response()->json(array_reverse($errors), 422));
            }

            $message = [
                'errors' => array_reverse($errors)
            ];

            redirect()->flash($message)->back();
        }

        return true;
    }

    /**
     * @param  string   $class
     * @return instance
     */
    protected function call(string $class)
    {
        if (!isset($this->instance[$class])) {
            $this->instance[$class] = new $class;
        }

        return $this->instance[$class];
    }

    /**
     * @return void
     */
    protected function init()
    {
        if (empty($this->instance)) {
            $this->rules = [
               'bool'      => $this->call(Rule\BooleanRule::class),
               'boolean'   => $this->call(Rule\BooleanRule::class),
               'confirm'   => $this->call(Rule\ConfirmedRule::class),
               'confirmed' => $this->call(Rule\ConfirmedRule::class),
               'email'     => $this->call(Rule\EmailRule::class),
               'exist'     => $this->call(Rule\ExistsRule::class),
               'exists'    => $this->call(Rule\ExistsRule::class),
               'int'       => $this->call(Rule\IntegerRule::class),
               'integer'   => $this->call(Rule\IntegerRule::class),
               'ip'        => $this->call(Rule\IPRule::class),
               'max'       => $this->call(Rule\MaxRule::class),
               'min'       => $this->call(Rule\MinRule::class),
               'required'  => $this->call(Rule\RequiredRule::class),
               'string'    => $this->call(Rule\StringRule::class),
               'unique'    => $this->call(Rule\UniqueRule::class),
               'url'       => $this->call(Rule\URLRule::class),
            ];
        }
    }
}
