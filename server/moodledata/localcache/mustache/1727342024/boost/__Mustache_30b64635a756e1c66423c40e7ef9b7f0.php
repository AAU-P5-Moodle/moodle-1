<?php

class __Mustache_30b64635a756e1c66423c40e7ef9b7f0 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    id="sticky-footer"
';
        $buffer .= $indent . '    class="stickyfooter bg-white border-top"
';
        $blockFunction = $context->findInBlock('disable');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '        ';
            $value = $context->find('disable');
            $buffer .= $this->section352d85d73c1735100321ca105f9cdac8($context, $indent, $value);
            $buffer .= '
';
        }
        $blockFunction = $context->findInBlock('extradata');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $value = $context->find('extras');
            $buffer .= $this->section8663c70cb5613992d895ed06769af80b($context, $indent, $value);
        }
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div class="sticky-footer-content-wrapper h-100 d-flex justify-content-center">
';
        $buffer .= $indent . '        <div class="sticky-footer-content w-100 d-flex align-items-center px-3 py-2 ';
        $buffer .= ' ';
        $blockFunction = $context->findInBlock('stickyclasses');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $value = $context->find('stickyclasses');
            $buffer .= $this->section5a324ad1f27a187c309c4fa56c204493($context, $indent, $value);
            $value = $context->find('stickyclasses');
            if (empty($value)) {
                
                $buffer .= 'justify-content-end';
            }
        }
        $buffer .= '"
';
        $buffer .= $indent . '        >
';
        $blockFunction = $context->findInBlock('stickycontent');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '                ';
            $value = $this->resolveValue($context->find('stickycontent'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '
';
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->sectionFbf7b40af65ed927c255038621474dd0($context, $indent, $value);

        return $buffer;
    }

    private function section352d85d73c1735100321ca105f9cdac8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' data-disable="true" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' data-disable="true" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8663c70cb5613992d895ed06769af80b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{attribute}}="{{value}}"
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('attribute'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5a324ad1f27a187c309c4fa56c204493(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{ stickyclasses }}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('stickyclasses'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFbf7b40af65ed927c255038621474dd0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'theme_boost/sticky-footer\'], function(footer) {
    footer.init();
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'theme_boost/sticky-footer\'], function(footer) {
';
                $buffer .= $indent . '    footer.init();
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
