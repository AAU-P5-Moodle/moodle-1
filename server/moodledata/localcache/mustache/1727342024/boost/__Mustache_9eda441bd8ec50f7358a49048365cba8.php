<?php

class __Mustache_9eda441bd8ec50f7358a49048365cba8 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        if ($partial = $this->mustache->loadPartial('core_form/element-select')) {
            $buffer .= $partial->renderInternal($context);
        }

        return $buffer;
    }
}
