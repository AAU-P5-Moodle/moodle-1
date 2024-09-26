<?php

class __Mustache_79c812f14cdc1ae84bdcd0caa183d2ba extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('summarytext');
        $buffer .= $this->section2f3e482e4efde18fbdfd5349c3ccf1b9($context, $indent, $value);

        return $buffer;
    }

    private function section2f3e482e4efde18fbdfd5349c3ccf1b9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="summarytext">
        {{{summarytext}}}
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="summarytext">
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('summarytext'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
