<?php

class __Mustache_f01caae97d2617b5cd4c59f6e22e5002 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="add_block_button">
';
        $buffer .= $indent . '    <a href="';
        $value = $this->resolveValue($context->find('link'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" id="addblock-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="btn btn-link block-add text-start mb-3" data-key="addblock"
';
        $buffer .= $indent . '            data-url="';
        $value = $this->resolveValue($context->find('escapedlink'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-blockregion="';
        $value = $this->resolveValue($context->find('blockregion'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '        <i class="fa fa-plus py-2 me-3" aria-hidden="true"></i>';
        $value = $context->find('str');
        $buffer .= $this->section01c4df664c89cfcff5e9a8f2e1bca393($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    </a>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->section125ef8b0ba7e1bdadce90e1f06f1d255($context, $indent, $value);

        return $buffer;
    }

    private function section01c4df664c89cfcff5e9a8f2e1bca393(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'addblock';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'addblock';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section125ef8b0ba7e1bdadce90e1f06f1d255(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    // Initialise the JS for the modal window which displays the blocks available to add.
    require([\'core_block/add_modal\'], function(addBlockModal) {
        addBlockModal.init(null, \'{{pagehash}}\');
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    // Initialise the JS for the modal window which displays the blocks available to add.
';
                $buffer .= $indent . '    require([\'core_block/add_modal\'], function(addBlockModal) {
';
                $buffer .= $indent . '        addBlockModal.init(null, \'';
                $value = $this->resolveValue($context->find('pagehash'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '\');
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
