<?php

class __Mustache_93354a1ecf0018e529b63be3f7d7f51d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<li id="section-';
        $value = $this->resolveValue($context->find('num'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    class="section course-section main ';
        $value = $context->find('onlysummary');
        $buffer .= $this->sectionA0d9db6ba11d7b6bcca170f8d7ae948d($context, $indent, $value);
        $buffer .= ' clearfix
';
        $buffer .= $indent . '            ';
        $value = $context->find('ishidden');
        $buffer .= $this->section5a8152d3d9f2c97a8df7cb314c7a68ea($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('iscurrent');
        $buffer .= $this->section31bea27d446e2e1908e8a813063dd1b1($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            ';
        $value = $context->find('isstealth');
        $buffer .= $this->sectionDd936c2a69a972ffdd63f1e0216d6abb($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '    data-sectionid="';
        $value = $this->resolveValue($context->find('num'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-sectionreturnnum="';
        $value = $this->resolveValue($context->find('sectionreturnnum'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-for="section"
';
        $buffer .= $indent . '    data-id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-number="';
        $value = $this->resolveValue($context->find('num'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-sectionname="';
        $value = $this->resolveValue($context->find('sectionname'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div class="section-item">
';
        $blockFunction = $context->findInBlock('core_courseformat/local/content/section/content');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/content')) {
                $buffer .= $partial->renderInternal($context, $indent . '            ');
            }
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $value = $context->find('insertafter');
        $buffer .= $this->section3931fbbb84b2c364dcdbbf5fe9a2bd34($context, $indent, $value);
        $buffer .= $indent . '</li>
';

        return $buffer;
    }

    private function sectionA0d9db6ba11d7b6bcca170f8d7ae948d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' section-summary ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' section-summary ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5a8152d3d9f2c97a8df7cb314c7a68ea(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' hidden ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' hidden ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section31bea27d446e2e1908e8a813063dd1b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{^displayonesection}} current {{/displayonesection}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('displayonesection');
                if (empty($value)) {
                    
                    $buffer .= ' current ';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDd936c2a69a972ffdd63f1e0216d6abb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' orphaned ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' orphaned ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section80681517d0ac9da5095c71f076caa0a2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/addsection}}
                {{> core_courseformat/local/content/section/addsectiondivider }}
            {{/ core_courseformat/local/content/addsection}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/addsection');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/addsectiondivider')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3931fbbb84b2c364dcdbbf5fe9a2bd34(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#numsections}}
            {{$ core_courseformat/local/content/addsection}}
                {{> core_courseformat/local/content/section/addsectiondivider }}
            {{/ core_courseformat/local/content/addsection}}
        {{/numsections}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('numsections');
                $buffer .= $this->section80681517d0ac9da5095c71f076caa0a2($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
