<?php

class __Mustache_10fcc02e6d3d3b8648dd0d287514d062 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="w-100">
';
        $buffer .= $indent . '    ';
        if ($parent = $this->mustache->loadPartial('core/search_input_auto')) {
            $context->pushBlockContext(array(
                'label' => array($this, 'block4c95f2fc29c656f5c9a243fab947cd45'),
                'placeholder' => array($this, 'block4c95f2fc29c656f5c9a243fab947cd45'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '</div>
';

        return $buffer;
    }

    private function section3e0b70d27dd8331d6fad893ac8df1f2d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            searchevents, block_timeline
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '
';
                $buffer .= $indent . '            searchevents, block_timeline
';
                $buffer .= $indent . '        ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block4c95f2fc29c656f5c9a243fab947cd45($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->section3e0b70d27dd8331d6fad893ac8df1f2d($context, $indent, $value);
    
        return $buffer;
    }
}
