<?php

class __Mustache_0275e440eaa4d26fc5360a523f7760f4 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('uservisible');
        $buffer .= $this->sectionF50b1f5ae25224e6acaa443f4788773f($context, $indent, $value);
        $value = $context->find('uservisible');
        if (empty($value)) {
            
            $buffer .= $indent . '    <span class="instancename">
';
            $buffer .= $indent . '        ';
            $value = $this->resolveValue($context->find('instancename'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= ' ';
            $value = $this->resolveValue($context->find('altname'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '
';
            $buffer .= $indent . '    </span>
';
        }

        return $buffer;
    }

    private function sectionF50b1f5ae25224e6acaa443f4788773f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <a href="{{url}}" class="{{linkclasses}} aalink stretched-link" onclick="{{{onclick}}}">
        <span class="instancename">{{{instancename}}} {{{altname}}}</span>
    </a>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="';
                $value = $this->resolveValue($context->find('linkclasses'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' aalink stretched-link" onclick="';
                $value = $this->resolveValue($context->find('onclick'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '">
';
                $buffer .= $indent . '        <span class="instancename">';
                $value = $this->resolveValue($context->find('instancename'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('altname'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '    </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
