<?php

class __Mustache_bf5a39957ee817269be554ec4eeaa711 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core/local/dropdown/dialog')) {
            $context->pushBlockContext(array(
                'dialogcontent' => array($this, 'block410f06fed9965261c8f373cc2a9b6588'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $value = $context->find('js');
        $buffer .= $this->section18a4e4ca6562292cd57f1e95dd06651c($context, $indent, $value);

        return $buffer;
    }

    private function sectionCdbd60ad1f742d1a0d69a6418a0c9e7c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="pb-2 border-bottom">{{{dialogcontent}}}</div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="pb-2 border-bottom">';
                $value = $this->resolveValue($context->find('dialogcontent'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section230af54d2f5ed0c2fd68d2ec453193d3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{> core/local/choicelist }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/local/choicelist')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5851aa9ef2803f3a4bcc89fb492924cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{dropdownid}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('dropdownid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section18a4e4ca6562292cd57f1e95dd06651c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'core/local/dropdown/status\'], function(Module) {
        Module.init(\'#\' + \'{{$ dropdownid }}{{!
            }}{{#dropdownid}}{{dropdownid}}{{/dropdownid}}{{!
            }}{{^dropdownid}}dropdownDialog_{{uniqid}}{{/dropdownid}}{{!
        }}{{/ dropdownid }}\');
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'core/local/dropdown/status\'], function(Module) {
';
                $buffer .= $indent . '        Module.init(\'#\' + \'';
                $blockFunction = $context->findInBlock('dropdownid');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    $value = $context->find('dropdownid');
                    $buffer .= $this->section5851aa9ef2803f3a4bcc89fb492924cb($context, $indent, $value);
                    $value = $context->find('dropdownid');
                    if (empty($value)) {
                        
                        $buffer .= 'dropdownDialog_';
                        $value = $this->resolveValue($context->find('uniqid'), $context);
                        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    }
                }
                $buffer .= '\');
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block410f06fed9965261c8f373cc2a9b6588($context)
    {
        $indent = $buffer = '';
        $value = $context->find('dialogcontent');
        $buffer .= $this->sectionCdbd60ad1f742d1a0d69a6418a0c9e7c($context, $indent, $value);
        $value = $context->find('choices');
        $buffer .= $this->section230af54d2f5ed0c2fd68d2ec453193d3($context, $indent, $value);
    
        return $buffer;
    }
}
