<?php

class __Mustache_45452084c334517f11d508583f34805f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="d-flex flex-column choicelist p-1" role="listbox">
';
        $value = $context->find('options');
        $buffer .= $this->section72dc69e24a36ed27c6c0a011b00cd3a6($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section72dc69e24a36ed27c6c0a011b00cd3a6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{> core/local/choicelist/option}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/local/choicelist/option')) {
                    $buffer .= $partial->renderInternal($context, $indent . '        ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
