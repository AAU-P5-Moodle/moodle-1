<?php

class __Mustache_8aadfffd3d63520984e3f374ef8cfc90 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_form/element-template')) {
            $context->pushBlockContext(array(
                'label' => array($this, 'block8ba734896a39b23a48efef3f149d2495'),
                'element' => array($this, 'blockB4d08157320bcb5a9b61f9c188be6827'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $value = $context->find('js');
        $buffer .= $this->section56fd17f69e849b6be9cc7089a60df864($context, $indent, $value);

        return $buffer;
    }

    private function section7ba672f1b2cab39c23438b6336d8ba28(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{{separator}}}
                    {{{html}}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('separator'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('html'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1a794ca08ce17239f5a7b7e2d4dec091(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <fieldset class="w-100 m-0 p-0 border-0">
                <legend class="sr-only">{{label}}</legend>
                <div class="d-flex flex-wrap align-items-center">
                {{#element.elements}}
                    {{{separator}}}
                    {{{html}}}
                {{/element.elements}}
                </div>
            </fieldset>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <fieldset class="w-100 m-0 p-0 border-0">
';
                $buffer .= $indent . '                <legend class="sr-only">';
                $value = $this->resolveValue($context->find('label'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</legend>
';
                $buffer .= $indent . '                <div class="d-flex flex-wrap align-items-center">
';
                $value = $context->findDot('element.elements');
                $buffer .= $this->section7ba672f1b2cab39c23438b6336d8ba28($context, $indent, $value);
                $buffer .= $indent . '                </div>
';
                $buffer .= $indent . '            </fieldset>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section56fd17f69e849b6be9cc7089a60df864(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'jquery\'], function($) {
    $(\'#{{element.id}}_label\').css(\'cursor\', \'default\');
    $(\'#{{element.id}}_label\').click(function() {
        $(\'#{{element.id}}\')
            .find(\'button, a, input:not([type="hidden"]), select, textarea, [tabindex]\')
            .filter(\':not([disabled]):not([tabindex="0"]):not([tabindex="-1"])\')
            .first().focus();
    });
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'jquery\'], function($) {
';
                $buffer .= $indent . '    $(\'#';
                $value = $this->resolveValue($context->findDot('element.id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '_label\').css(\'cursor\', \'default\');
';
                $buffer .= $indent . '    $(\'#';
                $value = $this->resolveValue($context->findDot('element.id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '_label\').click(function() {
';
                $buffer .= $indent . '        $(\'#';
                $value = $this->resolveValue($context->findDot('element.id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '\')
';
                $buffer .= $indent . '            .find(\'button, a, input:not([type="hidden"]), select, textarea, [tabindex]\')
';
                $buffer .= $indent . '            .filter(\':not([disabled]):not([tabindex="0"]):not([tabindex="-1"])\')
';
                $buffer .= $indent . '            .first().focus();
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block8ba734896a39b23a48efef3f149d2495($context)
    {
        $indent = $buffer = '';
        $value = $context->findDot('element.hiddenlabel');
        if (empty($value)) {
            
            $buffer .= $indent . '            <p id="';
            $value = $this->resolveValue($context->findDot('element.id'), $context);
            $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
            $buffer .= '_label" class="mb-0 word-break" aria-hidden="true">
';
            $buffer .= $indent . '                ';
            $value = $this->resolveValue($context->find('label'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '
';
            $buffer .= $indent . '            </p>
';
        }
    
        return $buffer;
    }

    public function blockB4d08157320bcb5a9b61f9c188be6827($context)
    {
        $indent = $buffer = '';
        $value = $context->find('label');
        $buffer .= $this->section1a794ca08ce17239f5a7b7e2d4dec091($context, $indent, $value);
        $value = $context->find('label');
        if (empty($value)) {
            
            $buffer .= $indent . '            <div class="w-100 m-0 p-0 border-0">
';
            $buffer .= $indent . '                <div class="d-flex flex-wrap align-items-center">
';
            $value = $context->findDot('element.elements');
            $buffer .= $this->section7ba672f1b2cab39c23438b6336d8ba28($context, $indent, $value);
            $buffer .= $indent . '                </div>
';
            $buffer .= $indent . '            </div>
';
        }
    
        return $buffer;
    }
}
