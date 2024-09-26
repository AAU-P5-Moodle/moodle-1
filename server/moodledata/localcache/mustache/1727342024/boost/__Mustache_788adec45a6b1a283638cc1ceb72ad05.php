<?php

class __Mustache_788adec45a6b1a283638cc1ceb72ad05 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_lazy_load_list')) {
            $context->pushBlockContext(array(
                'emptymessage' => array($this, 'blockAbb2813073cfc8e8d723ad40c70822db'),
                'placeholder' => array($this, 'blockB7bbd9022515fa687b787d4e4ecab659'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }

    private function section2b767af6e1d621ba662cc2f533844b46(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' nocontactsgetstarted, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . ' nocontactsgetstarted, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section084eef2c431ba5ae3219bd1c27b59b13(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{> core_message/message_drawer_contacts_list_item_placeholder }}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_message/message_drawer_contacts_list_item_placeholder')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9dfb54734f40cd6d3edfdd2a69dfe244(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#placeholders}}
                    {{> core_message/message_drawer_contacts_list_item_placeholder }}
                {{/placeholders}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('placeholders');
                $buffer .= $this->section084eef2c431ba5ae3219bd1c27b59b13($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2f54883e1fe5956f228545b906d54552(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#sectioncontacts}}
                {{#placeholders}}
                    {{> core_message/message_drawer_contacts_list_item_placeholder }}
                {{/placeholders}}
            {{/sectioncontacts}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('sectioncontacts');
                $buffer .= $this->section9dfb54734f40cd6d3edfdd2a69dfe244($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockAbb2813073cfc8e8d723ad40c70822db($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->section2b767af6e1d621ba662cc2f533844b46($context, $indent, $value);
    
        return $buffer;
    }

    public function blockB7bbd9022515fa687b787d4e4ecab659($context)
    {
        $indent = $buffer = '';
        $value = $context->find('contacts');
        $buffer .= $this->section2f54883e1fe5956f228545b906d54552($context, $indent, $value);
    
        return $buffer;
    }
}
