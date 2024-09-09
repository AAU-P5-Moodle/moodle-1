<?php

class __Mustache_88b7f610c72e1147d96eda7f9a730f94 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_form/element-template')) {
            $context->pushBlockContext(array(
                'element' => array($this, 'block2ebd2bf03c28b6e8f04ef213c6707fa3'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }


    public function block2ebd2bf03c28b6e8f04ef213c6707fa3($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="form-control-static ';
        $value = $this->resolveValue($context->findDot('element.extraclasses'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '" data-name="';
        $value = $this->resolveValue($context->findDot('element.name'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->findDot('element.html'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }
}
