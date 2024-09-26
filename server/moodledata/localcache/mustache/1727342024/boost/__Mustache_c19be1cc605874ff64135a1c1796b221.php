<?php

class __Mustache_c19be1cc605874ff64135a1c1796b221 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<li
';
        $buffer .= $indent . '    class="activity activity-wrapper ';
        $value = $this->resolveValue($context->find('module'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' modtype_';
        $value = $this->resolveValue($context->find('module'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' ';
        $value = $this->resolveValue($context->find('extraclasses'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' ';
        $value = $context->find('hasinfo');
        $buffer .= $this->section83f4cf4620de8b26d812ca106e959b0f($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('indent');
        $buffer .= $this->sectionEbc4fd45515e24a21412ca7c393ea1db($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '    id="';
        $value = $this->resolveValue($context->find('anchor'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-for="cmitem"
';
        $buffer .= $indent . '    data-id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '>
';
        $value = $context->find('cmformat');
        $buffer .= $this->section6e810ffcb04ab308c6c0ed6d39c82e87($context, $indent, $value);
        $buffer .= $indent . '</li>
';

        return $buffer;
    }

    private function section83f4cf4620de8b26d812ca106e959b0f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'hasinfo';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'hasinfo';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEbc4fd45515e24a21412ca7c393ea1db(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'indented';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'indented';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6e810ffcb04ab308c6c0ed6d39c82e87(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{$ core_courseformat/local/content/cm}}
        {{> core_courseformat/local/content/cm}}
    {{/ core_courseformat/local/content/cm}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm')) {
                        $buffer .= $partial->renderInternal($context, $indent . '        ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
