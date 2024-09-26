<?php

class __Mustache_d26f36fb2554e2d5d8b025e078be9c63 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('editing');
        $buffer .= $this->section792b56bd73b9cb504afebb1fc51543f4($context, $indent, $value);
        $value = $context->find('editing');
        if (empty($value)) {
            
            $value = $context->find('iscurrent');
            $buffer .= $this->section55406230f738b2daf3e812bbc2ec1e19($context, $indent, $value);
        }
        $value = $context->find('visibility');
        $buffer .= $this->sectionEc80b711fbc230bff4bd2e0a88b302e8($context, $indent, $value);

        return $buffer;
    }

    private function section792b56bd73b9cb504afebb1fc51543f4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <span class="badge rounded-pill bg-primary text-white order-1 {{^iscurrent}}d-none{{/iscurrent}}" data-type="iscurrent">
        {{ highlightedlabel }}
    </span>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <span class="badge rounded-pill bg-primary text-white order-1 ';
                $value = $context->find('iscurrent');
                if (empty($value)) {
                    
                    $buffer .= 'd-none';
                }
                $buffer .= '" data-type="iscurrent">
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('highlightedlabel'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '    </span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section55406230f738b2daf3e812bbc2ec1e19(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <span class="badge rounded-pill bg-primary text-white order-1">{{ highlightedlabel }}</span>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <span class="badge rounded-pill bg-primary text-white order-1">';
                $value = $this->resolveValue($context->find('highlightedlabel'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEc80b711fbc230bff4bd2e0a88b302e8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{>core_courseformat/local/content/section/visibility}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/visibility')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
