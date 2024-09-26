<?php

class __Mustache_90078c8c02b504438c72edc459039319 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('isInteractive');
        $buffer .= $this->section6a2a333d129687a596a82c8f2df333bb($context, $indent, $value);
        $value = $context->find('isInteractive');
        if (empty($value)) {
            
            $buffer .= $indent . '    <div
';
            $buffer .= $indent . '    data-region="groupmode-information"
';
            $buffer .= $indent . '    data-activityname="';
            $value = $this->resolveValue($context->find('activityname'), $context);
            $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
            $buffer .= '"
';
            $buffer .= $indent . '    class="groupmode-information d-flex align-items-center justify-content-center icon-no-margin"
';
            $buffer .= $indent . '>
';
            $buffer .= $indent . '    ';
            $value = $context->find('groupicon');
            $buffer .= $this->sectionBe67a45eb42e98accc75b5c263d6b289($context, $indent, $value);
            $buffer .= '
';
            $value = $context->find('groupalt');
            $buffer .= $this->section067133a6a73b7644dd622d3e9e762693($context, $indent, $value);
            $buffer .= $indent . '</div>
';
        }

        return $buffer;
    }

    private function section32db0b198771114975407fc1b32ded20(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' v-parent-focus ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' v-parent-focus ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD6d2dacc4137336208f96479528b04eb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{< core/local/dropdown/status}}
            {{$ buttonclasses }}
                {{#autohide}} v-parent-focus {{/autohide}}
                groupmode-information btn btn-icon icon-no-margin
            {{/ buttonclasses }}
            {{$ buttoncontent }}
                {{{groupicon}}}
                <span class="groupmode-icon-info">{{groupalt}}</span>
            {{/ buttoncontent }}
        {{/ core/local/dropdown/status}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        ';
                if ($parent = $this->mustache->loadPartial('core/local/dropdown/status')) {
                    $context->pushBlockContext(array(
                        'buttonclasses' => array($this, 'block1043f1d8ff27f6453a6d4d488950710b'),
                        'buttoncontent' => array($this, 'block6ca235ee2518468a745b0d63291d573c'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6a2a333d129687a596a82c8f2df333bb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{#dropwdown}}
        {{< core/local/dropdown/status}}
            {{$ buttonclasses }}
                {{#autohide}} v-parent-focus {{/autohide}}
                groupmode-information btn btn-icon icon-no-margin
            {{/ buttonclasses }}
            {{$ buttoncontent }}
                {{{groupicon}}}
                <span class="groupmode-icon-info">{{groupalt}}</span>
            {{/ buttoncontent }}
        {{/ core/local/dropdown/status}}
    {{/dropwdown}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('dropwdown');
                $buffer .= $this->sectionD6d2dacc4137336208f96479528b04eb($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBe67a45eb42e98accc75b5c263d6b289(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{groupicon}}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('groupicon'), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section067133a6a73b7644dd622d3e9e762693(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="groupmode-icon-info ms-1">{{groupalt}}</div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="groupmode-icon-info ms-1">';
                $value = $this->resolveValue($context->find('groupalt'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block1043f1d8ff27f6453a6d4d488950710b($context)
    {
        $indent = $buffer = '';
        $buffer .= '                ';
        $value = $context->find('autohide');
        $buffer .= $this->section32db0b198771114975407fc1b32ded20($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                groupmode-information btn btn-icon icon-no-margin
';
    
        return $buffer;
    }

    public function block6ca235ee2518468a745b0d63291d573c($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '                ';
        $value = $this->resolveValue($context->find('groupicon'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '                <span class="groupmode-icon-info">';
        $value = $this->resolveValue($context->find('groupalt'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>
';
    
        return $buffer;
    }
}
