<?php

class __Mustache_e59b3f72291df745c260e340b0bd773d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="section_availability">
';
        $value = $context->find('hasavailability');
        $buffer .= $this->section9fe55c400425460e1ef34accc977692c($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section2fb22ee6cecdc53eba9991668a181271(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{> core_courseformat/local/content/availability }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/availability')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD55c83b074f37fd788c21336e8fecca3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="availabilityinfo {{classes}}" data-region="availabilityinfo">
        {{^isrestricted}}
            <span class="badge rounded-pill bg-warning text-dark">{{{text}}}</span>
        {{/isrestricted}}
        {{#isrestricted}}
            {{> core_courseformat/local/content/availability }}
        {{/isrestricted}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="availabilityinfo ';
                $value = $this->resolveValue($context->find('classes'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-region="availabilityinfo">
';
                $value = $context->find('isrestricted');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <span class="badge rounded-pill bg-warning text-dark">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '</span>
';
                }
                $value = $context->find('isrestricted');
                $buffer .= $this->section2fb22ee6cecdc53eba9991668a181271($context, $indent, $value);
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9fe55c400425460e1ef34accc977692c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{#info}}
        <div class="availabilityinfo {{classes}}" data-region="availabilityinfo">
        {{^isrestricted}}
            <span class="badge rounded-pill bg-warning text-dark">{{{text}}}</span>
        {{/isrestricted}}
        {{#isrestricted}}
            {{> core_courseformat/local/content/availability }}
        {{/isrestricted}}
        </div>
    {{/info}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('info');
                $buffer .= $this->sectionD55c83b074f37fd788c21336e8fecca3($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
