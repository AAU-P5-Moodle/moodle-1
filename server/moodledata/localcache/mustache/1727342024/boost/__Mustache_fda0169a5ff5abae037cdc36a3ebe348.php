<?php

class __Mustache_fda0169a5ff5abae037cdc36a3ebe348 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('welcomemessage');
        $buffer .= $this->section745ea26f5ea73867b61a7f99b6ab757c($context, $indent, $value);

        return $buffer;
    }

    private function section745ea26f5ea73867b61a7f99b6ab757c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<h1 class="h2 mb-3 mt-3">
    {{.}}
</h1>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<h1 class="h2 mb-3 mt-3">
';
                $buffer .= $indent . '    ';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '</h1>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
