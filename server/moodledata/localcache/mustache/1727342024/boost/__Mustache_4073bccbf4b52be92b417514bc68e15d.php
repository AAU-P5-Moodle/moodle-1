<?php

class __Mustache_4073bccbf4b52be92b417514bc68e15d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('editing');
        $buffer .= $this->section4f08a95a909fae3207a97c0241ed3faa($context, $indent, $value);
        $buffer .= '<div class="activity-item focus-control ';
        $value = $context->find('modstealth');
        $buffer .= $this->section814a15334b0fb146a25cc098588d4305($context, $indent, $value);
        $value = $context->find('modhiddenfromstudents');
        $buffer .= $this->section814a15334b0fb146a25cc098588d4305($context, $indent, $value);
        $value = $context->find('modinline');
        $buffer .= $this->sectionF4430bb1912fef25dc28340642a01da8($context, $indent, $value);
        $buffer .= '" data-activityname="';
        $value = $this->resolveValue($context->find('activityname'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-region="activity-card">
';
        $value = $context->find('cmbulk');
        $buffer .= $this->sectionE9af51cce24892a88f3c799498bd4f4c($context, $indent, $value);
        $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/activity');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/activity')) {
                $buffer .= $partial->renderInternal($context, $indent . '        ');
            }
        }
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section4f08a95a909fae3207a97c0241ed3faa(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{< core_courseformat/local/content/divider}}
        {{$content}}{{> core_course/activitychooserbuttonactivity}}{{/content}}
    {{/ core_courseformat/local/content/divider}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    ';
                if ($parent = $this->mustache->loadPartial('core_courseformat/local/content/divider')) {
                    $context->pushBlockContext(array(
                        'content' => array($this, 'block1b82aec019d73e7df55686907f00e0b8'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section814a15334b0fb146a25cc098588d4305(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'hiddenactivity';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'hiddenactivity';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF4430bb1912fef25dc28340642a01da8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'activityinline';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'activityinline';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE9af51cce24892a88f3c799498bd4f4c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/cm/bulkselect }}
            {{> core_courseformat/local/content/cm/bulkselect }}
        {{/ core_courseformat/local/content/cm/bulkselect }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/bulkselect');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/bulkselect')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block1b82aec019d73e7df55686907f00e0b8($context)
    {
        $indent = $buffer = '';
        if ($partial = $this->mustache->loadPartial('core_course/activitychooserbuttonactivity')) {
            $buffer .= $partial->renderInternal($context);
        }
    
        return $buffer;
    }
}
