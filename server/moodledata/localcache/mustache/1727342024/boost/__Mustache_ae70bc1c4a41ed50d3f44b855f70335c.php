<?php

class __Mustache_ae70bc1c4a41ed50d3f44b855f70335c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_view_overview_section')) {
            $context->pushBlockContext(array(
                'region' => array($this, 'block0d825094e3f87721e5aeacfebed18011'),
                'title' => array($this, 'blockD321e2bb257172de201811ec0f745d41'),
                'placeholder' => array($this, 'blockF2ca03fecb95f213685459140a6ae494'),
                'notification' => array($this, 'blockFba79f52b05b872af213c479cd5de951'),
                'emptymessage' => array($this, 'block192ec322255dde7b32098d2004cb0226'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }

    private function sectionF36d9c53138ae56f420c83046248fd3c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' individualconversations, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' individualconversations, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3fcf7163e20dba460a3ac16a4bdfb6d3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="text-center p-2">
                <p class="text-center text-muted mt-2">{{.}}</p>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="text-center p-2">
';
                $buffer .= $indent . '                <p class="text-center text-muted mt-2">';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</p>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section088ffe8d586f44aaabcd5c09cc823693(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' noindividualconversations, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' noindividualconversations, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block0d825094e3f87721e5aeacfebed18011($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'view-overview-messages';
    
        return $buffer;
    }

    public function blockD321e2bb257172de201811ec0f745d41($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->sectionF36d9c53138ae56f420c83046248fd3c($context, $indent, $value);
    
        return $buffer;
    }

    public function blockF2ca03fecb95f213685459140a6ae494($context)
    {
        $indent = $buffer = '';
        $buffer .= '        <div class="text-center py-2">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</div>
';
    
        return $buffer;
    }

    public function blockFba79f52b05b872af213c479cd5de951($context)
    {
        $indent = $buffer = '';
        $value = $context->findDot('overview.notification');
        $buffer .= $this->section3fcf7163e20dba460a3ac16a4bdfb6d3($context, $indent, $value);
    
        return $buffer;
    }

    public function block192ec322255dde7b32098d2004cb0226($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <p class="text-muted mt-2">';
        $value = $context->find('str');
        $buffer .= $this->section088ffe8d586f44aaabcd5c09cc823693($context, $indent, $value);
        $buffer .= '</p>
';
    
        return $buffer;
    }
}
