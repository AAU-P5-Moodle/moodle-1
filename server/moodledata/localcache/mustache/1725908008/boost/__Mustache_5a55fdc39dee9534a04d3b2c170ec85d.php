<?php

class __Mustache_5a55fdc39dee9534a04d3b2c170ec85d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('welcomemessage');
        $buffer .= $this->sectionF07c060c3cf74b9c105ef38fb6d61436($context, $indent, $value);

        return $buffer;
    }

    private function sectionF07c060c3cf74b9c105ef38fb6d61436(Mustache_Context $context, $indent, $value)
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
